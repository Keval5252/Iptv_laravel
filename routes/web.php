<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\SubscriptionPlanController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('seo');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us')->middleware('seo');
Route::get('/shipping-policy', [HomeController::class, 'shippingPolicy'])->name('shipping-policy')->middleware('seo');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us')->middleware('seo');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs')->middleware('seo');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy')->middleware('seo');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy')->middleware('seo');
Route::get('/terms-of-service', [HomeController::class, 'termsOfService'])->name('terms-of-service')->middleware('seo');
Route::get('/iptv-subscription', [HomeController::class, 'iptvSubscription'])->name('iptv-subscription')->middleware('seo');
Route::get('/multi-connections', [HomeController::class, 'multiConnections'])->name('multi-connections')->middleware('seo');
Route::get('/multi-connections-prices', [HomeController::class, 'multiConnectionsPrices'])->name('multi-connections-prices')->middleware('seo');
Route::get('/iptv-playlist', [HomeController::class, 'iptvPlaylist'])->name('iptv-playlist')->middleware('seo');
Route::get('/adult-channel', [HomeController::class, 'adultChannel'])->name('adult-channel')->middleware('seo');
Route::get('/best-iptv-for-firestick-2022', [HomeController::class, 'bestIptvForFirestick'])->name('best-iptv-for-firestick-2022')->middleware('seo');

// SEO Routes
Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/generate-sitemap', [App\Http\Controllers\SitemapController::class, 'generateSitemap'])->name('generate.sitemap');
Route::get('/test-seo', function() { return view('test-seo'); })->name('test-seo')->middleware('seo');

// Operation Guides
Route::get('/operation-guide-android-smartphone-android-box', [HomeController::class, 'operationGuideAndroid'])->name('operation-guide-android')->middleware('seo');
Route::get('/operation-guide-android-tv-perfect-player', [HomeController::class, 'operationGuideAndroidTv'])->name('operation-guide-android-tv')->middleware('seo');
Route::get('/operation-guide-apple-iphone-ipad-apple-tv', [HomeController::class, 'operationGuideApple'])->name('operation-guide-apple')->middleware('seo');
Route::get('/operation-guide-enigma2-dreambox-vu', [HomeController::class, 'operationGuideEnigma'])->name('operation-guide-enigma')->middleware('seo');
Route::get('/operation-guide-kodi-version-16-or-lower', [HomeController::class, 'operationGuideKodiOld'])->name('operation-guide-kodi-old')->middleware('seo');
Route::get('/operation-guide-kodi-xbmc-version-17-et-plus', [HomeController::class, 'operationGuideKodiNew'])->name('operation-guide-kodi-new')->middleware('seo');
Route::get('/operation-guide-mag-250-254-256', [HomeController::class, 'operationGuideMag'])->name('operation-guide-mag')->middleware('seo');
Route::get('/operation-guide-pc-mac-logiciel-vlc', [HomeController::class, 'operationGuidePc'])->name('operation-guide-pc')->middleware('seo');
Route::get('/operation-guide-smart-tv-samsung-lg', [HomeController::class, 'operationGuideSmartTv'])->name('operation-guide-smart-tv')->middleware('seo');
Route::get('/operation-guide-stb-emulator', [HomeController::class, 'operationGuideStb'])->name('operation-guide-stb')->middleware('seo');

















Route::get('/token/{id}', [HomeController::class, 'accessToken'])->name('authtoken');

Route::get('/login', function () {
    return redirect("/admin");
});

Auth::routes();


Route::get('/home', function () {
    return redirect("/admin");
});

Route::get('/forgot/password', [UserController::class, 'forgot_password'])->name('admin.forgot');
Route::post('/forgot/password/mail', [UserController::class, 'password_mail'])->name('admin.forgot.mail');
Route::post('admin/login', [UserController::class, 'admin_login'])->name('admin.login');

Route::name('admin.')->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['admin.check']], function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        // users  route
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/password', [UserController::class, 'password'])->name('password');
        Route::post('/password/change', [UserController::class, 'change_password'])->name('password.update');
        Route::post('/profile/update', [UserController::class, 'update_profile'])->name('profile.update');

        // Subscription Plans Management
        Route::resource('subscription-plans', \App\Http\Controllers\Admin\SubscriptionPlanController::class);
        Route::post('subscription-plans/{subscriptionPlan}/toggle-status', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');
        Route::post('subscription-plans/update-order', [\App\Http\Controllers\Admin\SubscriptionPlanController::class, 'updateOrder'])->name('subscription-plans.update-order');

        // Menu Management
        Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class);
        Route::post('menus/{menu}/toggle-status', [\App\Http\Controllers\Admin\MenuController::class, 'toggleStatus'])->name('menus.toggle-status');
        Route::post('menus/update-order', [\App\Http\Controllers\Admin\MenuController::class, 'updateOrder'])->name('menus.update-order');

        // Menu Items Management
        Route::resource('menu-items', \App\Http\Controllers\Admin\MenuItemController::class);
        Route::post('menu-items/{menuItem}/toggle-status', [\App\Http\Controllers\Admin\MenuItemController::class, 'toggleStatus'])->name('menu-items.toggle-status');
        Route::post('menu-items/update-order', [\App\Http\Controllers\Admin\MenuItemController::class, 'updateOrder'])->name('menu-items.update-order');
        Route::get('menu-items/by-menu/{menu}', [\App\Http\Controllers\Admin\MenuItemController::class, 'getByMenu'])->name('menu-items.by-menu');

    });
});

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
