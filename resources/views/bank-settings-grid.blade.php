<?php $page = 'bank-settings-grid'; ?>
@extends('layout.mainlayout')
@section('content')

<!-- ========================
        Start Page Content
    ========================= -->

<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content settings-content">
        <div class="page-header settings-pg-header">
            <div class="add-item d-flex">
                <div class="page-title">
                    <h4>Settings</h4>
                    <h6>Manage your settings on portal</h6>
                </div>
            </div>
            <ul class="table-top-head">
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i
                            class="ti ti-refresh"></i></a>
                </li>
                <li>
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i
                            class="ti ti-chevron-up"></i></a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="settings-wrapper d-flex">
                    <div class="settings-sidebar" id="sidebar2">
                        <div class="sidebar-inner slimscroll">
                            <div id="sidebar-menu5" class="sidebar-menu">
                                <h4 class="fw-bold fs-18 mb-2 pb-2">Settings</h4>
                                <ul>
                                    <li class="submenu-open">
                                        <ul>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-settings fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('general-settings')}}">Profile</a></li>
                                                    <li><a href="{{route('security-settings')}}">Security</a></li>
                                                    <li><a href="{{route('notification')}}">Notifications</a></li>
                                                    <li><a href="{{route('connected-apps')}}">Connected Apps</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-world fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('system-settings')}}">System Settings</a></li>
                                                    <li><a href="{{route('company-settings')}}">Company Settings </a>
                                                    </li>
                                                    <li><a href="{{route('localization-settings')}}">Localization</a>
                                                    </li>
                                                    <li><a href="{{route('prefixes')}}">Prefixes</a></li>
                                                    <li><a href="{{route('preference')}}">Preference</a></li>
                                                    <li><a href="{{route('appearance')}}">Appearance</a></li>
                                                    <li><a href="{{route('social-authentication')}}">Social
                                                            Authentication</a></li>
                                                    <li><a href="{{route('language-settings')}}">Language</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-device-mobile fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">App Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('invoice-settings')}}">Invoice Settings</a>
                                                    </li>
                                                    <li><a href="{{route('invoice-templates')}}">Invoice Templates</a>
                                                    </li>
                                                    <li><a href="{{route('printer-settings')}}">Printer </a></li>
                                                    <li><a href="{{route('pos-settings')}}">POS</a></li>
                                                    <li><a href="{{route('signatures')}}">Signatures</a></li>
                                                    <li><a href="{{route('custom-fields')}}">Custom Fields</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-device-desktop fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">System Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li class="submenu submenu-two"><a
                                                            href="javascript:void(0);">Email<span
                                                                class="menu-arrow inside-submenu"></span></a>
                                                        <ul>
                                                            <li><a href="{{route('email-settings')}}">Email Settings</a>
                                                            </li>
                                                            <li><a href="{{route('email-templates')}}">Email
                                                                    Templates</a></li>
                                                        </ul>
                                                    </li>
                                                    <li class="submenu submenu-two"><a
                                                            href="javascript:void(0);">SMS<span
                                                                class="menu-arrow inside-submenu"></span></a>
                                                        <ul>
                                                            <li><a href="{{route('sms-settings')}}">SMS Settings</a>
                                                            </li>
                                                            <li><a href="{{route('sms-templates')}}">SMS Templates</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li><a href="{{route('otp-settings')}}">OTP</a></li>
                                                    <li><a href="{{route('gdpr-settings')}}">GDPR Cookies</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);" class="active subdrop">
                                                    <i class="ti ti-settings-dollar fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">Financial Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('payment-gateway-settings')}}">Payment
                                                            Gateway</a></li>
                                                    <li><a href="{{route('bank-settings-grid')}}" class="active">Bank
                                                            Accounts </a></li>
                                                    <li><a href="{{route('tax-rates')}}">Tax Rates</a></li>
                                                    <li><a href="{{route('currency-settings')}}">Currencies</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-settings-2 fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">Other Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('storage-settings')}}">Storage</a></li>
                                                    <li><a href="{{route('ban-ip-address')}}">Ban IP Address </a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-fill mb-0 w-50">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4>Bank Account</h4>
                            <div class="page-btn">
                                <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#add-account"><i class="ti ti-circle-plus me-1"></i>Add New
                                    Account</a>
                            </div>
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                    <div class="card bank-box active">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <h5 class="mb-1">Karur vysya bank</h5>
                                                <p>**** **** 1982</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <span class="fs-13">Holder Name</span>
                                                    <h6>John Smith</h6>
                                                </div>
                                                <div class="hstack gap-2 fs-15">
                                                    <a href="#" class="btn btn-icon btn-sm btn-info-light"
                                                        data-bs-toggle="modal" data-bs-target="#edit-account"><i
                                                            data-feather="edit" class="feather-edit"></i></a>
                                                    <a href="#" class="btn btn-icon btn-sm btn-danger-light"
                                                        data-bs-toggle="modal" data-bs-target="#delete-modal"><i
                                                            data-feather="trash-2" class="feather-trash-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                    <div class="card bank-box">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <h5 class="mb-1">Swiss Bank</h5>
                                                <p>**** **** 1796</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <span>Holder Name</span>
                                                    <h6>Andrew</h6>
                                                </div>
                                                <div class="hstack gap-2 fs-15">
                                                    <a href="#" class="btn btn-icon btn-sm btn-info-light"
                                                        data-bs-toggle="modal" data-bs-target="#edit-account"><i
                                                            data-feather="edit" class="feather-edit"></i></a>
                                                    <a href="#" class="btn btn-icon btn-sm btn-danger-light"
                                                        data-bs-toggle="modal" data-bs-target="#delete-modal"><i
                                                            data-feather="trash-2" class="feather-trash-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                    <div class="card bank-box">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <h5 class="mb-1">HDFC</h5>
                                                <p>**** **** 1832</p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div>
                                                    <span>Holder Name</span>
                                                    <h6>Mathew</h6>
                                                </div>
                                                <div class="hstack gap-2 fs-15">
                                                    <a href="#" class="btn btn-icon btn-sm btn-info-light"
                                                        data-bs-toggle="modal" data-bs-target="#edit-account"><i
                                                            data-feather="edit" class="feather-edit"></i></a>
                                                    <a href="#" class="btn btn-icon btn-sm btn-danger-light"
                                                        data-bs-toggle="modal" data-bs-target="#delete-modal"><i
                                                            data-feather="trash-2" class="feather-trash-2"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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