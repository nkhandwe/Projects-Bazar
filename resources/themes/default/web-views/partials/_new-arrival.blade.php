<!-- Include Bootstrap and Owl Carousel CSS/JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<style>
    /* Custom styles for tabs */
    .nav-pills .nav-link {
        color: #555454 !important;
        background-color: white;
        border: 1px solid #e7e7e7;
        border-radius: 50px;
        font-family: 'Baloo 2', sans-serif;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: color 0.3s, background-color 0.3s;
        margin: 0 10px;
        white-space: nowrap;
    }

    .nav-pills .nav-link.active {
        color: #fff !important;
        background-color: var(--web-primary);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .nav-pills .nav-link:hover {
        color: var(--web-primary);
        background-color: var(--web-primary);
    }

    /* Add horizontal scrolling for tabs on smaller devices */
    @media (max-width: 576px) {
        .nav-pills {
            overflow-x: auto;
            display: flex;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .nav-pills .nav-item {
            flex: 0 0 auto;
        }
    }

    /* Adjust spacing for smaller devices */
    @media (max-width: 768px) {
        .interest-section h1 {
            font-size: 24px;
        }

        .owl-carousel .item {
            margin: 0 5px;
        }
    }

    /* Adjust card grid for very small devices */
    @media (max-width: 576px) {
        .owl-carousel {
            display: none;
        }

        .d-sm-none .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }
</style>

<section class="interest-section">
    <div class="text-center mt-5 mb-5">
        <h1><strong>SHOP BY <span class="text-primary">INTEREST</span></strong></h1>
        <h3>A whole lotta fun & learning</h3>
    </div>

    @php($subcategories = \App\Models\Category::where('parent_id', '!=', 0)->get())
    @php($groupedSubcategories = $subcategories->groupBy('name'))

    <div class="container rtl pb-4 px-3">
        <ul class="nav nav-pills mb-3" id="subcategoryTabs" role="tablist">
            @foreach ($groupedSubcategories as $name => $subcategoryGroup)
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                    id="subcategory-tab-{{ $loop->iteration }}" data-bs-toggle="tab"
                    data-bs-target="#subcategory-{{ $loop->iteration }}" type="button" role="tab"
                    aria-controls="subcategory-{{ $loop->iteration }}"
                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                    {{ $name }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="subcategoryTabsContent">
            @foreach ($groupedSubcategories as $name => $subcategoryGroup)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="subcategory-{{ $loop->iteration }}"
                role="tabpanel" aria-labelledby="subcategory-tab-{{ $loop->iteration }}">
                @php($allProducts = collect())
                @foreach($subcategoryGroup as $subcategory)
                @php($allProducts = $allProducts->merge($subcategory->subCategoryProduct))
                @endforeach

                @if ($allProducts->count() > 0)
                <div class="__p-20px rounded overflow-hidden">
                    <div class="mt-2">
                        <div class="owl-carousel owl-theme new-arrivals-product">
                            @foreach ($allProducts as $product)
                            @include('web-views.partials._product-card-2', [
                            'product' => $product,
                            'decimal_point_settings' => $decimalPointSettings,
                            ])
                            @endforeach
                        </div>

                        <!-- Grid View for Small Screens -->
                        <div class="d-sm-none">
                            <div class="row g-2">
                                @foreach ($allProducts as $key => $product)
                                @if ($key < 4)
                                    <div class="col-6">
                                    @include('web-views.partials._product-card-2', [
                                    'product' => $product,
                                    'decimal_point_settings' => $decimalPointSettings,
                                    ])
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center mt-5 mb-5">
                <h1><strong>No products found <span class="text-primary">in this Category.</span></strong>
                </h1>
                <span>Please Check with another Category!</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    </div>
</section>

<script>
    // Owl Carousel Initialization
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 4
                }
            }
        });
    });
</script>