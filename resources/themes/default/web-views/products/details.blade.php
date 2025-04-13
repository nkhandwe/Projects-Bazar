@extends('layouts.front-end.app')

@section('title', $product['name'])

@push('css_or_js')
    <!-- Additional styles for product thumbnails on mobile and tablet -->
    <style>
        /* Default desktop vertical thumbnails */
        .product-thumbs-wrapper {
            display: flex;
            flex-direction: column;
            max-height: 400px;
            overflow-y: auto;
        }

        .product-preview-thumb {
            width: 60px;
            height: 60px;
            border: 1px solid #e2e2e2;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .product-preview-thumb:hover {
            border-color: var(--web-primary);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .product-preview-thumb.active {
            border: 2px solid var(--web-primary);
            box-shadow: 0 0 0 1px var(--web-primary);
        }

        .product-preview-thumb img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        /* Ensure smooth transitions for main image changes */
        .product-preview-item {
            transition: opacity 0.3s ease;
            opacity: 0;
            display: none;
        }

        .product-preview-item.active {
            display: flex;
            opacity: 1;
        }

        /* Mobile and tablet view (less than 992px) */
        @media (max-width: 991px) {

            /* Hide the left column thumbnails */
            .product-thumbs-col {
                display: none;
            }

            /* Create new horizontal thumbnail row above main image */
            .mobile-thumbs-row {
                display: flex;
                width: 100%;
                overflow-x: auto;
                margin-bottom: 15px;
                padding-bottom: 5px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding: 5px;
                background: rgba(249, 249, 249, 0.7);
                border-radius: 8px;
            }

            .mobile-thumbs-row::-webkit-scrollbar {
                display: none;
                /* Chrome, Safari, Edge */
            }

            .mobile-thumbs-row .product-preview-thumb {
                flex: 0 0 auto;
                width: 70px;
                height: 70px;
                margin-right: 10px;
                margin-bottom: 0;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            }

            .mobile-thumbs-row .product-preview-thumb:hover {
                transform: translateY(-1px);
            }

            .mobile-thumbs-row .product-preview-thumb.active {
                border: 2px solid var(--web-primary);
            }

            /* Adjust main image container */
            .product-main-col {
                width: 100%;
            }
        }

        /* Small mobile view adjustments */
        @media (max-width: 576px) {
            .mobile-thumbs-row .product-preview-thumb {
                width: 60px;
                height: 60px;
                margin-right: 8px;
            }
        }

        /* Fix for owl carousel navigation */
        #sync1 .owl-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            transform: translateY(-50%);
            display: flex;
            justify-content: space-between;
            pointer-events: none;
        }

        #sync1 .owl-nav button {
            background: rgba(255, 255, 255, 0.8) !important;
            width: 40px;
            height: 40px;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            pointer-events: auto;
            margin: 0 10px;
        }

        #sync1 .owl-nav button:hover {
            background: #fff !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        #sync1 .owl-nav button i {
            font-size: 18px;
            color: #333;
        }

        /* Fixed background image styling */
        .brand-new-boxes-section {
            position: relative;
            width: 100%;
            padding: 50px 0;
            background: #fdf4f5 url('{{ asset('public/assets/front-end/img/icons/bg-section.png') }}') no-repeat;
            background-size: 100% 100%;
            background-position: center;
            background-blend-mode: normal;
            /* This ensures the image doesn't blend with background color */
        }

        /* Add a pseudo-element to ensure the background image shows properly */
        .brand-new-boxes-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('{{ asset('public/assets/front-end/img/icons/bg-section.png') }}') no-repeat;
            background-size: 100% 100%;
            background-position: center;
            opacity: 1;
            z-index: -1;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {

            .brand-new-boxes-section,
            .brand-new-boxes-section::before {
                background-size: fit;
            }
        }

        /* Default Styles for sticky bar */
        .responsive-layout {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
        }

        .left-section {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .product-image {
            height: 50px;
            width: 50px;
            object-fit: cover;
        }

        .right-section {
            display: flex;
            gap: 15px;
        }

        /* For Screens 1200px and Below */
        @media (max-width: 1200px) {
            .responsive-layout {
                flex-wrap: wrap;
                gap: 15px;
            }

            .left-section,
            .right-section {
                flex: 1 1 100%;
                justify-content: space-between;
            }

            .left-section {
                flex-direction: row;
            }

            .right-section {
                justify-content: center;
                margin-top: 10px;
            }
        }

        /* Increase bottom sticky buttons text size */
        .bottom-sticky .string-limit {
            font-size: 16px !important;
            /* Increased from default */
            font-weight: 600;
        }

        .bottom-sticky .btn {
            padding: 8px 16px !important;
            /* Slightly larger padding to accommodate larger text */
        }

        .bottom-sticky .price-details {
            font-size: 15px !important;
            /* Increased from 13px */
        }

        .bottom-sticky #chosen_price_mobile,
        .bottom-sticky #set-tax-amount-mobile {
            font-size: 16px !important;
        }

        /* Increase FAQ section text size */
        #faqAccordion .card-header h2 .btn-link {
            font-size: 18px !important;
            /* Increased from default */
            font-weight: 500;
        }

        #faqAccordion .card-body {
            font-size: 16px !important;
            /* Increased from default */
            line-height: 1.6;
        }

        /* Make the FAQ section more prominent */
        #faqAccordion .card {
            margin-bottom: 12px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #faqAccordion .card-header {
            /* background-color: #f8f9fa; */
            padding: 15px 20px;
        }


        /* Make sure toggle icon is aligned and visible */
        #faqAccordion .toggle-icon {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        #faqAccordion .collapsed .toggle-icon.tio-add {
            transform: rotate(0deg);
        }

        #faqAccordion .toggle-icon.tio-remove {
            transform: rotate(180deg);
        }
    </style>
@endpush

@section('content')
    <div class="__inline-23 bg-white">
        <div class="container mt-4 rtl text-align-direction">
            <div class="row {{ Session::get('direction') === 'rtl' ? '__dir-rtl' : '' }}">
                <div class="col-lg-12 col-12">
                    <?php $guestCheckout = getWebConfig(name: 'guest_checkout'); ?>
                    <div class="row">
                        <!-- Desktop Thumbnails Column (hidden on mobile/tablet) -->
                        <div class="col-lg-1 col-md-1 col-1 product-thumbs-col">
                            <div class="cz">
                                <div class="table-responsive __max-h-515px" data-simplebar>
                                    <div class="product-thumbs-wrapper">
                                        @if ($product->images != null && json_decode($product->images) > 0)
                                            @if (json_decode($product->colors) && count($product->color_images_full_url) > 0)
                                                @foreach ($product->color_images_full_url as $key => $photo)
                                                    @if ($photo['color'] != null)
                                                        <a class="product-preview-thumb color-variants-preview-box-{{ $photo['color'] }} {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                            id="preview-img{{ $photo['color'] }}"
                                                            href="#image{{ $photo['color'] }}">
                                                            <img alt="{{ translate('product') }}"
                                                                src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                        </a>
                                                    @else
                                                        <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                            id="preview-img{{ $key }}"
                                                            href="#image{{ $key }}">
                                                            <img alt="{{ translate('product') }}"
                                                                src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($product->images_full_url as $key => $photo)
                                                    <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                        id="preview-img{{ $key }}"
                                                        href="#image{{ $key }}">
                                                        <img alt="{{ translate('product') }}"
                                                            src="{{ getStorageImages(path: $photo, type: 'product') }}">
                                                    </a>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-md-12 col-12 product-main-col">
                            <!-- Mobile/Tablet Thumbnails Row (visible only on mobile/tablet) -->
                            <div class="mobile-thumbs-row d-none d-md-flex d-lg-none">
                                @if ($product->images != null && json_decode($product->images) > 0)
                                    @if (json_decode($product->colors) && count($product->color_images_full_url) > 0)
                                        @foreach ($product->color_images_full_url as $key => $photo)
                                            @if ($photo['color'] != null)
                                                <a class="product-preview-thumb color-variants-preview-box-{{ $photo['color'] }} {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                    id="mobile-preview-img{{ $photo['color'] }}"
                                                    href="#image{{ $photo['color'] }}">
                                                    <img alt="{{ translate('product') }}"
                                                        src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                </a>
                                            @else
                                                <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                    id="mobile-preview-img{{ $key }}"
                                                    href="#image{{ $key }}">
                                                    <img alt="{{ translate('product') }}"
                                                        src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($product->images_full_url as $key => $photo)
                                            <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                id="mobile-preview-img{{ $key }}"
                                                href="#image{{ $key }}">
                                                <img alt="{{ translate('product') }}"
                                                    src="{{ getStorageImages(path: $photo, type: 'product') }}">
                                            </a>
                                        @endforeach
                                    @endif
                                @endif
                            </div>

                            <!-- Small Mobile Thumbnails Row (visible only on small mobile) -->
                            <div class="mobile-thumbs-row d-md-none">
                                @if ($product->images != null && json_decode($product->images) > 0)
                                    @if (json_decode($product->colors) && count($product->color_images_full_url) > 0)
                                        @foreach ($product->color_images_full_url as $key => $photo)
                                            @if ($photo['color'] != null)
                                                <a class="product-preview-thumb color-variants-preview-box-{{ $photo['color'] }} {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                    id="mobile-sm-preview-img{{ $photo['color'] }}"
                                                    href="#image{{ $photo['color'] }}">
                                                    <img alt="{{ translate('product') }}"
                                                        src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                </a>
                                            @else
                                                <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                    id="mobile-sm-preview-img{{ $key }}"
                                                    href="#image{{ $key }}">
                                                    <img alt="{{ translate('product') }}"
                                                        src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}">
                                                </a>
                                            @endif
                                        @endforeach
                                    @else
                                        @foreach ($product->images_full_url as $key => $photo)
                                            <a class="product-preview-thumb {{ $key == 0 ? 'active' : '' }} d-flex align-items-center justify-content-center"
                                                id="mobile-sm-preview-img{{ $key }}"
                                                href="#image{{ $key }}">
                                                <img alt="{{ translate('product') }}"
                                                    src="{{ getStorageImages(path: $photo, type: 'product') }}">
                                            </a>
                                        @endforeach
                                    @endif
                                @endif
                            </div>

                            <div class="cz-product-gallery">
                                <div class="cz-preview">
                                    <div id="sync1" class="owl-carousel owl-theme product-thumbnail-slider">
                                        <!-- Rest of the content remains the same -->
                                        @if ($product->images != null && json_decode($product->images) > 0)
                                            @if (json_decode($product->colors) && count($product->color_images_full_url) > 0)
                                                @foreach ($product->color_images_full_url as $key => $photo)
                                                    @if ($photo['color'] != null)
                                                        <div class="product-preview-item d-flex align-items-center justify-content-center {{ $key == 0 ? 'active' : '' }}"
                                                            id="image{{ $photo['color'] }}">
                                                            <img class="cz-image-zoom img-responsive w-100"
                                                                src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}"
                                                                data-zoom="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}"
                                                                alt="{{ translate('product') }}" width="">
                                                            <div class="cz-image-zoom-pane"></div>
                                                        </div>
                                                    @else
                                                        <div class="product-preview-item d-flex align-items-center justify-content-center {{ $key == 0 ? 'active' : '' }}"
                                                            id="image{{ $key }}">
                                                            <img class="cz-image-zoom img-responsive w-100"
                                                                src="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}"
                                                                data-zoom="{{ getStorageImages(path: $photo['image_name'], type: 'product') }}"
                                                                alt="{{ translate('product') }}" width="">
                                                            <div class="cz-image-zoom-pane"></div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach ($product->images_full_url as $key => $photo)
                                                    <div class="product-preview-item d-flex align-items-center justify-content-center {{ $key == 0 ? 'active' : '' }}"
                                                        id="image{{ $key }}">
                                                        <img class="cz-image-zoom img-responsive w-100"
                                                            src="{{ getStorageImages($photo, type: 'product') }}"
                                                            data-zoom="{{ getStorageImages(path: $photo, type: 'product') }}"
                                                            alt="{{ translate('product') }}" width="">
                                                        <div class="cz-image-zoom-pane"></div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>

                                    @if ($product?->preview_file_full_url['path'])
                                        <div>
                                            <div class="product-preview-modal-text" data-toggle="modal"
                                                data-target="#product-preview-modal">
                                                <span class="text-primary fw-bold py-2 user-select-none fs-14">
                                                    {{ translate('See_Preview') }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex flex-column gap-3">
                                    <button type="button" data-product-id="{{ $product['id'] }}"
                                        class="btn __text-18px border wishList-pos-btn d-sm-none product-action-add-wishlist">
                                        <i class="fa {{ $wishlistStatus == 1 ? 'fa-heart' : 'fa-heart-o' }} wishlist_icon_{{ $product['id'] }} web-text-primary"
                                            aria-hidden="true"></i>
                                        <div class="wishlist-tooltip" x-placement="top">
                                            <div class="arrow"></div>
                                            <div class="inner">
                                                <span class="add">{{ translate('added_to_wishlist') }}</span>
                                                <span class="remove">{{ translate('removed_from_wishlist') }}</span>
                                            </div>
                                        </div>
                                    </button>

                                    <div class="sharethis-inline-share-buttons share--icons text-align-direction">
                                    </div>

                                </div>


                            </div>
                        </div>

                        <div class="col-lg-6 col-md-8 col-12 mt-md-0 mt-sm-3 web-direction">
                            <div class="details __h-100">
                                <h1 class="mb-2 __inline-24">{{ $product->name }}</h1>
                                <div class="d-flex flex-wrap align-items-center mb-2 pro">
                                    <div class="star-rating me-2">
                                        @for ($inc = 1; $inc <= 5; $inc++)
                                            @if ($inc <= (int) $overallRating[0])
                                                <i class="tio-star text-warning"></i>
                                            @elseif ($overallRating[0] != 0 && $inc <= (int) $overallRating[0] + 1.1 && $overallRating[0] > ((int) $overallRating[0]))
                                                <i class="tio-star-half text-warning"></i>
                                            @else
                                                <i class="tio-star-outlined text-warning"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span
                                        class="d-inline-block  align-middle mt-1 {{ Session::get('direction') === 'rtl' ? 'ml-md-2 ml-sm-0' : 'mr-md-2 mr-sm-0' }} fs-14 text-muted">({{ $overallRating[0] }})</span>
                                    <span
                                        class="font-regular font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{ Session::get('direction') === 'rtl' ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1' }}"><span
                                            class="web-text-primary">{{ $overallRating[1] }}</span>
                                        {{ translate('reviews') }}</span>
                                    <span class="__inline-25"></span>
                                    <span
                                        class="font-regular font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{ Session::get('direction') === 'rtl' ? 'mr-1 ml-md-2 ml-1 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-1 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1' }}"><span
                                            class="web-text-primary">{{ $countOrder }}</span> {{ translate('orders') }}
                                    </span>
                                    <span class="__inline-25"> </span>
                                    <span
                                        class="font-regular font-for-tab d-inline-block font-size-sm text-body align-middle mt-1 {{ Session::get('direction') === 'rtl' ? 'mr-1 ml-md-2 ml-0 pr-md-2 pr-sm-1 pl-md-2 pl-sm-1' : 'ml-1 mr-md-2 mr-0 pl-md-2 pl-sm-1 pr-md-2 pr-sm-1' }} text-capitalize">
                                        <span class="web-text-primary countWishlist-{{ $product->id }}">
                                            {{ $countWishlist }}</span> {{ translate('wish_listed') }} </span>
                                </div>

                                @if ($product['product_type'] == 'digital')
                                    <div class="digital-product-authors mb-2">
                                        @if (count($productPublishingHouseInfo['data']) > 0)
                                            <div class="d-flex align-items-center g-2 me-2">
                                                <span
                                                    class="text-capitalize digital-product-author-title">{{ translate('Publishing_House') }}
                                                    :</span>
                                                <div class="item-list">
                                                    @foreach ($productPublishingHouseInfo['data'] as $publishingHouseName)
                                                        <a href="{{ route('products', ['publishing_house_id' => $publishingHouseName['id'], 'product_type' => 'digital', 'page' => 1]) }}"
                                                            class="text-base">
                                                            {{ $publishingHouseName['name'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        @if (count($productAuthorsInfo['data']) > 0)
                                            <div class="d-flex align-items-center g-2 me-2">
                                                <span
                                                    class="text-capitalize digital-product-author-title">{{ translate('Author') }}
                                                    :</span>
                                                <div class="item-list">
                                                    @foreach ($productAuthorsInfo['data'] as $productAuthor)
                                                        <a href="{{ route('products', ['author_id' => $productAuthor['id'], 'product_type' => 'digital', 'page' => 1]) }}"
                                                            class="text-base">
                                                            {{ $productAuthor['name'] }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                @endif
                                <div class="mb-3">
                                    <span class="font-weight-normal text-accent d-flex align-items-end gap-2">
                                        {!! getPriceRangeWithDiscount(product: $product) !!}
                                    </span>
                                </div>

                                <form id="add-to-cart-form" class="mb-2">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <div
                                        class="position-relative {{ Session::get('direction') === 'rtl' ? 'ml-n4' : 'mr-n4' }} mb-2">
                                        @if (count(json_decode($product->colors)) > 0)
                                            <div class="flex-start align-items-center mb-2">
                                                <div class="product-description-label m-0 text-dark font-bold">
                                                    {{ translate('color') }}
                                                    :
                                                </div>
                                                <div>
                                                    <ul class="list-inline checkbox-color mb-0 flex-start ms-2 ps-0">
                                                        @foreach (json_decode($product->colors) as $key => $color)
                                                            <li>
                                                                <input type="radio"
                                                                    id="{{ str_replace(' ', '', $product->id . '-color-' . str_replace('#', '', $color)) }}"
                                                                    name="color" value="{{ $color }}"
                                                                    @if ($key == 0) checked @endif>
                                                                <label style="background: {{ $color }};"
                                                                    class="focus-preview-image-by-color shadow-border"
                                                                    for="{{ str_replace(' ', '', $product->id . '-color-' . str_replace('#', '', $color)) }}"
                                                                    data-toggle="tooltip"
                                                                    data-key="{{ str_replace('#', '', $color) }}"
                                                                    data-colorid="preview-box-{{ str_replace('#', '', $color) }}"
                                                                    data-title="{{ \App\Utils\get_color_name($color) }}">
                                                                    <span class="outline"></span></label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                        @php
                                            $qty = 0;
                                            if (!empty($product->variation)) {
                                                foreach (json_decode($product->variation) as $key => $variation) {
                                                    $qty += $variation->qty;
                                                }
                                            }
                                        @endphp
                                    </div>

                                    @php($extensionIndex = 0)
                                    @if (
                                        $product['product_type'] == 'digital' &&
                                            $product['digital_product_file_types'] &&
                                            count($product['digital_product_file_types']) > 0 &&
                                            $product['digital_product_extensions']
                                    )
                                        @foreach ($product['digital_product_extensions'] as $extensionKey => $extensionGroup)
                                            <div class="row flex-start mx-0 align-items-center mb-1">
                                                <div
                                                    class="product-description-label text-dark font-bold {{ Session::get('direction') === 'rtl' ? 'pl-2' : 'pr-2' }} text-capitalize mb-2">
                                                    {{ translate($extensionKey) }} :
                                                </div>
                                                <div>
                                                    @if (count($extensionGroup) > 0)
                                                        <div
                                                            class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-0 mx-1 flex-start row ps-0">
                                                            @foreach ($extensionGroup as $index => $extension)
                                                                <div>
                                                                    <div class="for-mobile-capacity">
                                                                        <input type="radio" hidden
                                                                            id="extension_{{ str_replace(' ', '-', $extension) }}"
                                                                            name="variant_key"
                                                                            value="{{ $extensionKey . '-' . preg_replace('/\s+/', '-', $extension) }}"
                                                                            {{ $extensionIndex == 0 ? 'checked' : '' }}>
                                                                        <label
                                                                            for="extension_{{ str_replace(' ', '-', $extension) }}"
                                                                            class="__text-12px">
                                                                            {{ $extension }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                @php($extensionIndex++)
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @foreach (json_decode($product->choice_options) as $key => $choice)
                                        <div class="row flex-start mx-0 align-items-center">
                                            <div
                                                class="product-description-label text-dark font-bold {{ Session::get('direction') === 'rtl' ? 'pl-2' : 'pr-2' }} text-capitalize mb-2">
                                                {{ $choice->title }}
                                                :
                                            </div>
                                            <div>
                                                <div
                                                    class="list-inline checkbox-alphanumeric checkbox-alphanumeric--style-1 mb-0 mx-1 flex-start row ps-0">

                                                    @foreach ($choice->options as $index => $option)
                                                        <div>
                                                            <div class="for-mobile-capacity">
                                                                <input type="radio"
                                                                    id="{{ str_replace(' ', '', $choice->name . '-' . $option) }}"
                                                                    name="{{ $choice->name }}"
                                                                    value="{{ $option }}"
                                                                    @if ($index == 0) checked @endif>
                                                                <label class="__text-12px"
                                                                    for="{{ str_replace(' ', '', $choice->name . '-' . $option) }}"">{{ $option }}</label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="mt-3">
                                        <div class="product-quantity d-flex flex-column __gap-15">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="product-description-label text-dark font-bold mt-0">
                                                    {{ translate('quantity') }} :
                                                </div>
                                                <div
                                                    class="d-flex justify-content-center align-items-center quantity-box border rounded border-base web-text-primary">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number __p-10 web-text-primary"
                                                            type="button" data-type="minus" data-field="quantity"
                                                            disabled="disabled">
                                                            -
                                                        </button>
                                                    </span>
                                                    <input type="text" name="quantity"
                                                        class="form-control input-number text-center cart-qty-field __inline-29 border-0 "
                                                        placeholder="{{ translate('1') }}"
                                                        value="{{ $product->minimum_order_qty ?? 1 }}"
                                                        data-producttype="{{ $product->product_type }}"
                                                        min="{{ $product->minimum_order_qty ?? 1 }}"
                                                        max="{{ $product['product_type'] == 'physical' ? $product->current_stock : 100 }}">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-number __p-10 web-text-primary"
                                                            type="button"
                                                            data-producttype="{{ $product->product_type }}"
                                                            data-type="plus" data-field="quantity">
                                                            +
                                                        </button>
                                                    </span>
                                                </div>
                                                <input type="hidden" class="product-generated-variation-code"
                                                    name="product_variation_code"
                                                    data-product-id="{{ $product['id'] }}">
                                                <input type="hidden" value=""
                                                    class="in_cart_key form-control w-50" name="key">
                                            </div>
                                            <div id="chosen_price_div">
                                                <div
                                                    class="d-none d-sm-flex justify-content-start align-items-center me-2">
                                                    <div
                                                        class="product-description-label text-dark font-bold text-capitalize">
                                                        <strong>{{ translate('total_price') }}</strong> :
                                                    </div>
                                                    &nbsp; <strong id="chosen_price" class="text-base"></strong>
                                                    <small class="ms-2 font-regular">
                                                        (<small>{{ translate('tax') }} : </small>
                                                        <small id="set-tax-amount"></small>)
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="__btn-grp mt-2 mb-3 d-none d-sm-flex">
                                        @if (
                                            ($product->added_by == 'seller' &&
                                                ($sellerTemporaryClose ||
                                                    (isset($product->seller->shop) &&
                                                        $product->seller->shop->vacation_status &&
                                                        $currentDate >= $sellerVacationStartDate &&
                                                        $currentDate <= $sellerVacationEndDate))) ||
                                                ($product->added_by == 'admin' &&
                                                    ($inHouseTemporaryClose ||
                                                        ($inHouseVacationStatus &&
                                                            $currentDate >= $inHouseVacationStartDate &&
                                                            $currentDate <= $inHouseVacationEndDate))))
                                            <button class="btn btn-secondary" type="button" disabled>
                                                {{ translate('buy_now') }}
                                            </button>
                                            <button class="btn btn--primary string-limit" type="button" disabled>
                                                {{ translate('add_to_cart') }}
                                            </button>
                                        @else
                                            <button type="button"
                                                data-auth-status="{{ $guestCheckout == 1 || Auth::guard('customer')->check() ? 'true' : 'false' }}"
                                                data-route="{{ route('shop-cart') }}"
                                                class="btn btn-secondary element-center btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} action-buy-now-this-product">
                                                <span class="string-limit">{{ translate('buy_now') }}</span>
                                            </button>
                                            <button
                                                class="btn btn--primary element-center btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} action-add-to-cart-form"
                                                type="button" data-update-text="{{ translate('update_cart') }}"
                                                data-add-text="{{ translate('add_to_cart') }}">
                                                <span class="string-limit">{{ translate('add_to_cart') }}</span>
                                            </button>
                                        @endif
                                        <button type="button" data-product-id="{{ $product['id'] }}"
                                            class="btn __text-18px border d-none d-sm-block product-action-add-wishlist">
                                            <i class="fa {{ $wishlistStatus == 1 ? 'fa-heart' : 'fa-heart-o' }} wishlist_icon_{{ $product['id'] }} web-text-primary"
                                                aria-hidden="true"></i>
                                            <span
                                                class="fs-14 text-muted align-bottom countWishlist-{{ $product['id'] }}">{{ $countWishlist }}</span>
                                            <div class="wishlist-tooltip" x-placement="top">
                                                <div class="arrow"></div>
                                                <div class="inner">
                                                    <span class="add">{{ translate('added_to_wishlist') }}</span>
                                                    <span class="remove">{{ translate('removed_from_wishlist') }}</span>
                                                </div>
                                            </div>
                                        </button>
                                        @if (
                                            ($product->added_by == 'seller' &&
                                                ($sellerTemporaryClose ||
                                                    (isset($product->seller->shop) &&
                                                        $product->seller->shop->vacation_status &&
                                                        $currentDate >= $sellerVacationStartDate &&
                                                        $currentDate <= $sellerVacationEndDate))) ||
                                                ($product->added_by == 'admin' &&
                                                    ($inHouseTemporaryClose ||
                                                        ($inHouseVacationStatus &&
                                                            $currentDate >= $inHouseVacationStartDate &&
                                                            $currentDate <= $inHouseVacationEndDate))))
                                            <div class="alert alert-danger" role="alert">
                                                {{ translate('this_shop_is_temporary_closed_or_on_vacation._You_cannot_add_product_to_cart_from_this_shop_for_now') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="row no-gutters d-none flex-start d-flex">
                                        <div class="col-12">
                                            @if ($product['product_type'] == 'physical')
                                                <h5 class="text-danger out-of-stock-element d--none">
                                                    {{ translate('out_of_stock') }}</h5>
                                            @endif
                                        </div>
                                    </div>

                                </form>
                                @if ($product->video_url != null)
                                    <div>
                                        <div class="col-12 mb-4 mt-4">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" width="200" height="315"
                                                    src="{{ $product->video_url }}" allowfullscreen></iframe>
                                            </div>
                                        </div>
                                        <style>
                                            .embed-responsive {
                                                width: 70% !important;
                                            }
                                        </style>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        @if ($product['details'])
                            <div class="mt-4 rtl col-12 col-md-12 col-sm-12 text-align-direction">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center mt-5">
                                            <h1><strong>PRODUCT <span class="text-primary">OVERVIEW</span> </strong></h1>
                                            <h4 class="mb-5 fs-3">Our newly launched toys are already taking the world by
                                                storm.
                                                You definitely
                                                don't want to miss out on these!</h4>
                                        </div>
                                        <div
                                            class="text-body mb-5 col-lg-12 col-md-12 col-sm-12 fs-13 text-justify details-text-justify rich-editor-html-content">
                                            {!! $product['details'] !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BRAND NEW BOXES Section with Fixed Background Image -->
    <div class="brand-new-boxes-section">
        <!-- Content container -->
        <div class="container">
            <div class="text-center mb-5">
                <h1><strong>BRAND <span class="text-primary">NEW BOXES</span> OF JOY</strong></h1>
                <h4 class="mb-2">Our newly launched toys are already taking the world by storm. You definitely
                    don't want to miss out on these!</h4>
            </div>

            <!-- Product card container -->
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12 mb-4">
                    @include('web-views.partials._product-card-2', [
                        'product' => $product,
                        'decimal_point_settings' => $decimalPointSettings,
                    ])
                </div>

                <!-- You can add more product cards here as needed -->
                @if (isset($moreProductFromSeller) && count($moreProductFromSeller) > 0)
                    @foreach ($moreProductFromSeller as $item)
                        <div class="col-md-3 col-sm-6 col-12 mb-4">
                            @include('web-views.partials._product-card-2', [
                                'product' => $item,
                                'decimal_point_settings' => $decimalPointSettings,
                            ])
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

<!-- FAQ Section -->
<div class="mb-5">
    <div class="pt-4 pb-1 container">
        <div class="container rtl mt-4">
            <div class="text-center mt-5 mb-5">
                <h1 class="d-flex align-items-center justify-content-center gap-2">
                    <i class="tio-help"></i> <strong>FAQ<span class="text-primary">'s</span></strong>
                </h1>
                <h4 class="mb-2">Our newly launched toys are already taking the world by storm. You definitely don't want to miss out on these!</h4>
            </div>
        </div>
        @php($faqs = \App\Models\ProductFaq::all())
        <div class="accordion custom-accordion" id="faqAccordion">
            @foreach ($faqs as $index => $faq)
                <div class="card border-0 mb-3">
                    <div class="card-header bg-white" id="heading{{ $index }}">
                        <h2 class="mb-0">
                            <button class="btn btn-link w-100 text-left text-dark d-flex align-items-center justify-content-between py-3 {{ $index == 0 ? '' : 'collapsed' }}"
                                type="button" data-toggle="collapse" data-target="#collapse{{ $index }}"
                                aria-expanded="{{ $index == 0 ? 'true' : 'false' }}"
                                aria-controls="collapse{{ $index }}">
                                <span class="faq-question">{{ $faq['question'] }}</span>
                                <i class="icon tio {{ $index == 0 ? 'tio-remove' : 'tio-add' }} toggle-icon"></i>
                            </button>
                        </h2>
                    </div>
                    <div id="collapse{{ $index }}" class="collapse {{ $index == 0 ? 'show' : '' }}"
                        aria-labelledby="heading{{ $index }}" data-parent="#faqAccordion">
                        <div class="card-body pb-4 pt-1">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
/* Modern FAQ Styling */
.custom-accordion .card {
    border-radius: 12px !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 1rem;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
}

.custom-accordion .card-header {
    border-bottom: none;
    padding: 0;
    background-color: #fff;
}

.custom-accordion .btn-link {
    color: #333;
    font-weight: 500;
    text-decoration: none;
    font-size: 18px;
    padding: 15px 20px;
}

.custom-accordion .btn-link:hover {
    text-decoration: none;
    color: var(--web-primary);
}

.custom-accordion .btn-link.collapsed {
    color: #333;
}

.custom-accordion .toggle-icon {
    color: var(--web-primary);
    font-size: 20px;
    transition: transform 0.3s ease;
}

.custom-accordion .collapsed .toggle-icon.tio-add {
    transform: rotate(0deg);
}

.custom-accordion .toggle-icon.tio-remove {
    transform: rotate(0deg);
}

.custom-accordion .card-body {
    color: #666;
    font-size: 16px;
    line-height: 1.6;
    padding: 0 20px 20px 20px;
}

.custom-accordion .faq-question {
    color: #333;
    font-weight: 500;
}

.custom-accordion .btn-link:not(.collapsed) .faq-question {
    color: var(--web-primary);
    font-weight: 600;
}

/* Make heading icon look better */
.tio-help-circle {
    color: var(--web-primary);
    font-size: 28px;
    margin-right: 10px;
}

/* Hover effect for cards */
.custom-accordion .card:hover {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}
</style>

<script>
    $(document).ready(function() {
        // Add smooth toggle animation for FAQ accordions
        $('.custom-accordion .btn-link').on('click', function() {
            // Toggle the icon
            if($(this).hasClass('collapsed')) {
                $(this).find('.toggle-icon').removeClass('tio-add').addClass('tio-remove');
            } else {
                $(this).find('.toggle-icon').removeClass('tio-remove').addClass('tio-add');
            }
            
            // Smooth animation for siblings
            $('.custom-accordion .btn-link').not(this).addClass('collapsed');
            $('.custom-accordion .btn-link').not(this).find('.toggle-icon').removeClass('tio-remove').addClass('tio-add');
        });
    });
</script>

    <!-- Bottom Sticky Bar -->
    <div class="bottom-sticky bg-white">
        <div class="d-flex flex-column gap-1 py-2 container">
            <div class="d-flex justify-content-between align-items-center flex-wrap responsive-layout">
                <div class="d-flex align-items-center gap-2 left-section">
                    <img src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'product') }}"
                        alt="" class="product-image">
                    <div class="fs-13 price-details">
                        <div class="product-description-label text-dark font-bold">
                            <strong class="text-capitalize">{{ translate('total_price') }}</strong> :
                        </div>
                        <strong id="chosen_price_mobile" class="text-base"></strong>
                        <small class="ml-2 font-regular">
                            (<small>{{ translate('tax') }} : </small>
                            <small id="set-tax-amount-mobile"></small>)
                        </small>
                    </div>
                </div>
                <div class="d-flex gap-3 right-section">
                    <div
                        class="d-flex justify-content-center align-items-center quantity-box border rounded border-base web-text-primary">
                        <span class="input-group-btn">
                            <button class="btn btn-number __p-10 web-text-primary" type="button" data-type="minus"
                                data-field="quantity" disabled="disabled">
                                -
                            </button>
                        </span>
                        <input type="text" name="quantity"
                            class="form-control input-number text-center cart-qty-field __inline-29 border-0 "
                            placeholder="{{ translate('1') }}" value="{{ $product->minimum_order_qty ?? 1 }}"
                            data-producttype="{{ $product->product_type }}"
                            min="{{ $product->minimum_order_qty ?? 1 }}"
                            max="{{ $product['product_type'] == 'physical' ? $product->current_stock : 100 }}">
                        <span class="input-group-btn">
                            <button class="btn btn-number __p-10 web-text-primary" type="button"
                                data-producttype="{{ $product->product_type }}" data-type="plus" data-field="quantity">
                                +
                            </button>
                        </span>
                    </div>
                    @if (
                        ($product->added_by == 'seller' &&
                            ($sellerTemporaryClose ||
                                (isset($product->seller->shop) &&
                                    $product->seller->shop->vacation_status &&
                                    $currentDate >= $sellerVacationStartDate &&
                                    $currentDate <= $sellerVacationEndDate))) ||
                            ($product->added_by == 'admin' &&
                                ($inHouseTemporaryClose ||
                                    ($inHouseVacationStatus &&
                                        $currentDate >= $inHouseVacationStartDate &&
                                        $currentDate <= $inHouseVacationEndDate))))
                        <button
                            class="btn btn-secondary btn-sm btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            type="button" disabled>
                            {{ translate('buy_now') }}
                        </button>
                        <button
                            class="btn btn--primary btn-sm string-limit btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }}"
                            type="button" disabled>
                            {{ translate('add_to_cart') }}
                        </button>
                        <button type="button" data-product-id="{{ $product['id'] }}"
                            class="btn __text-18px border d-none d-sm-block product-action-add-wishlist">
                            <i class="fa {{ $wishlistStatus == 1 ? 'fa-heart' : 'fa-heart-o' }} wishlist_icon_{{ $product['id'] }} web-text-primary"
                                aria-hidden="true"></i>
                            <span
                                class="fs-14 text-muted align-bottom countWishlist-{{ $product['id'] }}">{{ $countWishlist }}</span>
                            <div class="wishlist-tooltip" x-placement="top">
                                <div class="arrow"></div>
                                <div class="inner">
                                    <span class="add">{{ translate('added_to_wishlist') }}</span>
                                    <span class="remove">{{ translate('removed_from_wishlist') }}</span>
                                </div>
                            </div>
                        </button>
                    @else
                        <button
                            class="btn btn-secondary btn-sm btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} action-buy-now-this-product"
                            type="button"
                            data-auth-status="{{ $guestCheckout == 1 || Auth::guard('customer')->check() ? 'true' : 'false' }}"
                            data-route="{{ route('shop-cart') }}">
                            <span class="string-limit">{{ translate('buy_now') }}</span>
                        </button>
                        <button
                            class="btn btn--primary btn-sm string-limit btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} action-add-to-cart-form"
                            type="button">
                            <span class="string-limit">{{ translate('add_to_cart') }}</span>
                        </button>
                        <button type="button" data-product-id="{{ $product['id'] }}"
                            class="btn __text-18px d-none d-sm-block product-action-add-wishlist">
                            <i class="fa {{ $wishlistStatus == 1 ? 'fa-heart' : 'fa-heart-o' }} wishlist_icon_{{ $product['id'] }} web-text-primary"
                                aria-hidden="true"></i>

                            <div class="wishlist-tooltip" x-placement="top">
                                <div class="arrow"></div>
                                <div class="inner">
                                    <span class="add">{{ translate('added_to_wishlist') }}</span>
                                    <span class="remove">{{ translate('removed_from_wishlist') }}</span>
                                </div>
                            </div>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade rtl text-align-direction" id="show-modal-view" tabindex="-1" role="dialog"
        aria-labelledby="show-modal-image" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body flex justify-content-center">
                    <button class="btn btn-default __inline-33 dir-end-minus-7px" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <img class="element-center" id="attachment-view" src="" alt="">
                </div>
            </div>
        </div>
    </div>

    @if ($product?->preview_file_full_url['path'])
        @include('web-views.partials._product-preview-modal', [
            'previewFileInfo' => $previewFileInfo,
        ])
    @endif

    @include('layouts.front-end.partials.modal._chatting', [
        'seller' => $product->seller,
        'user_type' => $product->added_by,
    ])

    <span id="route-review-list-product" data-url="{{ route('review-list-product') }}"></span>
    <span id="products-details-page-data" data-id="{{ $product['id'] }}"></span>
@endsection

@push('script')
    <script src="{{ theme_asset(path: 'public/assets/front-end/js/product-details.js') }}"></script>
    <script type="text/javascript" async="async"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f55f75bde227f0012147049&product=sticky-share-buttons">
    </script>

    <!-- Updated JavaScript for thumbnails on mobile and desktop -->
    <script>
        $(document).ready(function() {
            // Common function to handle thumbnail clicks
            function handleThumbnailClick(elem) {
                var targetId = $(elem).attr('href');

                // Remove active class from all thumbnails
                $('.product-preview-thumb').removeClass('active');

                // Add active class to clicked thumbnail
                $(elem).addClass('active');

                // Hide all preview images
                $('.product-preview-item').removeClass('active');

                // Show the target image
                $(targetId).addClass('active');

                // Control the owl carousel to show the corresponding slide
                var index = $(targetId).index();
                $('#sync1').trigger('to.owl.carousel', [index, 300]);
            }

            // Desktop thumbnails click handler
            $('.product-thumbs-wrapper .product-preview-thumb').on('click', function(e) {
                e.preventDefault();
                handleThumbnailClick(this);

                // Update mobile thumbnails to match
                var targetId = $(this).attr('href');
                $('.mobile-thumbs-row').find('a[href="' + targetId + '"]').addClass('active');
            });

            // Mobile/Tablet thumbnails click handler
            $('.mobile-thumbs-row .product-preview-thumb').on('click', function(e) {
                e.preventDefault();
                handleThumbnailClick(this);

                // Synchronize with desktop thumbnails
                var targetId = $(this).attr('href');
                $('.product-thumbs-wrapper').find('a[href="' + targetId + '"]').addClass('active');
            });

            // Handle color selection affecting thumbnails
            $('.focus-preview-image-by-color').on('click', function() {
                var colorKey = $(this).data('key');
                var colorId = $(this).data('colorid');

                // Find and trigger click on the appropriate thumbnail
                if ($('#preview-img' + colorKey).length) {
                    $('#preview-img' + colorKey).trigger('click');
                } else if ($('.color-variants-preview-box-' + colorKey).length) {
                    $('.color-variants-preview-box-' + colorKey).first().trigger('click');
                }
            });


        });
        $(document).ready(function() {
            // Initialize Owl Carousel first
            $('#sync1').owlCarousel({
                items: 1,
                slideSpeed: 2000,
                nav: true,
                autoplay: false,
                dots: false,
                loop: false, // Changed to false to prevent issues with cloned slides
                responsiveRefreshRate: 200,
                navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
            });

            // Common function to handle thumbnail clicks
            function handleThumbnailClick(elem) {
                var targetId = $(elem).attr('href');
                targetId = targetId.replace('#', ''); // Remove the # from the href

                // Remove active class from all thumbnails
                $('.product-preview-thumb').removeClass('active');

                // Add active class to clicked thumbnail
                $(elem).addClass('active');

                // Hide all preview images first
                $('.product-preview-item').removeClass('active').hide();

                // Show the target image
                $('#' + targetId).addClass('active').show();

                // Find the index of the image to display
                var items = $('.product-preview-item');
                var index = items.index($('#' + targetId));

                if (index >= 0) {
                    // Temporarily remove the event handler
                    $('#sync1').off('changed.owl.carousel');

                    // Move the carousel to the correct slide
                    $('#sync1').trigger('to.owl.carousel', [index, 300, true]);

                    // Re-attach the event handler after a short delay
                    setTimeout(function() {
                        // Handle owl carousel navigation
                        $('#sync1').on('changed.owl.carousel', carouselChangeHandler);
                    }, 400);
                }
            }

            // Handler for carousel changes
            function carouselChangeHandler(event) {
                var currentIndex = event.item.index;

                // Skip if index is invalid (happens during initialization)
                if (currentIndex === null) return;

                // Remove active class from all thumbnails
                $('.product-preview-thumb').removeClass('active');

                // Find the corresponding item
                var items = $('.product-preview-item');
                if (currentIndex >= 0 && currentIndex < items.length) {
                    // Get ID of the active item
                    var activeItemId = items.eq(currentIndex).attr('id');

                    // Add active class to corresponding thumbnail
                    $('a[href="#' + activeItemId + '"]').addClass('active');

                    // Update active state on main images
                    $('.product-preview-item').removeClass('active').hide();
                    $('#' + activeItemId).addClass('active').show();
                }
            }

            // Attach the carousel change handler
            $('#sync1').on('changed.owl.carousel', carouselChangeHandler);

            // Desktop thumbnails click handler
            $('.product-thumbs-wrapper .product-preview-thumb').on('click', function(e) {
                e.preventDefault();
                handleThumbnailClick(this);

                // Update mobile thumbnails to match
                var targetId = $(this).attr('href');
                $('.mobile-thumbs-row').find('a[href="' + targetId + '"]').addClass('active');
            });

            // Mobile/Tablet thumbnails click handler
            $('.mobile-thumbs-row .product-preview-thumb').on('click', function(e) {
                e.preventDefault();
                handleThumbnailClick(this);

                // Synchronize with desktop thumbnails
                var targetId = $(this).attr('href');
                $('.product-thumbs-wrapper').find('a[href="' + targetId + '"]').addClass('active');
            });

            // Handle color selection affecting thumbnails
            $('.focus-preview-image-by-color').on('click', function() {
                var colorKey = $(this).data('key');

                // Find and trigger click on the appropriate thumbnail
                if ($('#preview-img' + colorKey).length) {
                    $('#preview-img' + colorKey).trigger('click');
                } else if ($('.color-variants-preview-box-' + colorKey).length) {
                    $('.color-variants-preview-box-' + colorKey).first().trigger('click');
                }
            });

            // Show the first image initially
            var firstThumb = $('.product-thumbs-wrapper .product-preview-thumb').first();
            if (firstThumb.length) {
                setTimeout(function() {
                    firstThumb.trigger('click');
                }, 100);
            }
        });
    </script>
@endpush
