<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $activeSubscription = $user->getActiveSubscription();
        $subscriptionHistory = $user->userSubscriptions()
            ->with('subscriptionPlan')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.dashboard', compact('user', 'activeSubscription', 'subscriptionHistory'));
    }

    public function profile()
    {
        $user = Auth::user();
        $subscriptionHistory = $user->userSubscriptions()
            ->with('subscriptionPlan')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('user.profile', compact('user', 'subscriptionHistory'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
        ]);

        return response()->json(['status' => 'success', 'message' => 'Profile updated successfully']);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['status' => 'error', 'message' => 'Current password does not match']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Password changed successfully']);
    }
}
