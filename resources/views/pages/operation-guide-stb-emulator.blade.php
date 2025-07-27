@extends('layouts.web')

@section('title', 'About Us - Super IPTV')

@section('content')
    <div class="mt-16 container">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-6">
                Operation Guide: STB Emulator
            </h1>

            <div class="mb-8">
                <p class="text-gray-800 mb-4">
                    This tutorial will walk you through the simple setup instructions for the STB emulator.
                </p>
                <p class="text-gray-800 font-medium">
                    "STB Emulator" can emulate the following IPTV decoders:
                </p>
            </div>

            <div class="overflow-x-auto mb-8">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">IPTV TUNING BOX HELP
                            </th>
                            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 border-b">Supported</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 200</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 245</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 250</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 260</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 270</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">MAG 275</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 border-b">Aura HD</td>
                            <td class="px-4 py-2 border-b">Yes</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-xl sm:text-2xl font-semibold text-orange-600 mb-4">
                STB Emulator Setup Instructions:
            </h2>

            <div class="space-y-4 mb-8">
                <p class="text-gray-800">
                    Download 'STB Emulator' from Google Play Store <a
                        href="https://play.google.com/store/apps/details?id=ru.iptvremote.android.iptv"
                        class="text-blue-600 hover:underline" target="_blank">here</a>.
                </p>

                <div class="rounded-lg p-3 border-l-4 border-blue-500 bg-blue-50">
                    <ol class="list-decimal pl-5 space-y-3">
                        <li>Install and load "STB Emulator" app and you will see your "MAC address" on the screen.</li>
                        <li>Tap near the "top right corner," then click "Settings" — the fourth icon from the right.</li>
                        <li>Tap "Profiles".</li>
                        <li>Tap "Test Portal" to edit the existing profile or "Add Profile" to create a new one.</li>
                        <li>Tap "STB Model".</li>
                        <li>Press "MAG 250" or the decoder you want to emulate.</li>
                        <li>Tap "Portal Settings".</li>
                        <li>Enter your "Portal URL" (check your activation email) and click OK.</li>
                        <li>Now tap on "Screen resolution".</li>
                        <li>Choose '1280×720' (you can choose higher with 16+ Mbps internet speed).</li>
                        <li>Exit the application and restart.</li>
                        <li>You will now see your channel list.</li>
                    </ol>
                </div>
            </div>

            <h2 class="text-xl sm:text-2xl font-semibold text-orange-600 mb-4">
                Troubleshooting STB Emulator
            </h2>

            <div class="rounded-lg p-4 mb-8 bg-amber-50 border-l-4 border-amber-500">
                <p class="text-gray-800">
                    If you are having trouble viewing channels, please follow this recommended fix:
                </p>
                <p class="text-gray-800 font-medium mt-2">
                    Restart your app, device/box and Wi-Fi router.
                </p>
            </div>

            <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mt-8">
                <p class="text-gray-800 mb-2">
                    Any questions please feel free to contact us, we will reply as soon as possible!
                </p>
                <p class="text-gray-800 mb-1">
                    <span class="font-semibold">WhatsApp:</span> +852 46078909
                </p>
                <p class="text-gray-800">
                    <span class="font-semibold">Email:</span> superiptvs6@gmail.com
                </p>
            </div>
        </div>
    </div>
@endsection
