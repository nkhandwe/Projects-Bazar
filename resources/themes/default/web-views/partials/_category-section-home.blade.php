@if ($categories->count() > 0)
    <div class="__img mw-100 h-auto">
        <section class="pb-4 rtl">
            <div class="container">
                <div class="text-center mt-5 mb-5" style="margin-bottom: 100px!important;">
                    <h1><strong>SHOP BY <span class="text-primary">AGE</span></strong></h1>
                    <span class="mb-5">STEAM-filled boxes of joy for 3-14 years</span>
                </div>
                <div class="row justify-content-center mt-5">
                    @foreach ($categories as $key => $category)
                        @if ($key < 4)
                            <!-- Age Group Cards -->
                            <div class="col-md-3 col-6 mb-4">
                                <a href="{{ route('products', ['category_id' => $category['id'], 'data_from' => 'category', 'page' => 1]) }}"
                                    class="text-decoration-none">
                                    <div class="text-center __cate-item mx-auto"
                                        style="background: {{ $key == 0 ? '#00ABA4' : ($key == 1 ? '#FF9800' : ($key == 2 ? '#8E44AD' : '#002776')) }};
                                        border-top-left-radius: 50px;
                                        border-top-right-radius: 50px;">
                                        <div class="row">
                                            <div class="col-5 d-flex align-items-center justify-content-center">
                                                <h2 class="text-white font-bold mt-2 text-break">
                                                    {{ Str::limit($category->name, 15) }}
                                                </h2>
                                            </div>
                                            <div class="col-6">
                                                <!-- Category Image -->
                                                <img class="cate_image"
                                                    src="{{ getStorageImages(path: $category->icon_full_url, type: 'category') }}"
                                                    alt="{{ $category->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endif


<style>
    .__cate-item {
        padding: 10px;
        border-radius: 50px 50px 0 0;
        color: white;
        position: relative;
        height: 110px;

    }

    .__cate-item h2 {
        font-size: 28px;
        font-weight: bold;
        font-family: 'Baloo 2', sans-serif;
        margin: 0;

    }

    .cate_image {
        border-radius: 0 0 0px 0px;
        object-fit: cover;
        margin-top: -70px;

        bottom: 1px !important;
    }

    .text-break {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
</style>
