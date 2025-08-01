<header class="shadow-sm bg-white">
    <div class="container flex items-center justify-between gap-4 py-3 min-w-0">
        <button class="flex-shrink-0 p-2 text-gray-500 hover:text-primary transition-colors" aria-label="Open menu"
            data-drawer-open>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" y1="6" x2="20" y2="6" />
                <line x1="4" y1="12" x2="20" y2="12" />
                <line x1="4" y1="18" x2="20" y2="18" />
            </svg>
        </button>
        <div class="mr-8 flex-shrink-0 min-w-fit">
            <a href="{{ route('home') }}">
                <h1 class="text-3xl font-medium text-center whitespace-nowrap">Super <span
                        class="hidden sm:inline"><br /></span> IPTV</h1>
            </a>
        </div>
        <nav class="flex-1 min-w-0 hidden lg:block">
            <ul class="flex gap-4 flex-nowrap items-center overflow-x-auto hide-scrollbar">
                @php
                    $dynamicMenuItems = getMenuItems('header');
                @endphp
                
                @foreach($dynamicMenuItems as $menuItem)
                    <li>
                        <a href="{{ $menuItem->final_url }}" target="{{ $menuItem->target }}"
                           class="text-sm font-medium text-gray-700 hover:text-primary border-b-2 border-transparent hover:border-primary transition-all duration-200 whitespace-nowrap {{ isMenuActive($menuItem) ? 'border-primary text-primary' : '' }}">
                            @if($menuItem->icon)<i class="{{ $menuItem->icon }} mr-1"></i>@endif
                            {{ $menuItem->title }}
                        </a>
                    </li>
                @endforeach
                
                <!-- Static Menu Items -->
                <li><a href="{{ route('iptv-playlist') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary border-b-2 border-transparent hover:border-primary transition-all duration-200 whitespace-nowrap">CHANNELS
                        LIST</a></li>
                <li><a href="#"
                        class="text-sm font-medium text-gray-700 hover:text-primary border-b-2 border-transparent hover:border-primary transition-all duration-200 whitespace-nowrap">IPTV
                        RESELLERS</a></li>
                <li><a href="#"
                        class="text-sm font-medium text-gray-700 hover:text-primary border-b-2 border-transparent hover:border-primary transition-all duration-200 whitespace-nowrap">OPERATION
                        GUIDE</a></li>
                <li><a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-700 hover:text-primary border-b-2 border-transparent hover:border-primary transition-all duration-200 whitespace-nowrap">Login</a>
                </li>
            </ul>
        </nav>
        <!-- Search Icon in Header -->
        <button class="ml-4 flex-shrink-0 p-2 text-gray-500 hover:text-primary transition-colors" aria-label="Search"
            data-search-open>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </button>
        <!-- Cart Icon in Header -->
        <button class="ml-2 flex-shrink-0 p-2 text-gray-500 hover:text-primary transition-colors" aria-label="Cart"
            data-cart-open>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1" />
                <circle cx="20" cy="21" r="1" />
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
            </svg>
        </button>
    </div>
</header>
