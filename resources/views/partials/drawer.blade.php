<!-- Drawer Overlay -->
<div id="drawer-overlay" class="fixed inset-0 bg-black/50 z-40 hidden" data-drawer-overlay></div>
<!-- Drawer -->
<aside id="drawer" class="fixed top-0 left-0 h-full w-full max-w-full bg-white shadow-lg z-50 transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col" data-drawer>
    <div class="flex items-center justify-end px-4 py-4 border-b border-gray-200">
        <button class="text-3xl text-gray-500 hover:text-primary transition-colors" aria-label="Close drawer" data-drawer-close>
            &times;
        </button>
    </div>
    <nav class="flex-1 px-6 py-4">
        <ul class="space-y-4 text-gray-700 text-xl md:text-lg font-medium">
            <li><a href="#" class="hover:border-b-2 border-primary transition-all">MY ACCOUNT</a></li>
            <li><a href="{{ route('iptv-subscription') }}" class="hover:border-b-2 border-primary transition-all">IPTV SUBSCRIPTION</a></li>
            <li><a href="{{ route('adult-channel') }}" class="hover:border-b-2 border-primary transition-all">ADULT IPTV</a></li>
            <li><a href="{{ route('multi-connections') }}" class="hover:border-b-2 border-primary transition-all">ADULT IPTV MULTI CONNECTIONS</a></li>
            <li><a href="{{ route('multi-connections-prices') }}" class="hover:border-b-2 border-primary transition-all">MULTI CONNECTIONS SUBSCRIPTION</a></li>
            <li><a href="{{ route('iptv-playlist') }}" class="hover:border-b-2 border-primary transition-all">CHANNELS LIST</a></li>
            <li><a href="#" class="hover:border-b-2 border-primary transition-all">IPTV RESELLERS</a></li>
            <li class="group">
                <a href="#" class="hover:border-b-2 border-primary transition-all flex items-center w-fit">OPERATION GUIDE
                    <svg class="ml-2 w-4 h-4 text-gray-400 group-hover:text-primary transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                </a>
                <ul class="hidden group-hover:block mt-2 ml-6 space-y-2">
                    <li><a href="{{ route('best-iptv-for-firestick-2022') }}" class="block text-gray-700 hover:text-primary transition">Operation Guide: Best Iptv For Firestick 2022</a></li>
                    <li><a href="{{ route('operation-guide-smart-tv') }}" class="block text-gray-700 hover:text-primary transition">Operation Guide: Instructions for Smart TV Samsung / LG</a></li>
                    <li><a href="{{ route('operation-guide-android') }}" class="block text-gray-700 hover:text-primary transition">Operation guide Android (Smartphone, Android Box)</a></li>
                    <li><a href="{{ route('operation-guide-apple') }}" class="block text-gray-700 hover:text-primary transition">Operation guide Apple (iPhone, iPad, Apple TV)</a></li>
                    <li><a href="{{ route('operation-guide-android-tv') }}" class="block text-gray-700 hover:text-primary transition">Operation guide Android TV (Perfect Player)</a></li>
                    <li><a href="{{ route('operation-guide-pc') }}" class="block text-gray-700 hover:text-primary transition">Operation Guide: PC / MAC (Logiciel VLC)</a></li>
                    <li><a href="{{ route('operation-guide-stb') }}" class="block text-gray-700 hover:text-primary transition">Operation guide: STB emulator</a></li>
                    <li><a href="{{ route('operation-guide-mag') }}" class="block text-gray-700 hover:text-primary transition">Operation Guide: MAG 250, 254, 256</a></li>
                    <li><a href="{{ route('operation-guide-kodi-old') }}" class="block text-gray-700 hover:text-primary transition">Operation Guide: KODI version 16 or lower</a></li>
                    <li><a href="{{ route('operation-guide-kodi-new') }}" class="block text-gray-700 hover:text-primary transition">Operation guide KODI (XBMC) version 17 et plus</a></li>
                    <li><a href="{{ route('operation-guide-enigma') }}" class="block text-gray-700 hover:text-primary transition">Operation guide: ENIGMA2 / Dreambox / Vu +</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>
