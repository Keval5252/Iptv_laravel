<?php

namespace App\Services;

use App\Models\User;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;

class StripeCustomerService
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
    public function isStripeConfigured(): bool
    {
        $stripeSecret = config('services.stripe.secret');
        return $stripeSecret && is_string($stripeSecret) && strlen($stripeSecret) > 0;
    }

    /**
     * Create a Stripe customer for a user
     */
    public function createStripeCustomer(User $user): array
    {
        if (!$this->isStripeConfigured()) {
            Log::warning('Stripe not configured, skipping customer creation');
            return [
                'success' => false,
                'error' => 'Stripe is not properly configured',
            ];
        }

        // Check if user already has a Stripe customer ID
        if ($user->stripe_customer_id) {
            Log::info('User already has Stripe customer ID', [
                'user_id' => $user->id,
                'stripe_customer_id' => $user->stripe_customer_id,
            ]);
            return [
                'success' => true,
                'customer_id' => $user->stripe_customer_id,
                'message' => 'Customer already exists',
            ];
        }

        try {
            // Create Stripe Customer using direct API call to avoid library issues
            $customerId = $this->createStripeCustomerDirectly($user);

            // Update user with Stripe customer ID
            $user->update([
                'stripe_customer_id' => $customerId
            ]);

            Log::info('Stripe customer created and linked to user', [
                'user_id' => $user->id,
                'customer_id' => $customerId,
            ]);

            return [
                'success' => true,
                'customer_id' => $customerId,
                'message' => 'Customer created successfully',
            ];

        } catch (\Exception $e) {
            Log::error('Stripe customer creation failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Create Stripe customer using direct API call
     */
    private function createStripeCustomerDirectly(User $user): string
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/customers";
        
        $postData = http_build_query([
            'email' => $user->email,
            'name' => $user->name,
            'metadata[user_id]' => $user->id,
            'metadata[user_type]' => $user->user_type ?? 'user',
        ]);

        // Add optional fields if available
        if ($user->phone) {
            $postData .= '&' . http_build_query(['phone' => $user->phone]);
        }

        if ($user->address) {
            $postData .= '&' . http_build_query(['address[line1]' => $user->address]);
        }

        if ($user->city) {
            $postData .= '&' . http_build_query(['address[city]' => $user->city]);
        }

        if ($user->state) {
            $postData .= '&' . http_build_query(['address[state]' => $user->state]);
        }

        if ($user->country) {
            $postData .= '&' . http_build_query(['address[country]' => $user->country]);
        }

        if ($user->postal_code) {
            $postData .= '&' . http_build_query(['address[postal_code]' => $user->postal_code]);
        }
        
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
        $customerId = $responseData['id'] ?? null;

        if (!$customerId) {
            throw new \Exception("Failed to get customer ID from Stripe response");
        }

        Log::info("Stripe customer created successfully via direct API call", [
            'customer_id' => $customerId,
            'user_id' => $user->id,
            'http_code' => $httpCode,
        ]);

        return $customerId;
    }

    /**
     * Update Stripe customer information
     */
    public function updateStripeCustomer(User $user): array
    {
        if (!$this->isStripeConfigured()) {
            Log::warning('Stripe not configured, skipping customer update');
            return [
                'success' => false,
                'error' => 'Stripe is not properly configured',
            ];
        }

        if (!$user->stripe_customer_id) {
            // If no customer ID, create one
            return $this->createStripeCustomer($user);
        }

        try {
            $this->updateStripeCustomerDirectly($user);

            Log::info('Stripe customer updated successfully', [
                'user_id' => $user->id,
                'customer_id' => $user->stripe_customer_id,
            ]);

            return [
                'success' => true,
                'customer_id' => $user->stripe_customer_id,
                'message' => 'Customer updated successfully',
            ];

        } catch (\Exception $e) {
            Log::error('Stripe customer update failed: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'customer_id' => $user->stripe_customer_id,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Update Stripe customer using direct API call
     */
    private function updateStripeCustomerDirectly(User $user): void
    {
        $stripeSecret = config('services.stripe.secret');
        if (!$stripeSecret) {
            throw new \Exception('Stripe secret key not configured');
        }

        $url = "https://api.stripe.com/v1/customers/{$user->stripe_customer_id}";
        
        $postData = http_build_query([
            'email' => $user->email,
            'name' => $user->name,
            'metadata[user_id]' => $user->id,
            'metadata[user_type]' => $user->user_type ?? 'user',
        ]);

        // Add optional fields if available
        if ($user->phone) {
            $postData .= '&' . http_build_query(['phone' => $user->phone]);
        }

        if ($user->address) {
            $postData .= '&' . http_build_query(['address[line1]' => $user->address]);
        }

        if ($user->city) {
            $postData .= '&' . http_build_query(['address[city]' => $user->city]);
        }

        if ($user->state) {
            $postData .= '&' . http_build_query(['address[state]' => $user->state]);
        }

        if ($user->country) {
            $postData .= '&' . http_build_query(['address[country]' => $user->country]);
        }

        if ($user->postal_code) {
            $postData .= '&' . http_build_query(['address[postal_code]' => $user->postal_code]);
        }
        
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

        Log::info("Stripe customer updated successfully via direct API call", [
            'customer_id' => $user->stripe_customer_id,
            'user_id' => $user->id,
            'http_code' => $httpCode,
        ]);
    }

    /**
     * Get or create Stripe customer for a user
     */
    public function getOrCreateStripeCustomer(User $user): string
    {
        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        $result = $this->createStripeCustomer($user);
        
        if ($result['success']) {
            return $result['customer_id'];
        }

        throw new \Exception('Failed to create Stripe customer: ' . $result['error']);
    }
}
