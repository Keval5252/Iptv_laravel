<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\StripeCustomerService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    protected $stripeCustomerService;

    public function __construct(StripeCustomerService $stripeCustomerService)
    {
        $this->stripeCustomerService = $stripeCustomerService;
    }

    public function showLoginForm()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Check if the authenticated user is a regular user (user_type = 0)
            if (Auth::user()->user_type == 0) {
                return response()->json(['status' => 'success', 'redirect' => route('user.dashboard')]);
            } else {
                // If an admin tries to log in via user login, log them out and redirect to admin login
                Auth::logout();
                return response()->json(['status' => 'error', 'message' => 'You do not have user access. Please use the admin login.']);
            }
        }

        return response()->json(['status' => 'error', 'message' => 'Invalid credentials']);
    }

    public function showRegisterForm()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'terms' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        // Generate username from first and last name
        $userName = strtolower($request->first_name . $request->last_name);
        $originalUserName = $userName;
        $counter = 1;
        
        // Ensure username is unique
        while (User::where('user_name', $userName)->exists()) {
            $userName = $originalUserName . $counter;
            $counter++;
        }

        try {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name . ' ' . $request->last_name,
                'user_name' => $userName,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 0, // Regular user
            ]);

            // Create Stripe customer for the new user
            $stripeResult = $this->stripeCustomerService->createStripeCustomer($user);
            
            if ($stripeResult['success']) {
                Log::info('Stripe customer created during user registration', [
                    'user_id' => $user->id,
                    'customer_id' => $stripeResult['customer_id'],
                ]);
            } else {
                Log::warning('Failed to create Stripe customer during registration', [
                    'user_id' => $user->id,
                    'error' => $stripeResult['error'],
                ]);
                // Don't fail registration if Stripe fails - just log it
            }

            Auth::login($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful!',
                'redirect' => route('user.dashboard')
            ]);

        } catch (\Exception $e) {
            Log::error('User registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed. Please try again.'
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
