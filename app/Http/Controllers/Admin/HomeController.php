<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home');
    }

    public function aboutUs()
    {
        return view('pages.about-us');
    }

    public function shippingPolicy()
    {
        return view('pages.shipping-policy');
    }

    public function contactUs()
    {
        return view('pages.contact-us');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function refundPolicy()
    {
        return view('pages.refund-policy');
    }

    public function termsOfService()
    {
        return view('pages.terms-of-service ');
    }

    public function iptvSubscription()
    {
        return view('pages.iptv-subscription');
    }

    public function multiConnections()
    {
        return view('pages.multi-connections');
    }

    public function multiConnectionsPrices()
    {
        return view('pages.multi-connections-prices');
    }

    public function iptvPlaylist()
    {
        return view('pages.iptv-playlist');
    }

    public function adultChannel()
    {
        return view('pages.adult-channel');
    }

    public function bestIptvForFirestick()
    {
        return view('pages.best-iptv-for-firestick-2022');
    }

    public function operationGuideAndroid()
    {
        return view('pages.operation-guide-android-smartphone-android-box');
    }

    public function operationGuideAndroidTv()
    {
        return view('pages.operation-guide-android-tv-perfect-player');
    }

    public function operationGuideApple()
    {
        return view('pages.operation-guide-apple-iphone-ipad-apple-tv');
    }

    public function operationGuideEnigma()
    {
        return view('pages.operation-guide-enigma2-dreambox-vu');
    }

    public function operationGuideKodiOld()
    {
        return view('pages.operation-guide-kodi-version-16-or-lower');
    }

    public function operationGuideKodiNew()
    {
        return view('pages.operation-guide-kodi-xbmc-version-17-et-plus');
    }

    public function operationGuideMag()
    {
        return view('pages.operation-guide-mag-250-254-256');
    }

    public function operationGuidePc()
    {
        return view('pages.operation-guide-pc-mac-logiciel-vlc');
    }

    public function operationGuideSmartTv()
    {
        return view('pages.operation-guide-smart-tv-samsung-lg');
    }

    public function operationGuideStb()
    {
        return view('pages.operation-guide-stb-emulator');
    }
}
