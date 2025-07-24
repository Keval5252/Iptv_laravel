@extends('layouts.app')

@section('title', 'About Us - Super IPTV')

@section('content')
    <div class="mt-16 container">
        <div class="py-12 max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold text-black uppercase text-center mb-6">
                Operation Guide: ENIGMA2 / Dreambox / Vu+
            </h1>

            <div class="space-y-6">
                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">1. Access your Enigma2 and get your IP address</h3>
                    <p class="text-gray-800 mb-2">
                        Go to: <span class="font-semibold">Settings → Configuration → System → Network → Device Configuration
                            → Adapter Settings</span>
                    </p>
                    <p class="text-gray-800">
                        Get your IP address (starts with 192.168...)
                    </p>
                    <img src="https://cdn.shopify.com/s/files/1/0572/0116/4425/files/en1_480x480.png?v=1650631464"
                        alt="Network Settings" class="my-4 rounded border border-gray-300">
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">2. Download Putty software on your Windows PC</h3>
                    <p class="text-gray-800">
                        Putty Download URL:
                        <a href="https://the.earth.li/~sgtatham/putty/latest/x86/putty.exe"
                            class="text-blue-600 hover:underline" target="_blank">
                            https://the.earth.li/~sgtatham/putty/latest/x86/putty.exe
                        </a>
                    </p>
                    <img src="https://cdn.shopify.com/s/files/1/0572/0116/4425/files/en2_480x480.png?v=1650631498"
                        alt="Putty Download" class="my-4 rounded border border-gray-300">
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">3. Open Putty and configure connection</h3>
                    <p class="text-gray-800 mb-2">
                        - Add your Enigma2 IP address (from step 1)<br>
                        - Port: 23<br>
                        - Connection type: Telnet<br>
                        - Click "Open"
                    </p>
                    <img src="https://cdn.shopify.com/s/files/1/0572/0116/4425/files/en3_480x480.png?v=1650631581"
                        alt="Putty Configuration" class="my-4 rounded border border-gray-300">
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">4. Login with default credentials</h3>
                    <p class="text-gray-800">
                        Username: <span class="font-semibold">root</span><br>
                        Password: <span class="font-semibold">[leave empty]</span>
                    </p>
                    <img src="https://cdn.shopify.com/s/files/1/0572/0116/4425/files/en4_480x480.png?v=1650631613"
                        alt="Telnet Login" class="my-4 rounded border border-gray-300">
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">5. Copy your subscription URL line</h3>
                    <p class="text-gray-800">
                        (You will receive this after ordering your subscription)
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">6. Paste your line and press ENTER</h3>
                    <p class="text-gray-800">
                        Right-click to paste in Putty, then press ENTER
                    </p>
                </div>

                <div class="rounded-lg">
                    <h3 class="font-bold text-lg mb-2">7. Type 'reboot' to restart your device</h3>
                    <img src="https://cdn.shopify.com/s/files/1/0572/0116/4425/files/en5_480x480.png?v=1650631641"
                        alt="Reboot Command" class="my-4 rounded border border-gray-300">
                </div>

                <div class="rounded-lg">
                    <p class="text-gray-800 font-medium">
                        After reboot, you will find an "IPTV" folder containing all your channels.
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
    @endsection
