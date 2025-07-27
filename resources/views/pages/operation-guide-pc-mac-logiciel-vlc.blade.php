@extends('layouts.web')

@section('title', 'About Us - Super IPTV')

@section('content')
    <div class="mt-16 container">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-6">
                Operation Guide: PC / MAC (VLC Media Player)
            </h1>

            <div class="space-y-6">
                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">1. Download VLC Media Player</h3>
                    <p class="text-gray-800 mb-2">
                        Download URL:
                        <a href="https://www.videolan.org/vlc/index.html" class="text-blue-600 hover:underline"
                            target="_blank">
                            https://www.videolan.org/vlc/index.html
                        </a>
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">2. Open VLC player</h3>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">3. Go to Media → Open Network Stream</h3>
                    <p class="text-gray-800">
                        (Menu path: Media → Open Network Stream or Ctrl+N shortcut)
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">4. Add your subscription m3u URL</h3>
                    <p class="text-gray-800">
                        Paste the M3U URL we sent to you in the network URL field and press Play
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">5. Wait for all channels to load</h3>
                    <p class="text-gray-800">
                        This may take a while depending on your connection speed
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">6. Choose a channel and enjoy</h3>
                    <p class="text-gray-800">
                        Use the playlist panel to browse and select channels
                    </p>
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
