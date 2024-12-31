@extends('layouts.back-end.app')

@section('title', 'Products Videos')

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-2">
                <img src="{{ dynamicAsset(path: 'public/assets/back-end/img/attribute.png') }}" alt="">
                {{ 'Products Videos' }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.product-videos.store') }}" method="post" enctype="multipart/form-data"
                            class="text-start">
                            @csrf
                            <div class="row">
                                @php
                                    $products = \App\Models\Product::all();
                                @endphp
                                <!-- Product Selection -->
                                <div class="mb-3 col-md-6">
                                    <label for="product_id" class="form-label">Product</label>
                                    <select name="product_id" id="product_id" class="form-control" required>
                                        <option value="" disabled selected>Select a product</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Video URL -->
                                <div class="mb-3 col-md-6">
                                    <label for="video_url" class="form-label">Vimeo Video Id</label>
                                    <input type="text" name="video_url" id="video_url" class="form-control" required>
                                </div>

                                <!-- Title -->
                                <div class="mb-3 col-md-6">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div>

                                <!-- Description -->
                                <div class="mb-3 col-md-6">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                                </div>



                                <!-- Position -->
                                <div class="mb-3 col-md-6">
                                    <label for="position" class="form-label">Position</label>
                                    <select name="position" id="position" class="form-control">
                                        @for ($i = 1; $i <= 30; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Publish Checkbox -->
                                <div class="mb-3 col-md-2 d-flex align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_published" id="is_published"
                                            class="form-check-input" checked>
                                        <label for="is_published" class="form-check-label">Publish</label>
                                    </div>
                                </div>

                                <!-- Thumbnail Upload -->
                                <div class="mb-3 col-md-3">
                                    <div class="custom_upload_input position-relative">
                                        <input type="file" name="thumbnail"
                                            class="custom-upload-input-file action-upload-color-image" id="uploadThumbnail"
                                            data-imgpreview="pre_img_viewer"
                                            accept=".jpg, .webp, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">

                                        <!-- Delete Button -->
                                        <span class="delete_file_input btn btn-outline-danger btn-sm square-btn d-none"
                                            id="deletePreview">
                                            <i class="tio-delete"></i>
                                        </span>

                                        <!-- Image Preview -->
                                        <div class="img_area_with_preview position-absolute z-index-2">
                                            <img id="pre_img_viewer" class="h-auto aspect-1 bg-white d-none" src="#"
                                                alt="">
                                        </div>

                                        <!-- Placeholder -->
                                        <div
                                            class="position-absolute h-100 top-0 w-100 d-flex align-content-center justify-content-center">
                                            <div class="d-flex flex-column justify-content-center align-items-center"
                                                id="placeholderContainer">
                                                <img alt="" class="w-75"
                                                    src="{{ dynamicAsset(path: 'public/assets/back-end/img/icons/product-upload-icon.svg') }}">
                                                <h3 class="text-muted">{{ translate('Upload_Image') }}</h3>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted mt-2 fz-12">
                                        {{ translate('image_format') }} : {{ 'Jpg, png, jpeg, webp,' }}
                                        <br>
                                        {{ translate('image_size') }} : {{ translate('max') }} {{ '2 MB' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Form Buttons -->
                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <button type="reset" class="btn btn-secondary">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary">{{ translate('submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="card">
                <div class="px-3 py-4">
                    <div class="row align-items-center">
                        <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                            <h5 class="mb-0 d-flex align-items-center gap-2">{{ 'Products Faq List' }}
                                {{-- <span class="badge badge-soft-dark radius-50 fz-12">{{ $productFaq->count() }}</span> --}}
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
                                {{-- @foreach ($productFaq as $key => $faq)
                                        <tr>
                                            <td>{{ $productFaq->firstItem() + $key }}</td>
                                            <td>{{ $faq['question'] }}</td>
                                            <td>{{ $faq['answer'] }}</td> --}}
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
                                {{-- </tr>
                                    @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {!! $productFaq->links() !!}
                        </div>
                    </div> --}}

                {{-- @if (count($productFaq) == 0)
                        @include(
                            'layouts.back-end._empty-state',
                            ['text' => 'No Faqs Found'],
                            ['image' => 'default']
                        )
                    @endif --}}
            </div>
        </div>
    </div>
    </div>

    <span id="route-admin-product-faqs-delete" data-url="{{ route('admin.product-faqs.delete') }}"></span>
@endsection

@push('script')
    <script src="{{ dynamicAsset(path: 'public/assets/back-end/js/products-management.js') }}"></script>
    <script>
        document.getElementById('uploadThumbnail').addEventListener('change', function(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const previewImage = document.getElementById('pre_img_viewer');
            const placeholderContainer = document.getElementById('placeholderContainer');
            const deleteButton = document.getElementById('deletePreview');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result; // Set the preview image source
                    previewImage.classList.remove('d-none'); // Show the preview image
                    placeholderContainer.classList.add('d-none'); // Hide the placeholder
                    deleteButton.classList.remove('d-none'); // Show the delete button
                };

                reader.readAsDataURL(file); // Read the file
            }
        });

        document.getElementById('deletePreview').addEventListener('click', function() {
            const fileInput = document.getElementById('uploadThumbnail');
            const previewImage = document.getElementById('pre_img_viewer');
            const placeholderContainer = document.getElementById('placeholderContainer');
            const deleteButton = document.getElementById('deletePreview');

            // Reset the file input and preview
            fileInput.value = '';
            previewImage.src = '#';
            previewImage.classList.add('d-none'); // Hide the preview image
            placeholderContainer.classList.remove('d-none'); // Show the placeholder
            deleteButton.classList.add('d-none'); // Hide the delete button
        });
    </script>
@endpush
