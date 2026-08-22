<?php $page = 'notification'; ?>
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
                                                <a href="javascript:void(0);" class="active subdrop">
                                                    <i class="ti ti-settings fs-18"></i>
                                                    <span class="fs-14 fw-medium ms-2">General Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <ul>
                                                    <li><a href="{{route('general-settings')}}">Profile</a></li>
                                                    <li><a href="{{route('security-settings')}}">Security</a></li>
                                                    <li><a href="{{route('notification')}}"
                                                            class="active">Notifications</a></li>
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
                                                    <li><a href="{{route('sms-settings')}}">SMS Gateways</a></li>
                                                    <li><a href="{{route('otp-settings')}}">OTP</a></li>
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
                        <div class="card-header">
                            <h4 class="fs-18 fw-bold">Notification</h4>
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-medium">Mobile Push Notifications</h6>
                                    </div>
                                    <div class="status-toggle modal-status">
                                        <input type="checkbox" id="user1" class="check" checked>
                                        <label for="user1" class="checktoggle"> </label>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-medium">Desktop Notifications</h6>
                                    </div>
                                    <div class="status-toggle modal-status">
                                        <input type="checkbox" id="user2" class="check" checked>
                                        <label for="user2" class="checktoggle"> </label>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-medium">Email Notifications</h6>
                                    </div>
                                    <div class="status-toggle modal-status">
                                        <input type="checkbox" id="user3" class="check" checked>
                                        <label for="user3" class="checktoggle"> </label>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        <h6 class="fw-medium">MSMS Notifications</h6>
                                    </div>
                                    <div
                                        class="status-toggle modal-status d-flex justify-content-between align-items-center ms-2">
                                        <input type="checkbox" id="user4" class="check" checked>
                                        <label for="user4" class="checktoggle"> </label>
                                    </div>
                                </div>
                                <div class="table-responsive notification-table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>General Notification</th>
                                                <th>Push</th>
                                                <th>SMS</th>
                                                <th>Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    Payment
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="users4" class="check" checked>
                                                        <label for="users4" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="users5" class="check" checked>
                                                        <label for="users5" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="users6" class="check" checked>
                                                        <label for="users6" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Transaction
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user5" class="check" checked>
                                                        <label for="user5" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user6" class="check" checked>
                                                        <label for="user6" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user7" class="check" checked>
                                                        <label for="user7" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Email Verification
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user8" class="check" checked>
                                                        <label for="user8" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user9" class="check" checked>
                                                        <label for="user9" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user10" class="check" checked>
                                                        <label for="user10" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    OTP
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user11" class="check" checked>
                                                        <label for="user11" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user12" class="check" checked>
                                                        <label for="user12" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user13" class="check" checked>
                                                        <label for="user13" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Activity
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user14" class="check" checked>
                                                        <label for="user14" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user15" class="check" checked>
                                                        <label for="user15" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user16" class="check" checked>
                                                        <label for="user16" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Account
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user17" class="check" checked>
                                                        <label for="user17" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user18" class="check" checked>
                                                        <label for="user18" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-toggle modal-status">
                                                        <input type="checkbox" id="user19" class="check" checked>
                                                        <label for="user19" class="checktoggle"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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