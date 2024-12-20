       <!-- Include Bootstrap and Owl Carousel CSS/JS -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
       <link rel="stylesheet"
           href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
       <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>



       <style>
           /* Custom styles for tabs */
           .nav-pills .nav-link {
               color: #000 !important;
               /* Default color for inactive tabs */
               background-color: white;
               /* Transparent background for tabs */
               border: none;
               /* Remove borders */
               border-radius: 50px;
               box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
               /* Optional shadow */
               transition: color 0.3s, background-color 0.3s;
               margin-left: 50px;
           }

           .nav-pills .nav-link.active {
               color: #fff !important;
               /* Active tab text color */
               background-color: #5f3dc4;
               /* Active tab background color */
           }

           .nav-pills .nav-link:hover {
               color: #5f3dc4;
               /* Hover text color */
               background-color: #5f3dc4;
               /* Hover background color */
           }
       </style>

       <section class="interest-section">
           <div class="text-center mt-5 mb-5" style="margin-bottom: 100px!important;">
               <h1><strong>SHOP BY <span style="color: #5f3dc4;">INTEREST</span></strong></h1>
               <span class="mb-5">A whole lotta fun & learning</span>
           </div>

           <div class="container rtl pb-4 px-max-sm-0">
               <ul class="nav nav-pills mb-3" id="categoryTabs" role="tablist">
                   @foreach ($categories as $key => $category)
                       <li class="nav-item" role="presentation">
                           <button class="nav-link {{ $key === 0 ? 'active' : '' }}"
                               id="category-tab-{{ $category->id }}" data-bs-toggle="tab"
                               data-bs-target="#category-{{ $category->id }}" type="button" role="tab"
                               aria-controls="category-{{ $category->id }}"
                               aria-selected="{{ $key === 0 ? 'true' : 'false' }}">
                               {{ $category->name }}
                           </button>
                       </li>
                   @endforeach
               </ul>

               <div class="tab-content" id="categoryTabsContent">
                   @foreach ($categories as $key => $category)
                       <div class="tab-pane fade {{ $key === 0 ? 'show active' : '' }}"
                           id="category-{{ $category->id }}" role="tabpanel"
                           aria-labelledby="category-tab-{{ $category->id }}">
                           @if (count($category->product) > 0)
                               <div class="__p-20px rounded overflow-hidden">
                                   <div class="mt-2">
                                       <div class="owl-carousel owl-theme new-arrivals-product">
                                           @foreach ($newArrivalProducts as $key => $product)
                                               @include('web-views.partials._product-card-2', [
                                                   'product' => $product,
                                                   'decimal_point_settings' => $decimalPointSettings,
                                               ])
                                           @endforeach
                                       </div>

                                       <div class="d-sm-none">
                                           <div class="row g-2">
                                               @foreach ($category->product as $key => $product)
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
                               <div class="text-center mt-5 mb-5" style="margin-bottom: 100px!important;">
                                   <h1><strong>No products found <span style="color: #5f3dc4;">in this
                                               category.</span></strong></h1>
                                   <span class="mb-5">Please Check with another category!</span>
                               </div>
                           @endif
                       </div>
                   @endforeach
               </div>
           </div>
       </section>
