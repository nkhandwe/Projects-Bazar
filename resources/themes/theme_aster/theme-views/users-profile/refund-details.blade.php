@php use App\Utils\Helpers;use App\Utils\ProductManager; @endphp
@extends('theme-views.layouts.app')

@section('title', translate('refund_Details').' | '.$web_config['name']->value.' '.translate('ecommerce'))

@section('content')
    <main class="main-content d-flex flex-column gap-3 py-3 mb-5">
        <div class="container">
            <div class="row g-3">
                @include('theme-views.partials._profile-aside')
                <div class="col-lg-9">
                    <div class="card h-100">
                        <div class="card-body p-lg-5">
                            <div class="mb-4">
                                <h1 class="modal-title fs-5 text-capitalize"
                                    id="refundModalLabel">{{translate('refund_details')}}</h1>
                            </div>
                            <div class="modal-body">
                                <form action="#">
                                    <div
                                        class="d-flex flex-column flex-sm-row flex-wrap gap-4 justify-content-between mb-4">
                                        <div class="media align-items-center gap-3">
                                            <div class="avatar avatar-xxl rounded border overflow-hidden">
                                                <img class="dark-support img-fit rounded" alt=""
                                                    src="{{ getStorageImages(path:$product->thumbnail_full_url, type: 'product') }}">
                                            </div>
                                            <div class="media-body d-flex gap-1 flex-column">
                                                <h6 class="text-truncate width--20ch">
                                                    <h6>
                                                        <a href="{{route('product',[$product['slug']])}}">
                                                            {{isset($product['name']) ? Str::limit($product['name'],40) : ''}}
                                                        </a>
                                                        @if($order_details->refund_request == 1)
                                                            <small class="text-warning">
                                                                ({{translate('refund_pending')}}) </small> <br>
                                                        @elseif($order_details->refund_request == 2)
                                                            <small class="text-primary">
                                                                ({{translate('refund_approved')}}) </small> <br>
                                                        @elseif($order_details->refund_request == 3)
                                                            <small class="text-danger">
                                                                ({{translate('refund_rejected')}}) </small> <br>
                                                        @elseif($order_details->refund_request == 4)
                                                            <small class="text-success">
                                                                ({{translate('refund_refunded')}}) </small> <br>
                                                        @endif<br>
                                                    </h6>
                                                    @if($order_details->variant)
                                                        <small>{{translate('variant').':'}}
                                                            {{$order_details->variant}} </small>
                                                    @endif</h6>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-1 fs-12">
                                            <span>{{ translate('QTY') }} : {{webCurrencyConverter($order_details->qty)}}</span>
                                            <span>{{ translate('price') }} : {{webCurrencyConverter($order_details->price)}}</span>
                                            <span>{{ translate('discount') }} : {{webCurrencyConverter($order_details->discount)}}</span>
                                            <span>{{ translate('tax') }} : {{webCurrencyConverter($order_details->tax)}}</span>
                                        </div>

                                        <?php
                                        $total_product_price = 0;
                                        foreach ($order->details as $key => $orderDetail) {
                                            $total_product_price += ($orderDetail->qty * $orderDetail->price) + $orderDetail->tax - $orderDetail->discount;
                                        }
                                        $refund_amount = 0;
                                        $subtotal = ($order_details->price * $order_details->qty) - $order_details->discount + $order_details->tax;
                                        $coupon_discount = ($order->discount_amount * $subtotal) / $total_product_price;
                                        $refund_amount = $subtotal - $coupon_discount;
                                        ?>
                                        <div class="d-flex flex-column gap-1 fs-12">
                                            <span>{{translate('subtotal')}}: {{webCurrencyConverter($subtotal)}}</span>
                                            <span>{{translate('coupon_discount')}}: {{webCurrencyConverter($coupon_discount)}}</span>
                                            <span>{{translate('total_refundable_amount')}}:{{webCurrencyConverter($refund_amount)}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4">
                                        <h6 class="mb-2">{{translate('refund_reason')}}</h6>
                                        <p>{{$refund['refund_reason']}}</p>
                                    </div>
                                    <div class="form-group">
                                        <h6 class="mb-2">{{translate('attachment')}}</h6>
                                        <div class="d-flex flex-column gap-3">
                                            @if (count($refund->images_full_url)>0)
                                                <div class="gallery custom-image-popup-init">
                                                    @foreach ($refund->images_full_url as $key => $photo)
                                                        <a href="{{ getStorageImages(path: $photo, type:'product') }}"
                                                           class="custom-image-popup">
                                                            <img alt="" class="img-w-h-100"
                                                                src="{{ getStorageImages(path: $photo, type:'product') }}">
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p>{{ translate('no_attachment_found')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('script')
    <script>
        'use strict';
        getVariantPrice();
    </script>
@endpush
