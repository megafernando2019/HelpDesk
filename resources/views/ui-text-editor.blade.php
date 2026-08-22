<?php $page = 'ui-text-editor'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
		<div class="content ">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">Text Editor</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{url('index')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">Text Editor</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
			
			<div class="row">
			
				<!-- Editor -->
				<div class="col-md-12">	
					<div class="card">
						<div class="card-header">
							<h5 class="card-title">Editor</h5>
						</div>
						<div class="card-body">
							<div class="editor pages-editor"></div>
						</div>
					</div>
				</div>
				<!-- /Editor -->
					
			</div>				
		</div>	
        <!-- End Content -->
    
        @include('layout.partials.footer')

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection      
