<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('about-us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact-us');
Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/refund-policy', [HomeController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/iptv-subscription', [HomeController::class, 'iptvSubscription'])->name('iptv-subscription');
Route::get('/multi-connections', [HomeController::class, 'multiConnections'])->name('multi-connections');
Route::get('/multi-connections-prices', [HomeController::class, 'multiConnectionsPrices'])->name('multi-connections-prices');
Route::get('/iptv-playlist', [HomeController::class, 'iptvPlaylist'])->name('iptv-playlist');
Route::get('/adult-channel', [HomeController::class, 'adultChannel'])->name('adult-channel');
Route::get('/best-iptv-for-firestick-2022', [HomeController::class, 'bestIptvForFirestick'])->name('best-iptv-for-firestick-2022');

// Operation Guides
Route::get('/operation-guide-android-smartphone-android-box', [HomeController::class, 'operationGuideAndroid'])->name('operation-guide-android');
Route::get('/operation-guide-android-tv-perfect-player', [HomeController::class, 'operationGuideAndroidTv'])->name('operation-guide-android-tv');
Route::get('/operation-guide-apple-iphone-ipad-apple-tv', [HomeController::class, 'operationGuideApple'])->name('operation-guide-apple');
Route::get('/operation-guide-enigma2-dreambox-vu', [HomeController::class, 'operationGuideEnigma'])->name('operation-guide-enigma');
Route::get('/operation-guide-kodi-version-16-or-lower', [HomeController::class, 'operationGuideKodiOld'])->name('operation-guide-kodi-old');
Route::get('/operation-guide-kodi-xbmc-version-17-et-plus', [HomeController::class, 'operationGuideKodiNew'])->name('operation-guide-kodi-new');
Route::get('/operation-guide-mag-250-254-256', [HomeController::class, 'operationGuideMag'])->name('operation-guide-mag');
Route::get('/operation-guide-pc-mac-logiciel-vlc', [HomeController::class, 'operationGuidePc'])->name('operation-guide-pc');
Route::get('/operation-guide-smart-tv-samsung-lg', [HomeController::class, 'operationGuideSmartTv'])->name('operation-guide-smart-tv');
Route::get('/operation-guide-stb-emulator', [HomeController::class, 'operationGuideStb'])->name('operation-guide-stb');
