<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\SubscriptionPlan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Subscription Plans API
Route::get('/subscription-plans', function () {
    $plans = SubscriptionPlan::active()->ordered()->get();
    return response()->json([
        'success' => true,
        'data' => $plans
    ]);
});

Route::get('/subscription-plans/{type}', function ($type) {
    $plans = SubscriptionPlan::active()->where('type', $type)->ordered()->get();
    return response()->json([
        'success' => true,
        'data' => $plans
    ]);
});