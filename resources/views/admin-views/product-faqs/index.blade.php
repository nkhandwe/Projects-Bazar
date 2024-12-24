@extends('layouts.back-end.app')

@section('title', 'Products Faq List')

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/attribute.png') }}" alt="">
                {{ 'Products Faqs' }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.product-faqs.store') }}" method="post" class="text-start">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ 'Question' }}</label>
                                <textarea type="text" class="form-control" id="question" name="question"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ 'Answer' }}</label>
                                <textarea type="text" class="form-control" id="answer" name="answer"></textarea>
                            </div>

                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <button type="reset" class="btn btn-secondary">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary">{{ translate('submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="mb-0 d-flex align-items-center gap-2">{{ 'Products Faq List' }}
                                    <span class="badge badge-soft-dark radius-50 fz-12">{{ $productFaq->count() }}</span>
                                </h5>
                            </div>

                        </div>
                    </div>
                    <div class="text-start">
                        <div class="table-responsive">
                            <table id="datatable"
                                class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                                <thead class="thead-light thead-50 text-capitalize">
                                    <tr>
                                        <th>{{ translate('SL') }}</th>
                                        <th class="text-center">{{ 'Question' }} </th>
                                        <th class="text-center">{{ 'Answer' }}</th>
                                        {{-- <th class="text-center">{{ 'Action' }}</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productFaq as $key => $faq)
                                        <tr>
                                            <td>{{ $productFaq->firstItem() + $key }}</td>
                                            <td>{{ $faq['question'] }}</td>
                                            <td>{{ $faq['answer'] }}</td>
                                            {{-- <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a class="btn btn-outline-info btn-sm square-btn"
                                                        title="{{ translate('edit') }}"
                                                        href="{{ route('admin.faq.update', [$faq['id']]) }}">
                                                        <i class="tio-edit"></i>
                                                    </a>
                                                    <a class="btn btn-outline-danger btn-sm product-faqs-delete-button square-btn"
                                                        title="{{ translate('delete') }}" id="{{ $faq['id'] }}">
                                                        <i class="tio-delete"></i>
                                                    </a>
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {!! $productFaq->links() !!}
                        </div>
                    </div>

                    @if (count($productFaq) == 0)
                        @include(
                            'layouts.back-end._empty-state',
                            ['text' => 'No Faqs Found'],
                            ['image' => 'default']
                        )
                    @endif
                </div>
            </div>
        </div>
    </div>

    <span id="route-admin-product-faqs-delete" data-url="{{ route('admin.product-faqs.delete') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
@endpush
