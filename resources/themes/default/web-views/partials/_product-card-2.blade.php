@if (isset($product))
    @php($overallRating = getOverallRating($product->reviews))
    <div class="flash_deal_product get-view-by-onclick card p-1 mb-3 me-2"
        style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border-radius: 8px; background:#f5f7f8;"
        data-link="{{ route('product', $product->slug) }}">

        <!-- Image Section -->
        <div>
            <div class="mb-3 position-relative">
                <img class="img-fluid w-100" style="max-height: 300px; object-fit: cover; border-radius: 8px;"
                    alt="{{ $product->name }}"
                    src="{{ getStorageImages(path: $product->thumbnail_full_url, type: 'product') }}">
            </div>
        </div>

        <!-- Content Section -->
        <div class="p-3">
            <!-- Product Name -->
            <a href="{{ route('product', $product->slug) }}"
                class="d-block text-capitalize fw-semibold mb-2 text-truncate"
                style="font-size: 1rem; text-decoration: none; color: #333;">
                {{ Str::limit($product['name'], 80) }}
            </a>

            <!-- Product Rating -->
            @if ($overallRating[0] != 0)
                <div class="mb-2">
                    @for ($inc = 1; $inc <= 5; $inc++)
                        @if ($inc <= (int) $overallRating[0])
                            <i class="tio-star text-warning"></i>
                        @elseif ($overallRating[0] != 0 && $inc <= (int) $overallRating[0] + 1.1 && $overallRating[0] > ((int) $overallRating[0]))
                            <i class="tio-star-half text-warning"></i>
                        @else
                            <i class="tio-star-outlined text-warning"></i>
                        @endif
                    @endfor
                    <label class="badge badge-light">
                        ( {{ count($product->reviews) }} )
                    </label>
                </div>
            @endif

            <!-- Product Price -->
            <div class="mb-3 p-1">
                @if ($product->discount > 0)
                    <span class="badge badge-danger shadow" style="font-size: 0.875rem; border-radius:50px;">
                        @if ($product->discount_type == 'percent')
                            -{{ round($product->discount, !empty($decimal_point_settings) ? $decimal_point_settings : 0) }}%
                        @elseif($product->discount_type == 'flat')
                            -{{ webCurrencyConverter(amount: $product->discount) }}
                        @endif
                    </span>
                @endif
                <span class="text-dark fw-bold" style="font-size: 1.25rem;">
                    {{ webCurrencyConverter(amount: $product->unit_price - getProductDiscount(product: $product, price: $product->unit_price)) }}
                </span>
                @if ($product->discount > 0)
                    <del class="text-muted me-2" style="font-size: 0.875rem;">
                        {{ webCurrencyConverter(amount: $product->unit_price) }}
                    </del>
                @endif
            </div>

            <!-- Add to Cart Button -->
            <button
                class="btn btn-primary w-100 element-center btn-gap-{{ Session::get('direction') === 'rtl' ? 'left' : 'right' }} btn-add-to-cart"
                type="button" data-update-text="{{ translate('update_cart') }}"
                data-add-text="{{ translate('add_to_cart') }}" style="border-radius: 25px;">
                <span class="string-limit">{{ 'View Details' }}</span>
            </button>
        </div>
    </div>
@endif
