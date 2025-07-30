@if($menuItems->count() > 0)
    <ul class="menu-list">
        @foreach($menuItems as $menuItem)
            @if($menuItem->is_active)
                <li class="menu-item {{ isMenuActive($menuItem) ? 'active' : '' }}">
                    <a href="{{ $menuItem->final_url }}" target="{{ $menuItem->target }}" class="menu-link {{ $menuItem->css_class ?? '' }}">
                        @if($menuItem->icon)<i class="{{ $menuItem->icon }}"></i>@endif
                        <span>{{ $menuItem->title }}</span>
                    </a>
                    @if($menuItem->children->count() > 0)
                        <ul class="submenu">
                            @foreach($menuItem->children as $child)
                                @if($child->is_active)
                                    <li class="submenu-item {{ isMenuActive($child) ? 'active' : '' }}">
                                        <a href="{{ $child->final_url }}" target="{{ $child->target }}" class="submenu-link {{ $child->css_class ?? '' }}">
                                            @if($child->icon)<i class="{{ $child->icon }}"></i>@endif
                                            <span>{{ $child->title }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>
@endif 