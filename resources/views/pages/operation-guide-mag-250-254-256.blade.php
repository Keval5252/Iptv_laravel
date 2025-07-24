@extends('layouts.app')

@section('title', 'About Us - Super IPTV')

@section('content')
    <div class="mt-16 container">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-6">
                Operation Guide: KODI (Version 16 or lower)
            </h1>

            <div class="space-y-4 mb-8">
                <div class="rounded-lg p-3 border-l-4 border-blue-500 bg-blue-50">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Open Kodi</li>
                        <li>Select <span class="font-semibold">SYSTEM</span></li>
                        <li>Select <span class="font-semibold">TV</span> (or <span class="font-semibold">Live TV</span> if
                            using version lower than 15.2)</li>
                        <li>Select <span class="font-semibold">General</span></li>
                        <li>Select <span class="font-semibold">Enabled</span>. You will see a pop-up about no PVR client
                            being activated</li>
                        <li>Click <span class="font-semibold">OK</span></li>
                        <li>Scroll down and select <span class="font-semibold">PVR IPTV Simple Client</span></li>
                        <li>Select <span class="font-semibold">Enable</span></li>
                        <li>Select <span class="font-semibold">Configure</span></li>
                        <li>Select <span class="font-semibold">M3U Playlist URL</span></li>
                        <li>Add your M3U URL in the address section</li>
                        <li>Click <span class="font-semibold">OK</span></li>
                        <li>Select <span class="font-semibold">OK</span> again</li>
                        <li>Restart Kodi</li>
                        <li>On home screen, you should now see <span class="font-semibold">TV</span> (or <span
                                class="font-semibold">Live TV</span> on older versions)</li>
                        <li>Open it to see the list of live channels</li>
                    </ol>
                </div>
            </div>

            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mt-8">
                <p class="text-gray-800 mb-2">
                    Any problem contact us at:
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
