@extends('layouts.web')

@section('title', 'About Us - Super IPTV')

@section('content')
    <div class="mt-16 container">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-6">
                Operation Guide: MAG 250, 254, 256
            </h1>

            <div class="mb-8">
                <p class="text-gray-800 mb-4">
                    Connect MAG DEVICE to TV and Internet. Then do the following:
                </p>
            </div>

            <div class="space-y-4 mb-8">
                <div class="rounded-lg p-3 border-l-4 border-blue-500 bg-blue-50">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Go to: Settings → System Settings → Servers → Portals</li>
                        <li>Set Portal 1: IPTV Shop</li>
                        <li>Set Portal URL 1 (see your email)</li>
                        <li>Set portal name 2: leave this blank (add this only if you order the second subscription)</li>
                        <li>Set portal url 2: leave this blank (add this only if you order the second subscription)</li>
                        <li>Save everything</li>
                        <li>Restart the device</li>
                        <li>After the box restarts, wait for the TV screen to display the channels</li>
                    </ol>
                </div>
            </div>

            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mt-8">
                <p class="text-gray-800 mb-2">
                    Any questions please feel free to contact us, we will reply as soon as possible!
                </p>
                <p class="text-gray-800 mb-1">
                    <span class="font-semibold">WhatsApp:</span> +8613065126391
                </p>
                <p class="text-gray-800">
                    <span class="font-semibold">Email:</span> superiptvs6@gmail.com
                </p>
            </div>
        </div>
    </div>
@endsection
