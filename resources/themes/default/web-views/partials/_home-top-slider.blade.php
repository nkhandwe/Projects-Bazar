@if (count($main_banner) > 0)
    <section class="bg-transparent">
        <div class="col-12">
            <div class="owl-theme owl-carousel hero-slider">
                @foreach ($main_banner as $key => $banner)
                    <a href="{{ $banner['url'] }}" class="d-block" target="_blank">
                        <img class="w-100 __slide-img" alt=""
                            src="{{ getStorageImages(path: $banner->photo_full_url, type: 'banner') }}">
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif
