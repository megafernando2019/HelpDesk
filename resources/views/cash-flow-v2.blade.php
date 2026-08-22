<?php $page = 'cash-flow-v2'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content">
            <div class="page-header">
                <div class="add-item d-flex">
                    <div class="page-title">
                        <h4 class="fw-bold">Cash Flow</h4>
                        <h6>View Your Cashflows</h6>
                    </div>
                </div>
                <ul class="table-top-head">
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="{{URL::asset('build/img/icons/pdf.svg')}}" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="{{URL::asset('build/img/icons/excel.svg')}}" alt="img"></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
                    </li>
                    <li>
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
                    </li>
                </ul>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="row row-gap-2 align-items-end">
                            <div class="col-md-3">
                            <label class="form-label">Choose Your Date</label>				
                            <div class="input-groupicon calender-input balance-sheet-date">
                                <i data-feather="calendar" class="info-img"></i><input type="text" class="datetimepicker w-100" placeholder="01-Jan-2026 - 12-Dec-2026">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Store</label>
                            <div class="dropdown me-2">
                                <a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-flex align-items-center justify-content-between" data-bs-toggle="dropdown">
                                    All Stores
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end p-3">
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Store 1</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">Store 2</a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" class="dropdown-item rounded-1">All Stores</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive pb-0">
                        <table class="table border mb-2">
                            <thead class="thead-light">
                                <tr>						
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr>
                                    <td class="fw-bold text-gray-9 w-75">Cash Flow from Operating Activities</td>
                                    <td class="w-25"></td>
                                    </tr>  
                                    <tr>
                                    <td>Cash receipts from sales</td>
                                    <td>$50,000</td>
                                    </tr>  
                                    <tr>
                                    <td>Cash payments to suppliers</td>
                                    <td>$30,000</td>
                                    </tr>  
                                    <tr>
                                    <td>Cash payments to employees</td>
                                    <td>$7,000</td>
                                    </tr>
                                    <tr>
                                    <td>Cash payments for operating expenses (e.g., rent, utilities)</td>
                                    <td>($5,00)</td>
                                    </tr>  
                                    <tr>
                                    <td class="fw-bold text-gray-9">Net Cash from Operating Activities</td>
                                    <td class="fw-bold text-gray-9">$8,000</td>
                                    </tr>                              
                    
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive pb-0">
                        <table class="table border mb-2">
                            <tbody>
                                
                                <tr>
                                    <td class="fw-bold text-gray-9 w-75">Cash Flow from Investing Activities</td>
                                    <td class="w-25"></td>
                                    </tr>  
                                    <tr>
                                    <td>Purchase of POS equipment</td>
                                    <td>$6,000</td>
                                    </tr>  
                                    <tr>
                                    <td>Sale of old equipment</td>
                                    <td>$1,500</td>
                                    </tr>  
                                    <tr>
                                    <td class="fw-bold text-gray-9">Net Cash from Investing Activities</td>
                                    <td class="fw-bold text-gray-9">$4,500</td>
                                    </tr>                          
                    
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive pb-0">
                        <table class="table border mb-2">
                            <tbody>
                                
                                <tr>
                                    <td class="fw-bold text-gray-9 w-75">Cash Flow from Financing Activities</td>
                                    <td class="w-25"></td>
                                    </tr>  
                                    <tr>
                                    <td>Loan received (short-term)</td>
                                    <td>$4,000</td>
                                    </tr>  
                                    <tr>
                                    <td>Repayment of long-term loan</td>
                                    <td>$$3,000</td>
                                    </tr>  
                                    <tr>
                                    <td class="fw-bold text-gray-9">Net Cash from Financing Activities</td>
                                    <td class="fw-bold text-gray-9">$3,000</td>
                                    </tr>                          
                    
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive pb-0">
                        <table class="table border mb-2">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-gray-9 w-75">Net Increase in Cash</td>
                                    <td class="w-25"></td>
                                    </tr>  
                                    <tr>
                                    <td>Cash at beginning of the period</td>
                                    <td>$5,000</td>
                                    </tr>								 
                                    <tr>
                                    <td class="fw-bold text-gray-9">Net Cash from Financing Activities</td>
                                    <td class="fw-bold text-gray-9">$8,000</td>
                                    </tr>                          
                    
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table border">
                            <tbody>
                                <tr>
                                    <td class="bg-light text-dark fw-bold text-gray-9 p-3 w-75 fs-16">Cash at End of the Period</td>
                                    <td class="bg-light text-dark fw-bold text-gray-9 p-3 w-25 fs-16">$332642.53</td>
                                    </tr> 
                            </tbody>
                        </table>
                    </div>
                
                </div>
            </div>
        </div>
        <!-- End Content -->
    
        @include('layout.partials.footer')

    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection      
