<?php $page = 'product-details'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
		<div class="content">
			<div class="page-header">
				<div class="page-title">
					<h4>Product Details</h4>
					<h6>Full details of a product</h6>
				</div>
			</div>
			<!-- /add -->
			<div class="row">
				<div class="col-lg-8 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="bar-code-view">
								<div class="product-details-barcode">
									<img src="{{URL::asset('build/img/barcode/barcode1.png')}}" class="barcode" alt="barcode">
									<img src="{{URL::asset('build/img/barcode/barcode1-white.png')}}" class="barcode-white" alt="barcode">
								</div>
								<a class="printimg">
									<i class="ti ti-printer fs-24 text-dark"></i>
								</a>
							</div>
							<div class="productdetails">
								<ul class="product-bar">
									<li>
										<h4>Product</h4>
										<h6>Macbook pro	</h6>
									</li>
									<li>
										<h4>Category</h4>
										<h6>Computers</h6>
									</li>
									<li>
										<h4>Sub Category</h4>
										<h6>None</h6>
									</li>
									<li>
										<h4>Brand</h4>
										<h6>None</h6>
									</li>
									<li>
										<h4>Unit</h4>
										<h6>Piece</h6>
									</li>
									<li>
										<h4>SKU</h4>
										<h6>PT0001</h6>
									</li>
									<li>
										<h4>Minimum Qty</h4>
										<h6>5</h6>
									</li>
									<li>
										<h4>Quantity</h4>
										<h6>50</h6>
									</li>
									<li>
										<h4>Tax</h4>
										<h6>0.00 %</h6>
									</li>
									<li>
										<h4>Discount Type</h4>
										<h6>Percentage</h6>
									</li>
									<li>
										<h4>Price</h4>
										<h6>1500.00</h6>
									</li>
									<li>
										<h4>Status</h4>
										<h6>Active</h6>
									</li>
									<li>
										<h4>Description</h4>
										<h6>Designed for professionals, it offers smooth multitasking and high-end graphics capability.</h6>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="slider-product-details">

								<div class="owl-carousel owl-theme product-slide">
									<div class="slider-product">
										<img src="{{URL::asset('build/img/products/product69.jpg')}}" alt="img">
										<h4 class="text-dark">macbookpro.jpg</h4>
										<h6 class="text-dark">581kb</h6>
									</div>

									<div class="slider-product">
										<img src="{{URL::asset('build/img/products/product69.jpg')}}" alt="img">
										<h4 class="text-dark">macbookpro.jpg</h4>
										<h6 class="text-dark">581kb</h6>
									</div>
								</div>

								<div class="product-nav-controls d-flex align-items-center justify-content-between">
									<button class="product-prev"><i class="fa fa-chevron-left"></i></button>
									<button class="product-next"><i class="fa fa-chevron-right"></i></button>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
				
			<!-- /add -->
		</div>
        <!-- End Content -->
    
        @include('layout.partials.footer')

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection      
