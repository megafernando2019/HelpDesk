<?php $page = 'blank-page'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper pagehead d-flex flex-column justify-content-between">

        <!-- Start Content -->
		<div class="content flex-grow-1">
			<div class="page-header">
				<div class="page-title">
					<h4>Blank Page</h4>
					<h6>Sub Title</h6>
				</div>
				<ul class="table-top-head">
					<li>
						<a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
					</li>
					<li>
						<a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
					</li>
				</ul>
			</div>
		</div>
        <!-- End Content -->
    
        @include('layout.partials.footer')

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection      
