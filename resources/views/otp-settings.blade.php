<?php $page = 'otp-settings'; ?>
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
                                                <a href="javascript:void(0);" class="active subdrop">
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
                                                    <li><a href="{{route('otp-settings')}}" class="active">OTP</a></li>
                                                    <li><a href="{{route('gdpr-settings')}}">GDPR Cookies</a></li>
                                                </ul>
                                            </li>
                                            <li class="submenu">
                                                <a href="javascript:void(0);">
                                                    <i class="ti ti-settings-dollar fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">Financial Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('payment-gateway-settings')}}">Payment
                                                            Gateway</a></li>
                                                    <li><a href="{{route('bank-settings-grid')}}">Bank Accounts </a>
                                                    </li>
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
                    <div class="card flex-fill mb-0">
                        <form action="{{route('otp-settings')}}">
                            <div class="card-header">
                                <h4>OTP</h4>
                            </div>
                            <div class="card-body">
                                <div class="localization-info">
                                    <div class="row align-items-center">
                                        <div class="col-sm-4">
                                            <div class="setting-info">
                                                <h6>OTP Type</h6>
                                                <p>Your can configure the type</p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="localization-select">
                                                <select class="select">
                                                    <option>SMS</option>
                                                    <option>Email</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-4">
                                            <div class="setting-info">
                                                <h6>OTP Digit Limit</h6>
                                                <p>Select size of the format </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="localization-select">
                                                <select class="select">
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-sm-4">
                                            <div class="setting-info">
                                                <h6>OTP Expire Time</h6>
                                                <p>Select expire time of OTP </p>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="localization-select">
                                                <select class="select">
                                                    <option>5 Mins</option>
                                                    <option>10 Mins</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <button type="button" class="btn btn-secondary me-2">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
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