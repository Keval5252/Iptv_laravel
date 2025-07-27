@php
    global $path;
    global $currentPath;
    $path = Route::getFacadeRoot()->current()->uri();
    $currentPathTemp = Request::fullUrl();
    $currentPathTemp = explode(url('/') . '/', $currentPathTemp);
    $currentPath = '';
    if (isset($currentPathTemp[1])) {
        $currentPath = $currentPathTemp[1];
        $currentPath = trim($currentPath);
    }
    function getActiveRoute($arrayLinks)
    {
        $selected = false;
        if (in_array($GLOBALS['path'], $arrayLinks)) {
            $selected = true;
        } elseif (in_array($GLOBALS['currentPath'], $arrayLinks)) {
            $selected = true;
        }
        return $selected;
    }
@endphp
<!-- BEGIN Left Aside -->
<aside class="page-sidebar">
    <div class="page-logo">
        <a href="<?= URL::to('admin') ?>"
            class="page-logo-link press-scale-down d-flex align-items-center position-relative">
            <!-- {{ Auth::user()->photo }} -->
            <!-- <span class="page-logo-text mr-1">{{ config('app.name') }}</span> -->
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            {{-- <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i> --}}
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control"
                    tabindex="0">
                <a href="<?= URL::to('admin') ?>" onclick="return false;"
                    class="btn-primary btn-search-close js-waves-off" data-action="toggle"
                    data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            <img src="{{ Auth::user()->photo }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="<?= URL::to('admin') ?>" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                        {{ Auth::user()->name }}
                    </span>
                </a>
                {{-- <span class="d-inline-block text-truncate text-truncate-sm">Toronto, Canada</span> --}}
            </div>
            <img src="{{ URL::asset('admin_assets/img/card-backgrounds/cover-2-lg.png') }}" class="cover"
                alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <!--
        TIP: The menu items are not auto translated. You must have a residing lang file associated with the menu saved inside dist/media/data with reference to each 'data-i18n' attribute.
        -->
        @php $user = auth()->user() @endphp
        <ul id="js-nav-menu" class="nav-menu">
            @if ($user->id == 1 || $user->can('dashboard'))
                <li class="{{ request()->is('admin') ? 'active' : '' }}">
                    <a href="{{ route('admin.home') }}" title="Dashboard" data-filter-tags="dashboard">
                        <i class="fal fa-tachometer "></i>
                        <span class="nav-link-text" data-i18n="nav.programs">Dashboard</span>
                    </a>
                </li>
            @endif
            
            @if ($user->id == 1 || $user->can('subscription-plans'))
                <li class="{{ request()->is('admin/subscription-plans*') ? 'active' : '' }}">
                    <a href="{{ route('admin.subscription-plans.index') }}" title="Subscription Plans" data-filter-tags="subscription plans">
                        <i class="fal fa-tv"></i>
                        <span class="nav-link-text" data-i18n="nav.subscription_plans">Subscription Plans</span>
                    </a>
                </li>
            @endif
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    {{-- <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
        <ul class="list-table m-auto nav-footer-buttons">
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
                    <i class="fal fa-comments"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Support Chat">
                    <i class="fal fa-life-ring"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
                    <i class="fal fa-phone"></i>
                </a>
            </li>
        </ul>
    </div> <!-- END NAV FOOTER --> --}}
</aside>
<!-- END Left Aside -->
