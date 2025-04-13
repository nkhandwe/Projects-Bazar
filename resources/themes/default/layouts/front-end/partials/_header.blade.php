<header class="rtl __inline-10" id="siteHeader">
    <!-- Topbar - Hidden on Mobile -->
    <div class="topbar text-white d-none d-md-flex" style="background-color: var(--web-primary);">
        <div class="container-fluid px-2 px-md-4">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="left-content">
                    <a class="topbar-link direction-ltr text-white" href="tel:{{ $web_config['phone']->value }}">
                        <i class="fa fa-phone me-2"></i>{{ $web_config['phone']->value }}
                    </a>
                </div>
                <div class="right-content">
                    <a class="widget-list-link text-white" href="{{ route('track-order.index') }}">
                        Track Your Order
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- For mobile - replace original mobile menu items -->
    <li class="nav-item d-block d-md-none">
        <div class="topbar text-white" style="background-color: var(--web-primary);">
            <div class="left-content">
                <a class="topbar-link direction-ltr text-white" href="tel:{{ $web_config['phone']->value }}">
                    <i class="fa fa-phone me-2"></i>{{ $web_config['phone']->value }}
                </a>
            </div>
            <div class="right-content">
                <a class="widget-list-link text-white" href="{{ route('track-order.index') }}">
                    Track Your Order
                </a>
            </div>
        </div>
        <div class="border-bottom my-2"></div>
    </li>


    <nav class="navbar navbar-expand-lg navbar-light p-0">
        <div class="container-fluid px-2 px-md-4">
            <div class="d-flex align-items-center w-100">
                <!-- Logo -->
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="img-fluid" src="{{ getStorageImages(path: $web_config['web_logo'], type: 'logo') }}"
                        alt="{{ $web_config['name']->value }}">
                </a>

                <!-- Mobile Cart Only -->
                <div class="d-flex d-lg-none ms-auto">
                    <div id="cart_items_mobile" class="ml-2">
                        @include('layouts.front-end.partials._cart')
                    </div>
                </div>

                <!-- Mobile Toggle Button -->
                <button class="navbar-toggler ml-2" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Navigation Menu -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <!-- Mobile Topbar (Same structure as desktop) -->
                        <li class="nav-item d-block d-md-none">
                            <div class="topbar text-white mb-2" style="background-color: var(--web-primary);">
                                <div class="left-content">
                                    <a class="topbar-link direction-ltr text-white"
                                        href="tel:{{ $web_config['phone']->value }}">
                                        <i class="fa fa-phone me-2"></i>{{ $web_config['phone']->value }}
                                    </a>
                                </div>
                                <div class="right-content">
                                    <a class="widget-list-link text-white" href="{{ route('track-order.index') }}">
                                        Track Your Order
                                    </a>
                                </div>
                            </div>
                            <div class="border-bottom mb-2"></div>
                        </li>

                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link text-black" href="{{ route('home') }}">{{ translate('home') }}</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-black" href="#" data-toggle="dropdown">
                                {{ 'Shop By Age' }} <i class="fa fa-chevron-down"></i>
                            </a>
                            @php($categories = \App\Models\Category::where('parent_id', 0)->get())
                            <ul class="dropdown-menu dropdown-menu-mobile text-align-direction">
                                @php($categoryIndex = 0)
                                @foreach ($categories as $category)
                                    @php($categoryIndex++)
                                    @if ($categoryIndex < 10)
                                        <li class="dropdown">
                                            <a class="text-black"
                                                href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                <span>{{ $category['name'] }}</span>
                                            </a>
                                            @if ($category->childes->count() > 0)
                                                <a data-toggle='dropdown' class='dropdown-toggle-mobile text-black'>
                                                    <i class="fa fa-chevron-down"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-submenu text-align-direction">
                                                    @foreach ($category['childes'] as $subCategory)
                                                        <li>
                                                            <a class="text-black"
                                                                href="{{ route('products', ['category_id' => $subCategory['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                                <span>{{ $subCategory['name'] }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                                <li class="view-all">
                                    <div>
                                        <a class="dropdown-item text-black" href="{{ route('categories') }}">
                                            {{ translate('view_more') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        @php(
    $discount_product = App\Models\Product::with(['reviews'])->active()->where('discount', '!=', 0)->count()
)
                        @if ($discount_product > 0)
                            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                                <a class="nav-link text-black text-capitalize"
                                    href="{{ route('products', ['data_from' => 'discounted', 'page' => 1]) }}">
                                    {{ translate('discounted_products') }}
                                </a>
                            </li>
                        @endif

                        @if (getWebConfig(name: 'product_brand'))
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-black" href="#" data-toggle="dropdown">
                                    {{ 'Science & Activity Kits' }} <i class="fa fa-chevron-down"></i>
                                </a>
                                @php($categories = \App\Models\Category::where('parent_id', '!=', 0)->get())
                                <ul class="dropdown-menu dropdown-menu-mobile text-align-direction">
                                    @php($brandIndex = 0)
                                    @foreach ($categories as $brand)
                                        @php($brandIndex++)
                                        @if ($brandIndex < 10)
                                            <li>
                                                <a class="text-black"
                                                    href="{{ route('products', ['category_id' => $brand['id'], 'data_from' => 'category', 'page' => 1]) }}">
                                                    <span>{{ $brand['name'] }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    <li class="view-all">
                                        <div>
                                            <a class="dropdown-item text-black" href="{{ route('categories') }}">
                                                {{ translate('view_more') }}
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-black" href="#" data-toggle="dropdown">
                                {{ 'More' }} <i class="fa fa-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-mobile text-align-direction">
                                <li>
                                    <a class="dropdown-item text-black" href="{{ route('user-account') }}">
                                        {{ translate('profile_info') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-black" href="{{ route('track-order.index') }}">
                                        {{ translate('track_order') }}
                                    </a>
                                </li>

                                @if (isset($refund_policy['status']) && $refund_policy['status'] == 1)
                                    <li>
                                        <a class="dropdown-item text-black" href="{{ route('refund-policy') }}">
                                            {{ translate('refund_policy') }}
                                        </a>
                                    </li>
                                @endif

                                @if (isset($return_policy['status']) && $return_policy['status'] == 1)
                                    <li>
                                        <a class="dropdown-item text-black" href="{{ route('return-policy') }}">
                                            {{ translate('return_policy') }}
                                        </a>
                                    </li>
                                @endif

                                @if (isset($cancellation_policy['status']) && $cancellation_policy['status'] == 1)
                                    <li>
                                        <a class="dropdown-item text-black"
                                            href="{{ route('cancellation-policy') }}">
                                            {{ translate('cancellation_policy') }}
                                        </a>
                                    </li>
                                @endif

                                @if (isset($shippingPolicy['status']) && $shippingPolicy['status'] == 1)
                                    <li>
                                        <a class="dropdown-item text-black" href="{{ route('shipping-policy') }}">
                                            {{ translate('Shipping_Policy') }}
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    </ul>

                    <!-- Desktop Right Side Icons -->
                    <div class="navbar-toolbar d-none d-lg-flex align-items-center ml-auto">
                        <div class="navbar-tool dropdown mr-3">
                            <a class="navbar-tool-icon-box bg-secondary dropdown-toggle"
                                href="{{ route('wishlists') }}">
                                <span class="navbar-tool-label">
                                    <span class="countWishlist">
                                        {{ session()->has('wish_list') ? count(session('wish_list')) : 0 }}
                                    </span>
                                </span>
                                <i class="navbar-tool-icon czi-heart"></i>
                            </a>
                        </div>

                        @if (auth('customer')->check())
                            <div class="dropdown">
                                <a class="navbar-tool ml-3" type="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <img class="img-profile rounded-circle __inline-14" alt=""
                                            src="{{ getStorageImages(path: auth('customer')->user()->image_full_url, type: 'avatar') }}">
                                    </div>
                                    <div class="navbar-tool-text d-none d-md-block">
                                        <small>{{ translate('hello') }},
                                            {{ auth('customer')->user()->f_name }}</small>
                                        {{ translate('dashboard') }}
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-black" href="{{ route('account-oder') }}">
                                        {{ translate('my_Order') }}
                                    </a>
                                    <a class="dropdown-item text-black" href="{{ route('user-account') }}">
                                        {{ translate('my_Profile') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-black" href="{{ route('customer.auth.logout') }}">
                                        {{ translate('logout') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="dropdown">
                                <a class="navbar-tool {{ Session::get('direction') === 'rtl' ? 'mr-md-3' : 'ml-md-3' }}"
                                    type="button" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="navbar-tool-icon-box bg-secondary">
                                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.25 4.41675C4.25 6.48425 5.9325 8.16675 8 8.16675C10.0675 8.16675 11.75 6.48425 11.75 4.41675C11.75 2.34925 10.0675 0.666748 8 0.666748C5.9325 0.666748 4.25 2.34925 4.25 4.41675ZM14.6667 16.5001H15.5V15.6667C15.5 12.4509 12.8825 9.83341 9.66667 9.83341H6.33333C3.11667 9.83341 0.5 12.4509 0.5 15.6667V16.5001H14.6667Z"
                                                fill="#1B7FED" />
                                        </svg>
                                    </div>
                                </a>
                                <div class="text-align-direction dropdown-menu __auth-dropdown dropdown-menu-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                                    aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item text-black" href="{{ route('customer.auth.login') }}">
                                        <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in') }}
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-black" href="{{ route('customer.auth.sign-up') }}">
                                        <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                                    </a>
                                </div>
                            </div>
                        @endif

                        <div id="cart_items" class="ml-3">
                            @include('layouts.front-end.partials._cart')
                        </div>
                    </div>

                    <!-- Mobile Wishlist in Menu -->
                    <div class="d-lg-none mt-2 border-top pt-2">
                        <a href="{{ route('wishlists') }}" class="d-flex align-items-center text-black mb-3">
                            <div class="mr-2" style="position: relative;">
                                <i class="czi-heart" style="font-size: 20px;"></i>
                                <span
                                    class="count-badge">{{ session()->has('wish_list') ? count(session('wish_list')) : 0 }}</span>
                            </div>
                            <span>My Wishlist</span>
                        </a>
                    </div>

                    <!-- Mobile Auth Menu -->
                    <div class="d-lg-none mt-2 border-top pt-2">
                        @if (auth('customer')->check())
                            <div class="d-flex align-items-center mb-3">
                                <img class="img-profile rounded-circle mr-2" style="width: 40px; height: 40px"
                                    alt=""
                                    src="{{ getStorageImages(path: auth('customer')->user()->image_full_url, type: 'avatar') }}">
                                <div>
                                    <small>{{ translate('hello') }}, {{ auth('customer')->user()->f_name }}</small>
                                    <div>{{ translate('dashboard') }}</div>
                                </div>
                            </div>
                            <ul class="list-unstyled mobile-auth-menu">
                                <li>
                                    <a href="{{ route('account-oder') }}" class="text-black">
                                        <i class="fa fa-shopping-bag mr-2"></i> {{ translate('my_Order') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user-account') }}" class="text-black">
                                        <i class="fa fa-user mr-2"></i> {{ translate('my_Profile') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('customer.auth.logout') }}" class="text-black">
                                        <i class="fa fa-sign-out mr-2"></i> {{ translate('logout') }}
                                    </a>
                                </li>
                            </ul>
                        @else
                            <div class="d-flex flex-wrap">
                                <a href="{{ route('customer.auth.login') }}"
                                    class="btn btn-outline-primary mr-2 mb-2 text-black">
                                    <i class="fa fa-sign-in mr-2"></i> {{ translate('sign_in') }}
                                </a>
                                <a href="{{ route('customer.auth.sign-up') }}"
                                    class="btn btn-outline-primary mb-2 text-black">
                                    <i class="fa fa-user-circle mr-2"></i>{{ translate('sign_up') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    /* Base Header Styles */
    #siteHeader {
        width: 100%;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    /* Topbar Styles - for BOTH desktop and mobile */
    .topbar {
        padding: 8px 15px;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .topbar .left-content,
    .topbar .right-content {
        padding: 0 5px;
    }

    .right-content {
        text-align: right;
        right: 0 !important;
    }

    .topbar a {
        color: white;
        text-decoration: none;
    }

    /* Logo Styles */
    .navbar-brand {
        max-width: 140px;
        padding: 10px 0;
    }

    .navbar-brand img {
        max-height: 50px;
    }

    /* Navigation Links */
    .navbar-nav>li>.nav-link {
        color: #000 !important;
        padding: 0.8rem 1rem;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .navbar-nav>li>.nav-link:hover {
        color: var(--web-primary) !important;
    }

    /* Dropdown Styles */
    .dropdown-menu {
        border-radius: 4px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border: none;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        color: #000 !important;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: var(--web-primary) !important;
    }

    /* Mobile Dropdown Menu */
    .dropdown-menu-mobile {
        width: 100%;
        padding: 0;
    }

    .dropdown-menu-mobile li {
        position: relative;
        border-bottom: 1px solid #f0f0f0;
    }

    .dropdown-menu-mobile li:last-child {
        border-bottom: none;
    }

    .dropdown-menu-mobile li a {
        padding: 10px 15px;
        display: block;
        color: #000 !important;
        text-decoration: none;
    }

    .dropdown-toggle-mobile {
        position: absolute;
        right: 0;
        top: 0;
        padding: 10px 15px;
        color: #000 !important;
    }

    .dropdown-submenu {
        position: static;
        width: 100%;
        box-shadow: none;
        border-radius: 0;
        margin: 0;
        padding-left: 20px;
        background-color: #f8f9fa;
    }

    /* Mobile Auth Menu */
    .mobile-auth-menu {
        margin-bottom: 15px;
    }

    .mobile-auth-menu li {
        margin-bottom: 10px;
    }

    .mobile-auth-menu li a {
        display: block;
        padding: 8px 0;
        color: #000 !important;
        text-decoration: none;
    }

    /* View All Link */
    .view-all {
        background-color: #f8f9fa;
        text-align: center;
    }

    /* Icon Styling */
    .navbar-tool-icon-box {
        position: relative;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .navbar-tool-label {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: var(--web-primary);
        color: white;
        font-size: 10px;
        font-weight: bold;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Count badge for mobile wishlist */
    .count-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: var(--web-primary);
        color: white;
        font-size: 10px;
        font-weight: bold;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Sticky Header Styles */
    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        background-color: white;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        animation: slideDown 0.35s ease-out;
        z-index: 1000;
    }

    .sticky .topbar {
        display: none;
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }

        to {
            transform: translateY(0);
        }
    }

    /* Add padding to the body when header is sticky */
    body.has-sticky-header {
        padding-top: var(--header-height, 120px);
    }

    /* Responsive Styles */
    @media (max-width: 992px) {
        .navbar-brand {
            max-width: 120px;
        }

        .navbar-toggler {
            padding: .25rem .5rem;
            font-size: 1rem;
        }

        /* Make the navbar nav scrollable on mobile */
        .navbar-collapse {
            max-height: calc(100vh - 100px);
            overflow-y: auto;
        }

        /* Fix the header at the top in mobile */
        .sticky .navbar {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    }

    @media (max-width: 576px) {
        .navbar-brand {
            max-width: 100px;
        }
    }

    .topbar {
        padding: 8px 15px;
        font-size: 14px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .topbar .left-content,
    .topbar .right-content {
        padding: 0 5px;
    }

    .right-content {
        text-align: right;
        right: 0 !important;
    }

    .topbar a {
        color: white;
        text-decoration: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('siteHeader');
        const headerHeight = header.offsetHeight;
        let isSticky = false;

        // Set CSS variable for header height
        document.documentElement.style.setProperty('--header-height', `${headerHeight}px`);

        function handleScroll() {
            const scrollPosition = window.scrollY;
            const shouldBeSticky = scrollPosition > 100; // You can adjust this threshold

            if (shouldBeSticky && !isSticky) {
                header.classList.add('sticky');
                document.body.classList.add('has-sticky-header');
                isSticky = true;
            } else if (!shouldBeSticky && isSticky) {
                header.classList.remove('sticky');
                document.body.classList.remove('has-sticky-header');
                isSticky = false;
            }
        }

        // Listen for scroll events
        window.addEventListener('scroll', handleScroll);

        // Initialize on page load
        handleScroll();

        // Mobile nested dropdown functionality
        document.querySelectorAll('.dropdown-toggle-mobile').forEach(function(element) {
            element.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const parent = this.parentElement;
                const submenu = parent.querySelector('.dropdown-submenu');

                if (submenu) {
                    if (submenu.style.display === 'block') {
                        submenu.style.display = 'none';
                        this.querySelector('i').classList.remove('fa-chevron-up');
                        this.querySelector('i').classList.add('fa-chevron-down');
                    } else {
                        submenu.style.display = 'block';
                        this.querySelector('i').classList.remove('fa-chevron-down');
                        this.querySelector('i').classList.add('fa-chevron-up');
                    }
                }
            });
        });
    });
</script>
