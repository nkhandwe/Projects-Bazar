@extends('layouts.front-end.app')

@section('title', 'Tutorial Videos')

@section('content')
    <div class="container py-2 py-md-4 p-0 p-md-2 user-profile-container px-5px">
        <div class="row">
            <section class="col-lg-12 col-md-12 __customer-profile customer-profile-wishlist px-0">
                <div class="card __card d-none d-lg-flex web-direction customer-profile-orders h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between gap-2 mb-0 mb-md-3">
                            <h5 class="font-bold mb-0 fs-16">{{ 'Tutorial Videos' }}</h5>
                        </div>
                        @if (!empty($order->details))
                            <div class="col-md-12">
                                @php
                                    $productNames = [];
                                    $videos = [];
                                @endphp

                                @foreach ($order->details as $detailKey => $detail)
                                    @php
                                        $productDetails = isset($detail['product_details'])
                                            ? json_decode($detail['product_details'], true)
                                            : [];
                                    @endphp

                                    @if (is_array($productDetails) && isset($productDetails['name']))
                                        @php
                                            $productNames[] = $productDetails['name'];
                                        @endphp
                                    @endif
                                @endforeach

                                @if (!empty($productNames))
                                    <div class="card-body">
                                        <h5 class="card-title">Select Product</h5>
                                        <select class="form-control" aria-label="Product Names" id="productSelect">
                                            <option value="">Select a product</option>
                                            @foreach ($productNames as $productName)
                                                <option value="{{ $productName }}">{{ $productName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <p class="text-muted">No product names available.</p>
                                @endif

                                @foreach ($order->details as $detailKey => $detail)
                                    @php
                                        $productDetails = isset($detail['product_details'])
                                            ? json_decode($detail['product_details'], true)
                                            : [];
                                    @endphp

                                    @if (is_array($productDetails) && isset($productDetails['name']))
                                        @php
                                            $productNames[] = $productDetails['name'];
                                            $videos = \App\Models\ProductVideos::where(
                                                'product_id',
                                                $productDetails['id'] ?? null,
                                            )->get();
                                        @endphp
                                    @endif

                                    @if ($videos->isNotEmpty())
                                        <section class="video-block" id="videoSection" style="display: none;">
                                            <div class="container">
                                                <div class="video-tab clearfix">
                                                    <div class="row">
                                                        <div class="col-md-7 pr-0">
                                                            <div class="tab-content">
                                                                @php
                                                                    $videos = $videos->sortBy('position'); // Ensure videos are sorted by position
                                                                    $firstVideo = $videos->first(); // Get the first video for the active tab
                                                                @endphp

                                                                @if ($firstVideo)
                                                                    <div class="tab-pane fade show active"
                                                                        id="videoTab{{ $firstVideo->id }}">
                                                                        <a class="play-icon" href="javascript:void(0)"
                                                                            data-video="https://player.vimeo.com/video/{{ $firstVideo->video_url }}?autoplay=1">
                                                                            <img class="play-button"
                                                                                src="https://user-images.githubusercontent.com/16266381/60864229-d403b780-a244-11e9-909a-a8a01b6e1d50.png"
                                                                                alt="play-button">
                                                                            <div class="post-thumbnail">
                                                                                <img class="img-responsive"
                                                                                    src="{{ URL::to('storage/app/public/' . urldecode($firstVideo->thumbnail)) }}"
                                                                                    alt="post-thumbnail" />
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                @endif

                                                                @foreach ($videos as $index => $video)
                                                                    @if ($index > 0)
                                                                        <div class="tab-pane fade"
                                                                            id="videoTab{{ $video->id }}">
                                                                            <a class="play-icon" href="javascript:void(0)"
                                                                                data-video="https://player.vimeo.com/video/{{ $video->video_url }}?autoplay=1">
                                                                                <img class="play-button"
                                                                                    src="https://user-images.githubusercontent.com/16266381/60864229-d403b780-a244-11e9-909a-a8a01b6e1d50.png"
                                                                                    alt="play-button">
                                                                                <div class="post-thumbnail">
                                                                                    <img class="img-responsive"
                                                                                        src="{{ URL::to('storage/app/public/' . urldecode($video->thumbnail)) }}"
                                                                                        alt="post-thumbnail" />
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5 pl-0">
                                                            <ul class="nav nav-tabs"
                                                                style="max-height: 400px; overflow-y: auto!important;">
                                                                @foreach ($videos as $index => $video)
                                                                    <li class="nav-item">
                                                                        <a href="#videoTab{{ $video->id }}"
                                                                            class="nav-link {{ $index === 0 ? 'active' : '' }}"
                                                                            data-toggle="tab">
                                                                            <div class="post-thumbnail">
                                                                                <img class="img-responsive"
                                                                                    src="{{ URL::to('storage/app/public/' . urldecode($video->thumbnail)) }}"
                                                                                    alt="{{ $video->title }}" />
                                                                            </div>
                                                                            <div class="video-details">
                                                                                <span
                                                                                    class="video-title text-dark">{{ $video->title }}</span>
                                                                                <span
                                                                                    class="video-duration text-dark">Duration:
                                                                                    {{ $video->duration }}</span>
                                                                            </div>
                                                                        </a>
                                                                    </li>
                                                                    <hr />
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No order details available.</p>
                        @endif

                    </div>
                </div>
            </section>
        </div>
    </div>
    <style>
        .video-details {
            display: flex;
            flex-direction: column;
            /* Arrange children vertically */
            gap: 5px;
            /* Optional: Adds space between the elements */
        }

        .video-title,
        .video-duration {
            width: 100%;
            /* Ensure the elements take up the full width */
        }

        .video-block {
            color: #000;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .video-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 180px;
        }

        /* Add more styles for hiding video until product selection */
        #videoSection {
            display: none;
        }

        .video-tab .post-overlay-wrapper {
            min-height: 430px;
        }

        .video-tab .post-overlay-wrapper .post-content {
            padding: 35px;
        }

        .video-tab .post-title {
            font-size: 24px;
            line-height: 30px;
            font-weight: normal;
            color: #000;
        }

        .video-tab .nav-tabs {
            border-bottom: none;
            margin-left: 30px;
            height: 376px;
            overflow-y: auto;
        }

        .video-tab .nav-tabs::-webkit-scrollbar {
            width: 8px;
            background-color: #fff;
            border-radius: 10px;
        }

        .video-tab .nav-tabs::-webkit-scrollbar-thumb {
            border-radius: 10px;
            background-color: #479DC8;
        }

        .video-tab .nav-tabs li {
            width: 100%;
            display: block;
            min-height: 100px;
        }

        .video-tab .nav-tabs li a {
            background: none;
            border: 0;
            padding: 0;
            border: 0;
        }

        .video-tab .nav-tabs li a .post-thumbnail {
            float: left;
            margin-right: 20px;
            position: relative;
            /* overflow: hidden; */
        }

        .video-tab .nav-tabs li a .post-thumbnail img {
            max-width: 100px;
        }

        .play-icon {
            position: relative;
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 6px;
        }

        .play-icon:hover {
            cursor: none;
        }

        .play-icon .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 3;
            transition: all 0.1s ease;
        }

        .play-icon:before {
            position: absolute;
            content: "";
            width: 100%;
            height: 100%;
            transition: all 0.3s ease;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2;
        }

        .video-tab iframe {
            width: 100%;
            min-height: 369px;
            border: none;
            background: #000;
            padding: 10px;
            border-radius: 6px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Hide video section until a product is selected
            $('#productSelect').change(function() {
                if ($(this).val() != "") {
                    $('#videoSection').show();
                } else {
                    $('#videoSection').hide();
                }
            });

            // Handle video tab switching
            $('.nav-tabs .nav-link').on('click', function(e) {
                e.preventDefault();
                var targetTab = $(this).attr('href');

                // Remove active class from all tabs and add to clicked tab
                $('.nav-tabs .nav-link').removeClass('active');
                $(this).addClass('active');

                // Hide all tab panes and show the targeted one
                $('.tab-pane').removeClass('show active');
                $(targetTab).addClass('show active');
            });

            // Handle video play
            $('.play-icon').click(function() {
                var video = '<iframe allowfullscreen src="' + $(this).attr('data-video') + '"></iframe>';
                $(this).replaceWith(video);
            });

            // Handle play button hover effect
            $('.play-icon').mousemove(function(e) {
                var parentOffset = $(this).offset();
                var relX = e.pageX - parentOffset.left;
                var relY = e.pageY - parentOffset.top;
                $(this).find(".play-button").css({
                    left: relX,
                    top: relY
                });
            });

            $('.play-icon').mouseout(function() {
                $(this).find(".play-button").css({
                    left: '50%',
                    top: '50%'
                });
            });
        });
    </script>
@endsection
