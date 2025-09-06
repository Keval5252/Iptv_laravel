<?php

namespace App\Services;

use App\Models\SubscriptionPlan;
use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripePlanService
{
    public function __construct()
    {
        $stripeSecret = config('services.stripe.secret');
        if ($stripeSecret && is_string($stripeSecret)) {
            Stripe::setApiKey($stripeSecret);
        }
    }

    /**
     * Check if Stripe is properly configured
     */
    private function isStripeConfigured(): bool
    {
        $stripeSecret = config('services.stripe.secret');
        return $stripeSecret && is_string($stripeSecret) && strlen($stripeSecret) > 0;
    }

    /**
     * Create a Stripe product and price for a subscription plan
     */
    public function createStripePlan(SubscriptionPlan $plan): array
    {
        if (!$this->isStripeConfigured()) {
            Log::warning('Stripe not configured, skipping plan creation');
            return [
                'success' => false,
                'error' => 'Stripe is not properly configured',
            ];
        }

        try {
            // Create Stripe Product
            $product = Product::create([
                'name' => $plan->name,
                'description' => $this->generateDescription($plan),
                'metadata' => [
                    'plan_id' => $plan->id,
                    'plan_type' => $plan->type,
                    'duration' => $plan->duration,
                ],
            ]);

            // Determine billing interval based on plan type
            $interval = $this->getBillingInterval($plan->type);
            
            // Create Stripe Price
            $price = Price::create([
                'product' => $product->id,
                'unit_amount' => (int)($plan->price * 100), // Convert to cents
                'currency' => 'usd',
                'recurring' => [
                    'interval' => $interval,
                ],
                'metadata' => [
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                ],
            ]);

            return [
                'success' => true,
                'product_id' => $product->id,
                'price_id' => $price->id,
                'product' => $product,
                'price' => $price,
            ];

        } catch (ApiErrorException $e) {
            Log::error('Stripe plan creation failed: ' . $e->getMessage(), [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update a Stripe plan when subscription plan is updated
     */
    public function updateStripePlan(SubscriptionPlan $plan): array
    {
        if (!$this->isStripeConfigured()) {
            Log::warning('Stripe not configured, skipping plan update');
            return [
                'success' => false,
                'error' => 'Stripe is not properly configured',
            ];
        }

        if (!$plan->stripe_product_id || !$plan->stripe_plan_id) {
            return $this->createStripePlan($plan);
        }

        try {
            // Ensure we have clean string values
            $productId = $this->cleanStripeId($plan->stripe_product_id);
            $priceId = $this->cleanStripeId($plan->stripe_plan_id);

            if (!$productId || !$priceId) {
                return $this->createStripePlan($plan);
            }

            // Update Stripe Product using direct API call
            $this->updateStripeProductDirectly($productId, $plan);

            // For price updates, we need to create a new price and archive the old one
            // since Stripe doesn't allow updating existing prices
            $this->archiveStripePriceDirectly($priceId);

            $interval = $this->getBillingInterval($plan->type);
            
            // Create new price using direct API call
            $newPriceId = $this->createStripePriceDirectly($productId, $plan, $interval);

            // Update the plan with the new price ID
            $plan->update([
                'stripe_plan_id' => $newPriceId
            ]);

            Log::info('Plan updated with new Stripe price ID', [
                'plan_id' => $plan->id,
                'old_price_id' => $priceId,
                'new_price_id' => $newPriceId,
            ]);

            return [
                'success' => true,
                'product_id' => $productId,
                'price_id' => $newPriceId,
            ];

        } catch (\Exception $e) {
            Log::error('Stripe plan update failed: ' . $e->getMessage(), [
                'plan_id' => $plan->id,
                'plan_name' => $plan->name,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete a Stripe plan
     */
    public function deleteStripePlan(SubscriptionPlan $plan): bool
    {
        if (!$this->isStripeConfigured()) {
            Log::warning('Stripe not configured, skipping plan deletion');
            return true; // Return true to not block the deletion
        }

        // Log the original values for debugging
        Log::info('StripePlanService deleteStripePlan called', [
            'plan_id' => $plan->id,
            'original_stripe_product_id' => $plan->stripe_product_id,
            'original_stripe_plan_id' => $plan->stripe_plan_id,
            'product_id_type' => gettype($plan->stripe_product_id),
            'plan_id_type' => gettype($plan->stripe_plan_id),
        ]);

        // Clean and ensure we have string values
        $productId = $this->cleanStripeId($plan->stripe_product_id);
        $priceId = $this->cleanStripeId($plan->stripe_plan_id);

        Log::info('After cleanStripeId conversion', [
            'product_id' => $productId,
            'price_id' => $priceId,
            'product_id_type' => gettype($productId),
            'price_id_type' => gettype($priceId),
            'product_id_length' => is_string($productId) ? strlen($productId) : 'not_string',
            'price_id_length' => is_string($priceId) ? strlen($priceId) : 'not_string',
        ]);

        if (!$productId || !$priceId) {
            Log::info('No valid Stripe IDs found, skipping deletion');
            return true; // Nothing to delete
        }

        // Try to delete using cURL directly to avoid the Stripe library issue
        try {
            $this->deleteStripeResourceDirectly($priceId, 'price');
            $this->deleteStripeResourceDirectly($productId, 'product');
            
            Log::info('Stripe plan deletion successful via direct API call');
            return true;
        } catch (\Exception $e) {
            Log::warning('Direct API deletion failed, continuing with local deletion: ' . $e->getMessage(), [
                'plan_id' => $plan->id,
                'product_id' => $productId,
                'price_id' => $priceId,
                'error' => $e->getMessage(),
            ]);
            
            // Don't fail the local deletion if Stripe fails
            return true;
        }
    }

    /**
     * Update Stripe product using direct API call
     */
    private function updateStripeProductDirectly(string $productId, SubscriptionPlan $plan): void
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/products/{$productId}";
        
        $postData = http_build_query([
            'name' => $plan->name,
            'description' => $this->generateDescription($plan),
            'metadata[plan_id]' => $plan->id,
            'metadata[plan_type]' => $plan->type,
            'metadata[duration]' => $plan->duration,
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['error']['message'] ?? 'Unknown error';
            throw new \Exception("Stripe API error ({$httpCode}): {$errorMessage}");
        }

        Log::info("Stripe product updated successfully via direct API call", [
            'product_id' => $productId,
            'http_code' => $httpCode,
        ]);
    }

    /**
     * Archive Stripe price using direct API call
     */
    private function archiveStripePriceDirectly(string $priceId): void
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/prices/{$priceId}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'active=false');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['error']['message'] ?? 'Unknown error';
            throw new \Exception("Stripe API error ({$httpCode}): {$errorMessage}");
        }

        Log::info("Stripe price archived successfully via direct API call", [
            'price_id' => $priceId,
            'http_code' => $httpCode,
        ]);
    }

    /**
     * Create Stripe price using direct API call
     */
    private function createStripePriceDirectly(string $productId, SubscriptionPlan $plan, string $interval): string
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/prices";
        
        $postData = http_build_query([
            'product' => $productId,
            'unit_amount' => (int)($plan->price * 100),
            'currency' => 'usd',
            'recurring[interval]' => $interval,
            'metadata[plan_id]' => $plan->id,
            'metadata[plan_name]' => $plan->name,
        ]);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['error']['message'] ?? 'Unknown error';
            throw new \Exception("Stripe API error ({$httpCode}): {$errorMessage}");
        }

        $responseData = json_decode($response, true);
        $priceId = $responseData['id'] ?? null;

        if (!$priceId) {
            throw new \Exception("Failed to get price ID from Stripe response");
        }

        Log::info("Stripe price created successfully via direct API call", [
            'price_id' => $priceId,
            'product_id' => $productId,
            'http_code' => $httpCode,
        ]);

        return $priceId;
    }

    /**
     * Delete Stripe resource using direct cURL call to avoid library issues
     */
    private function deleteStripeResourceDirectly(string $resourceId, string $type): void
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/{$type}s/{$resourceId}";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_USERPWD, $stripeSecret . ':');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'active=false');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \Exception("cURL error: {$error}");
        }

        if ($httpCode >= 400) {
            $responseData = json_decode($response, true);
            $errorMessage = $responseData['error']['message'] ?? 'Unknown error';
            throw new \Exception("Stripe API error ({$httpCode}): {$errorMessage}");
        }

        Log::info("Stripe {$type} archived successfully via direct API call", [
            'resource_id' => $resourceId,
            'http_code' => $httpCode,
        ]);
    }

    /**
     * Generate description for Stripe product
     */
    private function generateDescription(SubscriptionPlan $plan): string
    {
        $description = "IPTV Subscription Plan - {$plan->name}";
        
        if ($plan->features && is_array($plan->features) && count($plan->features) > 0) {
            $description .= "\n\nFeatures:\n" . implode("\n", $plan->features);
        }

        $description .= "\n\nDuration: {$plan->duration}";
        $description .= "\nType: " . ucfirst($plan->type);

        return $description;
    }

    /**
     * Get billing interval based on plan type
     */
    private function getBillingInterval(string $type): string
    {
        return match($type) {
            'monthly' => 'month',
            'yearly' => 'year',
            'lifetime' => 'year', // Lifetime plans are treated as yearly for Stripe
            default => 'month',
        };
    }

    /**
     * Clean and ensure a Stripe ID is a proper string
     */
    private function cleanStripeId($value): ?string
    {
        if (is_array($value)) {
            Log::warning('Array detected in cleanStripeId', [
                'value' => $value,
                'first_element' => isset($value[0]) ? $value[0] : 'not_set',
            ]);
            $value = isset($value[0]) ? $value[0] : null;
        }
        
        if (is_object($value)) {
            Log::warning('Object detected in cleanStripeId', [
                'value' => $value,
                'class' => get_class($value),
            ]);
            $value = (string)$value;
        }
        
        if (!$value) {
            return null;
        }
        
        // Convert to string and clean it
        $cleanValue = (string)$value;
        
        // Remove any extra quotes or escape characters
        $cleanValue = trim($cleanValue, '"\'');
        $cleanValue = stripslashes($cleanValue);
        
        // Ensure it's not empty after cleaning
        if (empty($cleanValue)) {
            return null;
        }
        
        Log::info('Stripe ID cleaned', [
            'original' => $value,
            'cleaned' => $cleanValue,
            'original_type' => gettype($value),
            'cleaned_type' => gettype($cleanValue),
        ]);
        
        return $cleanValue;
    }
}
