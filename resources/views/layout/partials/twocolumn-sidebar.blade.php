@if (!Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
<!-- Two Col Sidebar -->
<div class="two-col-sidebar" id="two-col-sidebar">
    <div class="sidebar sidebar-twocol">
        <div class="twocol-mini">
            <div class="sidebar-left slimscroll">
                <div class="nav flex-column align-items-center nav-pills" id="sidebar-tabs" role="tablist"
                    aria-orientation="vertical">
                    <a href="#"
                        class="nav-link {{ Request::is('index', '/', 'sales-dashboard', 'admin-dashboard') ? 'active' : '' }}"
                        title="Dashboard" data-bs-toggle="tab" data-bs-target="#dashboard">
                        <i class="ti ti-smart-home"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('dashboard', 'companies', 'subscription', 'packages', 'domain', 'purchase-transaction') ? 'active' : '' }}"
                        title="Super Admin" data-bs-toggle="tab" data-bs-target="#super-admin">
                        <i class="ti ti-user-star"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('chat', 'audio-call', 'call-history', 'video-call', 'calendar', 'contacts', 'email', 'email-reply', 'todo', 'todo-list', 'notes', 'file-manager', 'projects', 'products', 'orders', 'customers', 'cart', 'checkout', 'wishlist', 'reviews', 'social-feed', 'search-list') ? 'active' : '' }}"
                        title="Apps" data-bs-toggle="tab" data-bs-target="#application">
                        <i class="ti ti-layout-grid-add"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('layout-horizontal', 'layout-detached', 'layout-two-column', 'layout-hovered', 'layout-boxed', 'layout-rtl', 'layout-dark') ? 'active' : '' }}"
                        title="Layout" data-bs-toggle="tab" data-bs-target="#layout">
                        <i class="ti ti-layout-board-split"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('product-list', 'edit-product', 'product-details', 'add-product', 'expired-products', 'low-stocks', 'category-list', 'sub-categories', 'brand-list', 'varriant-attributes', 'units', 'warranty', 'barcode', 'qrcode') ? 'active' : '' }}"
                        title="Inventory" data-bs-toggle="tab" data-bs-target="#inventory">
                        <i class="ti ti-table-plus"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('manage-stocks', 'stock-adjustment', 'stock-transfer') ? 'active' : '' }}"
                        title="Stock" data-bs-toggle="tab" data-bs-target="#stock">
                        <i class="ti ti-stack-3"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('online-orders', 'pos-orders', 'invoice', 'invoice-details', 'sales-returns', 'quotation-list', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5') ? 'active' : '' }}"
                        title="Sales" data-bs-toggle="tab" data-bs-target="#sales">
                        <i class="ti ti-device-laptop"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('coupons', 'gift-cards', 'discount-plan', 'discount', 'purchase-list', 'purchase-order-report', 'purchase-returns', 'expense-list', 'expense-category', 'income', 'income-category', 'account-list', 'money-transfer', 'balance-sheet', 'balance-sheet-v2', 'trial-balance', 'cash-flow', 'cash-flow-v2', 'account-statement', 'billers', 'suppliers', 'store-list', 'warehouse') ? 'active' : '' }}"
                        title="Finance" data-bs-toggle="tab" data-bs-target="#finance">
                        <i class="ti ti-shopping-cart-dollar"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('employees-grid', 'department-grid', 'designation', 'shift', 'attendance-employee', 'attendance-admin', 'leaves-admin', 'leaves-employee', 'leave-types', 'holidays', 'employee-salary', 'payslip', 'add-employee', 'edit-employee', 'employee-details', 'employees-list', 'department-list') ? 'active show' : '' }}"
                        title="Hrm" data-bs-toggle="tab" data-bs-target="#hrm">
                        <i class="ti ti-cash"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('sales-report', 'best-seller', 'inventory-report', 'stock-history', 'sold-stock', 'supplier-report', 'supplier-due-report', 'customer-report', 'customer-due-report', 'product-report', 'product-expiry-report', 'product-quantity-alert', 'purchase-report', 'invoice-report', 'expense-report', 'income-report', 'tax-reports', 'sales-tax', 'profit-and-loss', 'annual-report') ? 'active' : '' }}"
                        title="Reports" data-bs-toggle="tab" data-bs-target="#reports">
                        <i class="ti ti-license"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('pages', 'all-blog', 'blog-details', 'blog-tag', 'blog-categories', 'countries', 'states', 'cities', 'signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'blank-page', 'pricing', 'testimonials', 'faq', 'users', 'department-grid', 'roles-permissions', 'permissions', 'delete-account', 'coming-soon', 'under-maintenance') ? 'active' : '' }}"
                        title="Pages" data-bs-toggle="tab" data-bs-target="#pages">
                        <i class="ti ti-page-break"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('general-settings', 'security-settings', 'notification', 'activities', 'connected-apps', 'system-settings', 'company-settings', 'localization-settings', 'prefixes', 'preference', 'appearance', 'social-authentication', 'language-settings', 'language-settings-web', 'invoice-settings', 'invoice-templates', 'printer-settings', 'pos-settings', 'signatures', 'custom-fields', 'email-settings', 'email-templates', 'sms-settings', 'sms-templates', 'otp-settings', 'gdpr-settings', 'payment-gateway-settings', 'bank-settings-grid', 'bank-settings-list', 'tax-rates', 'currency-settings', 'storage-settings', 'ban-ip-address') ? 'active' : '' }}"
                        title="Settings" data-bs-toggle="tab" data-bs-target="#settings">
                        <i class="ti ti-lock-check"></i>
                    </a>
                    <a href="#"
                        class="nav-link {{ Request::is('ui-alerts', 'ui-accordion', 'ui-avatar', 'ui-badges', 'ui-borders', 'ui-buttons', 'ui-buttons-group', 'ui-breadcrumb', 'ui-cards', 'ui-carousel', 'ui-colors', 'ui-dropdowns', 'ui-grid', 'ui-images', 'ui-lightbox', 'ui-media', 'ui-modals', 'ui-offcanvas', 'ui-pagination', 'ui-popovers', 'ui-progress', 'ui-placeholders', 'ui-rangeslider', 'ui-spinner', 'ui-sweetalerts', 'ui-nav-tabs', 'ui-toasts', 'ui-tooltips', 'ui-typography', 'ui-video', 'ui-sortable', 'ui-swiperjs', 'ui-ribbon', 'ui-clipboard', 'ui-drag-drop', 'ui-rangeslider', 'ui-rating', 'ui-text-editor', 'ui-counter', 'ui-scrollbar', 'ui-stickynote', 'ui-timeline', 'chart-apex', 'chart-c3', 'chart-js', 'chart-morris', 'chart-flot', 'chart-peity', 'icon-fontawesome', 'icon-feather', 'icon-ionic', 'icon-material', 'icon-pe7', 'icon-simpleline', 'icon-themify', 'icon-weather', 'icon-typicon', 'icon-flag', 'icon-tabler') ? 'active' : '' }}"
                        title="UI Elements" data-bs-toggle="tab" data-bs-target="#ui-elements">
                        <i class="ti ti-ux-circle"></i>
                    </a>
                    <a href="#" class="nav-link" title="Extras" data-bs-toggle="tab" data-bs-target="#extras">
                        <i class="ti ti-vector-triangle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-right">
            <!-- Logo -->
            <div class="sidebar-logo">
                <a href="{{route('index')}}" class="logo logo-normal">
                    <img src="{{URL::asset('build/img/logo.svg')}}" alt="Img">
                </a>
                <a href="{{route('index')}}" class="logo logo-white">
                    <img src="{{URL::asset('build/img/logo-white.svg')}}" alt="Img">
                </a>
                <a href="{{route('index')}}" class="logo-small">
                    <img src="{{URL::asset('build/img/logo-small.png')}}" alt="Img">
                </a>
            </div>
            <!-- /Logo -->
            <div class="sidebar-scroll">
                <div class="text-center rounded bg-light p-3 mb-3 border">
                    <div class="avatar avatar-lg online mb-3">
                        <img src="{{URL::asset('build/img/customer/customer15.jpg')}}" alt="Img"
                            class="img-fluid rounded-circle">
                    </div>
                    <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                    <p class="fs-12 mb-0">System Admin</p>
                </div>
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade  {{ Request::is('index', '/', 'sales-dashboard', 'admin-dashboard') ? 'show active' : '' }}"
                        id="dashboard">
                        <ul>
                            <li class="menu-title"><span>MAIN</span></li>
                            <li><a href="{{route('index')}}"
                                    class="{{ Request::is('index', '/') ? 'active' : '' }}">Admin Dashboard</a></li>
                            <li><a href="{{route('admin-dashboard')}}"
                                    class="{{ Request::is('admin-dashboard') ? 'active' : '' }}">Admin Dashboard 2</a>
                            </li>
                            <li><a href="{{route('sales-dashboard')}}"
                                    class="{{ Request::is('sales-dashboard') ? 'active' : '' }}">Sales Dashboard</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('dashboard', 'companies', 'subscription', 'packages', 'domain', 'purchase-transaction') ? 'active show' : '' }} "
                        id="super-admin">
                        <ul>
                            <li class="menu-title"><span>SUPER ADMIN</span></li>
                            <li><a href="{{route('dashboard')}}"
                                    class="{{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a></li>
                            <li><a href="{{route('companies')}}"
                                    class="{{ Request::is('companies') ? 'active' : '' }}">Companies</a></li>
                            <li><a href="{{route('subscription')}}"
                                    class="{{ Request::is('subscription') ? 'active' : '' }}">Subscriptions</a></li>
                            <li><a href="{{route('packages')}}"
                                    class="{{ Request::is('packages') ? 'active' : '' }}">Packages</a></li>
                            <li><a href="{{route('domain')}}"
                                    class="{{ Request::is('domain') ? 'active' : '' }}">Domain</a></li>
                            <li><a href="{{route('purchase-transaction')}}"
                                    class="{{ Request::is('purchase-transaction') ? 'active' : '' }}">Purchase
                                    Transaction</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('chat', 'audio-call', 'call-history','video-call','calendar','contacts','email','email-reply' ,'todo','todo-list' ,'notes', 'file-manager', 'projects', 'products', 'orders', 'customers', 'cart','checkout','wishlist','reviews','social-feed','search-list') ? 'active show' : '' }}"
                        id="application">
                        <ul>
                            <li><a href="{{route('chat')}}" class="{{ Request::is('chat') ? 'active' : '' }}">Chat</a>
                            </li>
                            <li class="submenu submenu-two"><a href="javascript:void(0);"
                                    class="{{ Request::is('video-call', 'call-history', 'audio-call') ? 'active subdrop' : '' }}">Call<span
                                        class="menu-arrow inside-submenu"></span></a>
                                <ul>
                                    <li><a href="{{route('video-call')}}"
                                            class="{{ Request::is('video-call') ? 'active' : '' }}">Video Call</a></li>
                                    <li><a href="{{route('audio-call')}}"
                                            class="{{ Request::is('audio-call') ? 'active' : '' }}">Audio Call</a></li>
                                    <li><a href="{{route('call-history')}}"
                                            class="{{ Request::is('call-history') ? 'active' : '' }}">Call History</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{route('calendar')}}"
                                    class="{{ Request::is('calendar') ? 'active' : '' }}">Calendar</a></li>
                            <li><a href="{{route('contacts')}}"
                                    class="{{ Request::is('contacts') ? 'active' : '' }}">Contacts</a></li>
                            <li><a href="{{route('email')}}"
                                    class="{{ Request::is('email', 'email-reply') ? 'active' : '' }}">Email</a></li>
                            <li><a href="{{route('todo')}}"
                                    class="{{ Request::is('todo', 'todo-list') ? 'active' : '' }}">To Do</a></li>
                            <li><a href="{{route('notes')}}"
                                    class="{{ Request::is('notes') ? 'active' : '' }}">Notes</a></li>
                            <li><a href="{{route('file-manager')}}"
                                    class="{{ Request::is('file-manager') ? 'active' : '' }}">File Manager</a></li>
                            <li><a href="{{route('projects')}}"
                                    class="{{ Request::is('projects') ? 'active' : '' }}">Projects</a></li>
                            <li class="submenu submenu-two"><a href="javascript:void(0);"
                                    class="{{ Request::is('products', 'orders', 'customers', 'cart', 'checkout', 'wishlist', 'reviews') ? 'active subdrop' : '' }}">Ecommerce<span
                                        class="menu-arrow inside-submenu"></span></a>
                                <ul>
                                    <li><a href="{{route('products')}}"
                                            class="{{ Request::is('products') ? 'active' : '' }}">Products</a></li>
                                    <li><a href="{{route('orders')}}"
                                            class="{{ Request::is('orders') ? 'active' : '' }}">Orders</a></li>
                                    <li><a href="{{route('customers')}}"
                                            class="{{ Request::is('customers') ? 'active' : '' }}">Customers</a></li>
                                    <li><a href="{{route('cart')}}"
                                            class="{{ Request::is('cart') ? 'active' : '' }}">Cart</a></li>
                                    <li><a href="{{route('checkout')}}"
                                            class="{{ Request::is('checkout') ? 'active' : '' }}">Checkout</a></li>
                                    <li><a href="{{route('wishlist')}}"
                                            class="{{ Request::is('wishlist') ? 'active' : '' }}">Wishlist</a></li>
                                    <li><a href="{{route('reviews')}}"
                                            class="{{ Request::is('reviews') ? 'active' : '' }}">Reviews</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('social-feed')}}"
                                    class="{{ Request::is('social-feed') ? 'active' : '' }}">Social Feed</a></li>
                            <li><a href="{{route('search-list')}}"
                                    class="{{ Request::is('search-list') ? 'active' : '' }}">Search List</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('layout-horizontal', 'layout-detached', 'layout-two-column', 'layout-hovered', 'layout-boxed', 'layout-rtl', 'layout-dark') ? 'active show' : '' }}"
                        id="layout">
                        <ul>
                            <li class="menu-title"><span>LAYOUT</span></li>
                            <li><a href="{{route('layout-horizontal')}}"
                                    class="{{ Request::is('layout-horizontal') ? 'active' : '' }}">Horizontal</a></li>
                            <li><a href="{{route('layout-detached')}}"
                                    class="{{ Request::is('layout-detached') ? 'active' : '' }}">Detached</a></li>
                            <li><a href="{{route('layout-two-column')}}"
                                    class="{{ Request::is('layout-two-column') ? 'active' : '' }}">Two Column</a></li>
                            <li><a href="{{route('layout-hovered')}}"
                                    class="{{ Request::is('layout-hovered') ? 'active' : '' }}">Hovered</a></li>
                            <li><a href="{{route('layout-boxed')}}"
                                    class="{{ Request::is('layout-boxed') ? 'active' : '' }}">Boxed</a></li>
                            <li><a href="{{route('layout-rtl')}}"
                                    class="{{ Request::is('layout-rtl') ? 'active' : '' }}">RTL</a></li>
                            <li><a href="{{route('layout-dark')}}"
                                    class="{{ Request::is('layout-dark') ? 'active' : '' }}">Dark</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('product-list','edit-product','product-details', 'add-product', 'expired-products', 'low-stocks', 'category-list', 'sub-categories', 'brand-list', 'varriant-attributes', 'units', 'warranty', 'barcode', 'qrcode') ? 'active show' : '' }}"
                        id="inventory">
                        <ul>
                            <li class="menu-title"><span>Inventory</span></li>
                            <li><a href="{{route('product-list')}}"
                                    class="{{ Request::is('product-list','edit-product','product-details') ? 'active' : '' }}"><span>Products</span></a>
                            </li>
                            <li><a href="{{route('add-product')}}"
                                    class="{{ Request::is('add-product') ? 'active' : '' }}"><span>Create
                                        Product</span></a></li>
                            <li><a href="{{route('expired-products')}}"
                                    class="{{ Request::is('expired-products') ? 'active' : '' }}"><span>Expired
                                        Products</span></a></li>
                            <li><a href="{{route('low-stocks')}}"
                                    class="{{ Request::is('low-stocks') ? 'active' : '' }}"><span>Low Stocks</span></a>
                            </li>
                            <li><a href="{{route('category-list')}}"
                                    class="{{ Request::is('category-list') ? 'active' : '' }}"><span>Category</span></a>
                            </li>
                            <li><a href="{{route('sub-categories')}}"
                                    class="{{ Request::is('sub-categories') ? 'active' : '' }}"><span>Sub
                                        Category</span></a></li>
                            <li><a href="{{route('brand-list')}}"
                                    class="{{ Request::is('brand-list') ? 'active' : '' }}"><span>Brands</span></a></li>
                            <li><a href="{{route('units')}}"
                                    class="{{ Request::is('units') ? 'active' : '' }}"><span>Units</span></a></li>
                            <li><a href="{{route('varriant-attributes')}}"
                                    class="{{ Request::is('varriant-attributes') ? 'active' : '' }}"><span>Variant
                                        Attributes</span></a></li>
                            <li><a href="{{route('warranty')}}"
                                    class="{{ Request::is('warranty') ? 'active' : '' }}"><span>Warranties</span></a>
                            </li>
                            <li><a href="{{route('barcode')}}"
                                    class="{{ Request::is('barcode') ? 'active' : '' }}"><span>Print Barcode</span></a>
                            </li>
                            <li><a href="{{route('qrcode')}}"
                                    class="{{ Request::is('qrcode') ? 'active' : '' }}"><span>Print QR Code</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('manage-stocks', 'stock-adjustment', 'stock-transfer') ? 'active show' : '' }}"
                        id="stock">
                        <ul>
                            <li class="menu-title"><span>Stock</span></li>
                            <li><a href="{{route('manage-stocks')}}"
                                    class="{{ Request::is('manage-stocks') ? 'active' : '' }}">Manage Stock</a></li>
                            <li><a href="{{route('stock-adjustment')}}"
                                    class="{{ Request::is('stock-adjustment') ? 'active' : '' }}">Stock Adjustment</a>
                            </li>
                            <li><a href="{{route('stock-transfer')}}"
                                    class="{{ Request::is('stock-transfer') ? 'active' : '' }}">Stock Transfer</a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('online-orders', 'pos-orders', 'invoice','invoice-details', 'sales-returns', 'quotation-list','pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5') ? 'active show' : '' }}"
                        id="sales">
                        <ul>
                            <li class="menu-title"><span>Sales</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('online-orders', 'pos-orders') ? 'active subdrop' : '' }}"><span>Sales</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('online-orders')}}"
                                            class="{{ Request::is('online-orders') ? 'active' : '' }}">Online Orders</a>
                                    </li>
                                    <li><a href="{{route('pos-orders')}}"
                                            class="{{ Request::is('pos-orders') ? 'active' : '' }}">POS Orders</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('invoice')}}"
                                    class="{{ Request::is('invoice','invoice-details') ? 'active' : '' }}">Invoices</a>
                            </li>
                            <li><a href="{{route('sales-returns')}}"
                                    class="{{ Request::is('sales-returns') ? 'active' : '' }}">Sales Return</a></li>
                            <li><a href="{{route('quotation-list')}}"
                                    class="{{ Request::is('quotation-list') ? 'active' : '' }}">Quotation</a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5') ? 'active subdrop' : '' }}"><span>POS</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('pos')}}" class="{{ Request::is('pos') ? 'active' : '' }}">POS
                                            1</a></li>
                                    <li><a href="{{route('pos-2')}}"
                                            class="{{ Request::is('pos-2') ? 'active' : '' }}">POS 2</a></li>
                                    <li><a href="{{route('pos-3')}}"
                                            class="{{ Request::is('pos-3') ? 'active' : '' }}">POS 3</a></li>
                                    <li><a href="{{route('pos-4')}}"
                                            class="{{ Request::is('pos-4') ? 'active' : '' }}">POS 4</a></li>
                                    <li><a href="{{route('pos-5')}}"
                                            class="{{ Request::is('pos-5') ? 'active' : '' }}">POS 5</a></li>
                                    <li><a href="https://dreamspos.dreamstechnologies.com/food-pos/laravel/template/public/index"
                                            target="_blank">POS 6</a></li>
                                    <li><a href="https://dreamspos.dreamstechnologies.com/laundry-pos/laravel/template/public/index"
                                            target="_blank">POS 7</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('coupons', 'gift-cards','discount-plan', 'discount','purchase-list', 'purchase-order-report', 'purchase-returns','expense-list', 'expense-category','income', 'income-category','income', 'income-category','account-list','money-transfer','balance-sheet','balance-sheet-v2','trial-balance','cash-flow','cash-flow-v2','account-statement', 'billers', 'suppliers', 'store-list', 'warehouse') ? 'active show' : '' }}"
                        id="finance">
                        <ul>
                            <li class="menu-title"><span>FINANCE & ACCOUNTS</span></li>
                            <li><a href="{{route('coupons')}}"
                                    class="{{ Request::is('coupons') ? 'active' : '' }}"><span>Coupons</span></a></li>
                            <li><a href="{{route('gift-cards')}}"
                                    class="{{ Request::is('gift-cards') ? 'active' : '' }}"><span>Gift Cards</span></a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('discount-plan', 'discount') ? 'active subdrop' : '' }}"><span>Discount</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('discount-plan')}}"
                                            class="{{ Request::is('discount-plan') ? 'active' : '' }}">Discount Plan</a>
                                    </li>
                                    <li><a href="{{route('discount')}}"
                                            class="{{ Request::is('discount') ? 'active' : '' }}">Discount</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('purchase-list')}}"
                                    class="{{ Request::is('purchase-list') ? 'active' : '' }}"><span>Purchases</span></a>
                            </li>
                            <li><a href="{{route('purchase-order-report')}}"
                                    class="{{ Request::is('purchase-order-report') ? 'active' : '' }}"><span>Purchase
                                        Order</span></a></li>
                            <li><a href="{{route('purchase-returns')}}"
                                    class="{{ Request::is('purchase-returns') ? 'active' : '' }}"><span>Purchase
                                        Return</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('expense-list', 'expense-category') ? 'active subdrop' : '' }}"><span>Expenses</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('expense-list')}}"
                                            class="{{ Request::is('expense-list') ? 'active' : '' }}">Expenses</a></li>
                                    <li><a href="{{route('expense-category')}}"
                                            class="{{ Request::is('expense-category') ? 'active' : '' }}">Expense
                                            Category</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('income', 'income-category') ? 'active subdrop' : '' }}"><span>Income</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('income')}}"
                                            class="{{ Request::is('income') ? 'active' : '' }}">Income</a></li>
                                    <li><a href="{{route('income-category')}}"
                                            class="{{ Request::is('income-category') ? 'active' : '' }}">Income
                                            Category</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('account-list')}}"
                                    class="{{ Request::is('account-list') ? 'active' : '' }}"><span>Bank
                                        Accounts</span></a></li>
                            <li><a href="{{route('money-transfer')}}"
                                    class="{{ Request::is('money-transfer') ? 'active' : '' }}"><span>Money
                                        Transfer</span></a></li>
                            <li><a href="{{route('balance-sheet')}}"
                                    class="{{ Request::is('balance-sheet','balance-sheet-v2') ? 'active' : '' }}"><span>Balance
                                        Sheet</span></a></li>
                            <li><a href="{{route('trial-balance')}}"
                                    class="{{ Request::is('trial-balance') ? 'active' : '' }}"><span>Trial
                                        Balance</span></a></li>
                            <li><a href="{{route('cash-flow')}}"
                                    class="{{ Request::is('cash-flow','cash-flow-v2') ? 'active' : '' }}"><span>Cash
                                        Flow</span></a></li>
                            <li><a href="{{route('account-statement')}}"
                                    class="{{ Request::is('account-statement') ? 'active' : '' }}"><span>Account
                                        Statement</span></a></li>
                            <li><a href="{{route('customers')}}"
                                    class="{{ Request::is('customers') ? 'active' : '' }}"><span>Customers</span></a>
                            </li>
                            <li><a href="{{route('billers')}}"
                                    class="{{ Request::is('billers') ? 'active' : '' }}"><span>Billers</span></a></li>
                            <li><a href="{{route('suppliers')}}"
                                    class="{{ Request::is('suppliers') ? 'active' : '' }}"><span>Suppliers</span></a>
                            </li>
                            <li><a href="{{route('store-list')}}"
                                    class="{{ Request::is('store-list') ? 'active' : '' }}"><span>Stores</span></a></li>
                            <li><a href="{{route('warehouse')}}"
                                    class="{{ Request::is('warehouse') ? 'active' : '' }}"><span>Warehouses</span></a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('employees-grid', 'department-grid', 'designation', 'shift','attendance-employee', 'attendance-admin','leaves-admin', 'leaves-employee', 'leave-types', 'holidays','employee-salary', 'payslip','add-employee','edit-employee','employee-details','employees-list', 'department-list') ? 'active show' : '' }}"
                        id="hrm">
                        <ul>
                            <li class="menu-title"><span>Hrm</span></li>
                            <li><a href="{{route('employees-grid')}}"
                                    class="{{ Request::is('employees-grid','add-employee','edit-employee','employee-details','employees-list') ? 'active' : '' }}"><span>Employees</span></a>
                            </li>
                            <li><a href="{{route('department-grid')}}"
                                    class="{{ Request::is('department-grid', 'department-list') ? 'active' : '' }}"><span>Departments</span></a>
                            </li>
                            <li><a href="{{route('designation')}}"
                                    class="{{ Request::is('designation') ? 'active' : '' }}"><span>Designation</span></a>
                            </li>
                            <li><a href="{{route('shift')}}"
                                    class="{{ Request::is('shift') ? 'active' : '' }}"><span>Shifts</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('attendance-employee', 'attendance-admin') ? 'active subdrop' : '' }}"><span>Attendence</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('attendance-employee')}}"
                                            class="{{ Request::is('attendance-employee') ? 'active' : '' }}">Employee</a>
                                    </li>
                                    <li><a href="{{route('attendance-admin')}}"
                                            class="{{ Request::is('attendance-admin') ? 'active' : '' }}">Admin</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('leaves-admin', 'leaves-employee', 'leave-types') ? 'active subdrop' : '' }}"><span>Leaves</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('leaves-admin')}}"
                                            class="{{ Request::is('leaves-admin') ? 'active' : '' }}">Admin Leaves</a>
                                    </li>
                                    <li><a href="{{route('leaves-employee')}}"
                                            class="{{ Request::is('leaves-employee') ? 'active' : '' }}">Employee
                                            Leaves</a></li>
                                    <li><a href="{{route('leave-types')}}"
                                            class="{{ Request::is('leave-types') ? 'active' : '' }}">Leave Types</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{route('holidays')}}"
                                    class="{{ Request::is('holidays') ? 'active' : '' }}"><span>Holidays</span></a></li>
                            <li class="submenu">
                                <a href="{{route('employee-salary')}}"
                                    class="{{ Request::is('employee-salary', 'payslip') ? 'active subdrop' : '' }}"><span>Payroll</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('employee-salary')}}"
                                            class="{{ Request::is('employee-salary') ? 'active' : '' }}">Employee
                                            Salary</a></li>
                                    <li><a href="{{route('payslip')}}"
                                            class="{{ Request::is('payslip') ? 'active' : '' }}">Payslip</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('sales-report', 'best-seller','inventory-report', 'stock-history', 'sold-stock','supplier-report', 'supplier-due-report','customer-report', 'customer-due-report','product-report', 'product-expiry-report', 'product-quantity-alert','purchase-report','invoice-report','expense-report','income-report','tax-reports','sales-tax','profit-and-loss','annual-report') ? 'active show' : '' }}"
                        id="reports">
                        <ul>
                            <li class="menu-title"><span>Reports</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('sales-report', 'best-seller') ? 'active subdrop' : '' }}"><span>Sales
                                        Report</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('sales-report')}}"
                                            class="{{ Request::is('sales-report') ? 'active' : '' }}">Sales Report</a>
                                    </li>
                                    <li><a href="{{route('best-seller')}}"
                                            class="{{ Request::is('best-seller') ? 'active' : '' }}">Best Seller</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="{{route('purchase-report')}}"
                                    class="{{ Request::is('purchase-report') ? 'active' : '' }}"><span>Purchase
                                        report</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('inventory-report', 'stock-history', 'sold-stock') ? 'active subdrop' : '' }}"><span>Inventory
                                        Report</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('inventory-report')}}"
                                            class="{{ Request::is('inventory-report') ? 'active' : '' }}">Inventory
                                            Report</a></li>
                                    <li><a href="{{route('stock-history')}}"
                                            class="{{ Request::is('stock-history') ? 'active' : '' }}">Stock History</a>
                                    </li>
                                    <li><a href="{{route('sold-stock')}}"
                                            class="{{ Request::is('sold-stock') ? 'active' : '' }}">Sold Stock</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('invoice-report')}}"
                                    class="{{ Request::is('invoice-report') ? 'active' : '' }}"><span>Invoice
                                        Report</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('supplier-report', 'supplier-due-report') ? 'active subdrop' : '' }}"><span>Supplier
                                        Report</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('supplier-report')}}"
                                            class="{{ Request::is('supplier-report') ? 'active' : '' }}">Supplier
                                            Report</a></li>
                                    <li><a href="{{route('supplier-due-report')}}"
                                            class="{{ Request::is('supplier-due-report') ? 'active' : '' }}">Supplier
                                            Due Report</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('customer-report', 'customer-due-report') ? 'active subdrop' : '' }}"><span>Customer
                                        Report</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('customer-report')}}"
                                            class="{{ Request::is('customer-report') ? 'active' : '' }}">Customer
                                            Report</a></li>
                                    <li><a href="{{route('customer-due-report')}}"
                                            class="{{ Request::is('customer-due-report') ? 'active' : '' }}">Customer
                                            Due Report</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('product-report', 'product-expiry-report', 'product-quantity-alert') ? 'active subdrop' : '' }}"><span>Product
                                        Report</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('product-report')}}"
                                            class="{{ Request::is('product-report') ? 'active' : '' }}">Product
                                            Report</a></li>
                                    <li><a href="{{route('product-expiry-report')}}"
                                            class="{{ Request::is('product-expiry-report') ? 'active' : '' }}">Product
                                            Expiry Report</a></li>
                                    <li><a href="{{route('product-quantity-alert')}}"
                                            class="{{ Request::is('product-quantity-alert') ? 'active' : '' }}">Product
                                            Quantity Alert</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('expense-report')}}"
                                    class="{{ Request::is('expense-report') ? 'active' : '' }}"><span>Expense
                                        Report</span></a></li>
                            <li><a href="{{route('income-report')}}"
                                    class="{{ Request::is('income-report') ? 'active' : '' }}"><span>Income
                                        Report</span></a></li>
                            <li><a href="{{route('tax-reports')}}"
                                    class="{{ Request::is('tax-reports','sales-tax') ? 'active' : '' }}"><span>Tax
                                        Report</span></a></li>
                            <li><a href="{{route('profit-and-loss')}}"
                                    class="{{ Request::is('profit-and-loss') ? 'active' : '' }}"><span>Profit &
                                        Loss</span></a></li>
                            <li><a href="{{route('annual-report')}}"
                                    class="{{ Request::is('annual-report') ? 'active' : '' }}"><span>Annual
                                        Report</span></a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('pages','all-blog', 'blog-details', 'blog-tag', 'blog-categories','countries', 'states', 'cities','signin', 'signin-2', 'signin-3','register', 'regi   ster-2', 'register-3','forgot-password', 'forgot-password-2', 'forgot-password-3','reset-password', 'reset-password-2', 'reset-password-3','email-verification', 'email-verification-2', 'email-verification-3','two-step-verification', 'two-step-verification-2', 'two-step-verification-3','lock-screen','blank-page','pricing', 'testimonials', 'faq','users', 'department-grid', 'roles-permissions','permissions', 'delete-account', 'coming-soon', 'under-maintenance') ? 'active show' : '' }}"
                        id="pages">
                        <ul>
                            <li class="menu-title"><span>Pages</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('pages') ? 'active subdrop' : '' }}"><span>Pages</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('pages')}}"
                                            class="{{ Request::is('pages') ? 'active' : '' }}">Pages</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('all-blog', 'blog-details', 'blog-tag', 'blog-categories', 'blog-comments') ? 'active subdrop' : '' }}"><span>Blog</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('all-blog')}}"
                                            class="{{ Request::is('all-blog', 'blog-details') ? 'active' : '' }}">All
                                            Blog</a></li>
                                    <li><a href="{{route('blog-tag')}}"
                                            class="{{ Request::is('blog-tag') ? 'active' : '' }}">Blog Tags</a></li>
                                    <li><a href="{{route('blog-categories')}}"
                                            class="{{ Request::is('blog-categories') ? 'active' : '' }}">Categories</a>
                                    </li>
                                    <li><a href="{{route('blog-comments')}}"
                                            class="{{ Request::is('blog-comments') ? 'active' : '' }}">Blog Comments</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('countries', 'states', 'cities') ? 'active subdrop' : '' }}"><span>Location</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('countries')}}"
                                            class="{{ Request::is('countries') ? 'active' : '' }}">Countries</a></li>
                                    <li><a href="{{route('states')}}"
                                            class="{{ Request::is('states') ? 'active' : '' }}">States</a></li>
                                    <li><a href="{{route('cities')}}"
                                            class="{{ Request::is('cities') ? 'active' : '' }}">Cities</a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('testimonials')}}"
                                    class="{{ Request::is('testimonials') ? 'active' : '' }}"><span>Testimonials</span></a>
                            </li>
                            <li><a href="{{route('faq')}}"
                                    class="{{ Request::is('faq') ? 'active' : '' }}"><span>FAQ</span></a></li>
                            <li><a href="{{route('users')}}"
                                    class="{{ Request::is('users') ? 'active' : '' }}"><span>Users</span></a></li>
                            <li><a href="{{route('roles-permissions')}}"
                                    class="{{ Request::is('roles-permissions','permissions') ? 'active' : '' }}"><span>Roles
                                        & Permissions</span></a></li>
                            <li><a href="{{route('delete-account')}}"
                                    class="{{ Request::is('delete-account') ? 'active' : '' }}"><span>Delete Account
                                        Request</span></a></li>
                            <li><a href="{{route('profile')}}"
                                    class="{{ Request::is('profile') ? 'active' : '' }}"><span>Profile</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('signin', 'signin-2', 'signin-3','register', 'register-2', 'register-3','forgot-password', 'forgot-password-2', 'forgot-password-3','reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3','two-step-verification', 'two-step-verification-2', 'two-step-verification-3' ) ? 'active subdrop' : '' }}"><span>Authentication</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('signin', 'signin-2', 'signin-3') ? 'active subdrop' : '' }}">Login<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('signin')}}"
                                                    class="{{ Request::is('signin') ? 'active' : '' }}">Cover</a></li>
                                            <li><a href="{{route('signin-2')}}"
                                                    class="{{ Request::is('signin-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('signin-3')}}"
                                                    class="{{ Request::is('signin-3') ? 'active' : '' }}">Basic</a></li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('register', 'register-2', 'register-3') ? 'active subdrop' : '' }}">Register<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('register')}}"
                                                    class="{{ Request::is('register') ? 'active' : '' }}">Cover</a></li>
                                            <li><a href="{{route('register-2')}}"
                                                    class="{{ Request::is('register-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('register-3')}}"
                                                    class="{{ Request::is('register-3') ? 'active' : '' }}">Basic</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('forgot-password', 'forgot-password-2', 'forgot-password-3') ? 'active subdrop' : '' }}">Forgot
                                            Password<span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('forgot-password')}}"
                                                    class="{{ Request::is('forgot-password') ? 'active' : '' }}">Cover</a>
                                            </li>
                                            <li><a href="{{route('forgot-password-2')}}"
                                                    class="{{ Request::is('forgot-password-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('forgot-password-3')}}"
                                                    class="{{ Request::is('forgot-password-3') ? 'active' : '' }}">Basic</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('reset-password', 'reset-password-2', 'reset-password-3') ? 'active subdrop' : '' }}">Reset
                                            Password<span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('reset-password')}}"
                                                    class="{{ Request::is('reset-password') ? 'active' : '' }}">Cover</a>
                                            </li>
                                            <li><a href="{{route('reset-password-2')}}"
                                                    class="{{ Request::is('reset-password-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('reset-password-3')}}"
                                                    class="{{ Request::is('reset-password-3') ? 'active' : '' }}">Basic</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('email-verification', 'email-verification-2', 'email-verification-3') ? 'active subdrop' : '' }}">Email
                                            Verification<span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('email-verification')}}"
                                                    class="{{ Request::is('email-verification') ? 'active' : '' }}">Cover</a>
                                            </li>
                                            <li><a href="{{route('email-verification-2')}}"
                                                    class="{{ Request::is('email-verification-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('email-verification-3')}}"
                                                    class="{{ Request::is('email-verification-3') ? 'active' : '' }}">Basic</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('two-step-verification', 'two-step-verification-2', 'two-step-verification-3') ? 'active subdrop' : '' }}">2
                                            Step Verification<span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('two-step-verification')}}"
                                                    class="{{ Request::is('two-step-verification') ? 'active' : '' }}">Cover</a>
                                            </li>
                                            <li><a href="{{route('two-step-verification-2')}}"
                                                    class="{{ Request::is('two-step-verification-2') ? 'active' : '' }}">Illustration</a>
                                            </li>
                                            <li><a href="{{route('two-step-verification-3')}}"
                                                    class="{{ Request::is('two-step-verification-3') ? 'active' : '' }}">Basic</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('lock-screen')}}"
                                            class="{{ Request::is('lock-screen') ? 'active' : '' }}">Lock Screen</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('error-404', 'error-500') ? 'active subdrop' : '' }}"><span>Error</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('error-404')}}"
                                            class="{{ Request::is('error-404') ? 'active' : '' }}">404 Error </a></li>
                                    <li><a href="{{route('error-500')}}"
                                            class="{{ Request::is('error-500') ? 'active' : '' }}">500 Error </a></li>
                                </ul>
                            </li>
                            <li><a href="{{route('blank-page')}}"
                                    class="{{ Request::is('blank-page') ? 'active' : '' }}"><span>Blank Page</span> </a>
                            </li>
                            <li><a href="{{route('pricing')}}"
                                    class="{{ Request::is('pricing') ? 'active' : '' }}"><span>Pricing</span> </a></li>
                            <li><a href="{{route('coming-soon')}}"
                                    class="{{ Request::is('coming-soon') ? 'active' : '' }}"><span>Coming Soon</span>
                                </a></li>
                            <li><a href="{{route('under-maintenance')}}"
                                    class="{{ Request::is('under-maintenance') ? 'active' : '' }}"><span>Under
                                        Maintenance</span> </a></li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('general-settings', 'security-settings', 'notification','activities', 'connected-apps','system-settings', 'company-settings', 'localization-settings', 'prefixes', 'preference', 'appearance', 'social-authentication', 'language-settings','language-settings-web','invoice-settings', 'invoice-templates', 'printer-settings', 'pos-settings', 'signatures', 'custom-fields','email-settings', 'email-templates','sms-settings', 'sms-templates', 'otp-settings' , 'gdpr-settings','payment-gateway-settings', 'bank-settings-grid','bank-settings-list', 'tax-rates', 'currency-settings','storage-settings', 'ban-ip-address') ? 'active show' : '' }}"
                        id="settings">
                        <ul>
                            <li class="menu-title"><span>Settings</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('general-settings', 'security-settings', 'notification','activities', 'connected-apps') ? 'active subdrop' : '' }}"><span>General
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('general-settings')}}"
                                            class="{{ Request::is('general-settings') ? 'active' : '' }}">Profile</a>
                                    </li>
                                    <li><a href="{{route('security-settings')}}"
                                            class="{{ Request::is('security-settings') ? 'active' : '' }}">Security</a>
                                    </li>
                                    <li><a href="{{route('notification')}}"
                                            class="{{ Request::is('notification','activities') ? 'active' : '' }}">Notifications</a>
                                    </li>
                                    <li><a href="{{route('connected-apps')}}"
                                            class="{{ Request::is('connected-apps') ? 'active' : '' }}">Connected
                                            Apps</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('system-settings', 'company-settings', 'localization-settings', 'prefixes', 'preference', 'appearance', 'social-authentication', 'language-settings','language-settings-web') ? 'active subdrop' : '' }}"><span>Website
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('system-settings')}}"
                                            class="{{ Request::is('system-settings') ? 'active' : '' }}">System
                                            Settings</a></li>
                                    <li><a href="{{route('company-settings')}}"
                                            class="{{ Request::is('company-settings') ? 'active' : '' }}">Company
                                            Settings </a></li>
                                    <li><a href="{{route('localization-settings')}}"
                                            class="{{ Request::is('localization-settings') ? 'active' : '' }}">Localization</a>
                                    </li>
                                    <li><a href="{{route('prefixes')}}"
                                            class="{{ Request::is('prefixes') ? 'active' : '' }}">Prefixes</a></li>
                                    <li><a href="{{route('preference')}}"
                                            class="{{ Request::is('preference') ? 'active' : '' }}">Preference</a></li>
                                    <li><a href="{{route('appearance')}}"
                                            class="{{ Request::is('appearance') ? 'active' : '' }}">Appearance</a></li>
                                    <li><a href="{{route('social-authentication')}}"
                                            class="{{ Request::is('social-authentication') ? 'active' : '' }}">Social
                                            Authentication</a></li>
                                    <li><a href="{{route('language-settings')}}"
                                            class="{{ Request::is('language-settings','language-settings-web') ? 'active' : '' }}">Language</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('invoice-settings', 'invoice-templates', 'printer-settings', 'pos-settings', 'signatures', 'custom-fields') ? 'active subdrop' : '' }}"><span>App
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('invoice-settings', 'invoice-templates') ? 'active subdrop' : '' }}">Invoice<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('invoice-settings')}}"
                                                    class="{{ Request::is('invoice-settings') ? 'active' : '' }}">Invoice
                                                    Settings</a></li>
                                            <li><a href="{{route('invoice-templates')}}"
                                                    class="{{ Request::is('invoice-templates') ? 'active' : '' }}">Invoice
                                                    Template</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('printer-settings')}}"
                                            class="{{ Request::is('printer-settings') ? 'active' : '' }}">Printer</a>
                                    </li>
                                    <li><a href="{{route('pos-settings')}}"
                                            class="{{ Request::is('pos-settings') ? 'active' : '' }}">POS</a></li>
                                    <li><a href="{{route('signatures')}}"
                                            class="{{ Request::is('signatures') ? 'active' : '' }}">Signatures</a></li>
                                    <li><a href="{{route('custom-fields')}}"
                                            class="{{ Request::is('custom-fields') ? 'active' : '' }}">Custom Fields</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('email-settings', 'email-templates','sms-settings', 'sms-templates', 'otp-settings' , 'gdpr-settings'  ) ? 'active subdrop' : '' }}"><span>System
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('email-settings', 'email-templates') ? 'active subdrop' : '' }}">Email<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('email-settings')}}"
                                                    class="{{ Request::is('email-settings') ? 'active' : '' }}">Email
                                                    Settings</a></li>
                                            <li><a href="{{route('email-templates')}}"
                                                    class="{{ Request::is('email-templates') ? 'active' : '' }}">Email
                                                    Template</a></li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);"
                                            class="{{ Request::is('sms-settings', 'sms-templates') ? 'active subdrop' : '' }}">SMS<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('sms-settings')}}"
                                                    class="{{ Request::is('sms-settings') ? 'active' : '' }}">SMS
                                                    Settings</a></li>
                                            <li><a href="{{route('sms-templates')}}"
                                                    class="{{ Request::is('sms-templates') ? 'active' : '' }}">SMS
                                                    Template</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('otp-settings')}}"
                                            class="{{ Request::is('otp-settings') ? 'active' : '' }}">OTP</a></li>
                                    <li><a href="{{route('gdpr-settings')}}"
                                            class="{{ Request::is('gdpr-settings') ? 'active' : '' }}">GDPR Cookies</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('payment-gateway-settings', 'bank-settings-grid' ,'bank-settings-list', 'tax-rates', 'currency-settings') ? 'active subdrop' : '' }}"><span>Financial
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('payment-gateway-settings')}}"
                                            class="{{ Request::is('payment-gateway-settings') ? 'active' : '' }}">Payment
                                            Gateway</a></li>
                                    <li><a href="{{route('bank-settings-grid')}}"
                                            class="{{ Request::is('bank-settings-grid','bank-settings-list') ? 'active' : '' }}">Bank
                                            Accounts</a></li>
                                    <li><a href="{{route('tax-rates')}}"
                                            class="{{ Request::is('tax-rates') ? 'active' : '' }}">Tax Rates</a></li>
                                    <li><a href="{{route('currency-settings')}}"
                                            class="{{ Request::is('currency-settings') ? 'active' : '' }}">Currencies</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('storage-settings', 'ban-ip-address') ? 'active subdrop' : '' }}"><span>Other
                                        Settings</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('storage-settings')}}"
                                            class="{{ Request::is('storage-settings') ? 'active' : '' }}">Storage</a>
                                    </li>
                                    <li><a href="{{route('ban-ip-address')}}"
                                            class="{{ Request::is('ban-ip-address') ? 'active' : '' }}">Ban IP
                                            Address</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{route('signin')}}"
                                    class="{{ Request::is('signin') ? 'active' : '' }}"><span>Logout</span> </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade {{ Request::is('ui-alerts', 'ui-accordion', 'ui-avatar', 'ui-badges', 'ui-borders', 'ui-buttons', 'ui-buttons-group', 'ui-breadcrumb', 'ui-cards', 'ui-carousel', 'ui-colors', 'ui-dropdowns', 'ui-grid', 'ui-images', 'ui-lightbox', 'ui-media', 'ui-modals', 'ui-offcanvas', 'ui-pagination', 'ui-popovers', 'ui-progress', 'ui-placeholders', 'ui-rangeslider', 'ui-spinner', 'ui-sweetalerts', 'ui-nav-tabs', 'ui-toasts', 'ui-tooltips', 'ui-typography', 'ui-video', 'ui-sortable', 'ui-swiperjs','ui-ribbon', 'ui-clipboard', 'ui-drag-drop', 'ui-rangeslider', 'ui-rating', 'ui-text-editor', 'ui-counter', 'ui-scrollbar', 'ui-stickynote', 'ui-timeline','chart-apex', 'chart-c3', 'chart-js', 'chart-morris', 'chart-flot', 'chart-peity','icon-fontawesome', 'icon-feather', 'icon-ionic', 'icon-material', 'icon-pe7', 'icon-simpleline', 'icon-themify', 'icon-weather', 'icon-typicon', 'icon-flag', 'icon-tabler', 'icon-bootstrap', 'icon-remix','form-basic-inputs', 'form-checkbox-radios', 'form-input-groups', 'form-grid-gutters', 'form-select', 'form-fileupload', 'form-mask','form-horizontal', 'form-vertical', 'form-floating-labels', 'form-mask', 'form-validation', 'form-select2', 'form-wizard', 'form-pickers','tables-basic', 'data-tables','maps-vector', 'maps-leaflet') ? 'active show' : '' }}"
                        id="ui-elements">
                        <ul>
                            <li class="menu-title"><span>Ui Interface</span></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('ui-alerts', 'ui-accordion', 'ui-avatar', 'ui-badges', 'ui-borders', 'ui-buttons', 'ui-buttons-group', 'ui-breadcrumb', 'ui-cards', 'ui-carousel', 'ui-colors', 'ui-dropdowns', 'ui-grid', 'ui-images', 'ui-lightbox', 'ui-media', 'ui-modals', 'ui-offcanvas', 'ui-pagination', 'ui-popovers', 'ui-progress', 'ui-placeholders', 'ui-rangeslider', 'ui-spinner', 'ui-sweetalerts', 'ui-nav-tabs', 'ui-toasts', 'ui-tooltips', 'ui-typography', 'ui-video', 'ui-sortable', 'ui-swiperjs') ? 'active subdrop' : '' }}"><span>Base
                                        UI</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('ui-alerts')}}"
                                            class="{{ Request::is('ui-alerts') ? 'active' : '' }}">Alerts</a></li>
                                    <li><a href="{{route('ui-accordion')}}"
                                            class="{{ Request::is('ui-accordion') ? 'active' : '' }}">Accordion</a></li>
                                    <li><a href="{{route('ui-avatar')}}"
                                            class="{{ Request::is('ui-avatar') ? 'active' : '' }}">Avatar</a></li>
                                    <li><a href="{{route('ui-badges')}}"
                                            class="{{ Request::is('ui-badges') ? 'active' : '' }}">Badges</a></li>
                                    <li><a href="{{route('ui-borders')}}"
                                            class="{{ Request::is('ui-borders') ? 'active' : '' }}">Border</a></li>
                                    <li><a href="{{route('ui-buttons')}}"
                                            class="{{ Request::is('ui-buttons') ? 'active' : '' }}">Buttons</a></li>
                                    <li><a href="{{route('ui-buttons-group')}}"
                                            class="{{ Request::is('ui-buttons-group') ? 'active' : '' }}">Button
                                            Group</a></li>
                                    <li><a href="{{route('ui-breadcrumb')}}"
                                            class="{{ Request::is('ui-breadcrumb') ? 'active' : '' }}">Breadcrumb</a>
                                    </li>
                                    <li><a href="{{route('ui-cards')}}"
                                            class="{{ Request::is('ui-cards') ? 'active' : '' }}">Card</a></li>
                                    <li><a href="{{route('ui-carousel')}}"
                                            class="{{ Request::is('ui-carousel') ? 'active' : '' }}">Carousel</a></li>
                                    <li><a href="{{route('ui-colors')}}"
                                            class="{{ Request::is('ui-colors') ? 'active' : '' }}">Colors</a></li>
                                    <li><a href="{{route('ui-dropdowns')}}"
                                            class="{{ Request::is('ui-dropdowns') ? 'active' : '' }}">Dropdowns</a></li>
                                    <li><a href="{{route('ui-grid')}}"
                                            class="{{ Request::is('ui-grid') ? 'active' : '' }}">Grid</a></li>
                                    <li><a href="{{route('ui-images')}}"
                                            class="{{ Request::is('ui-images') ? 'active' : '' }}">Images</a></li>
                                    <li><a href="{{route('ui-lightbox')}}"
                                            class="{{ Request::is('ui-lightbox') ? 'active' : '' }}">Lightbox</a></li>
                                    <li><a href="{{route('ui-media')}}"
                                            class="{{ Request::is('ui-media') ? 'active' : '' }}">Media</a></li>
                                    <li><a href="{{route('ui-modals')}}"
                                            class="{{ Request::is('ui-modals') ? 'active' : '' }}">Modals</a></li>
                                    <li><a href="{{route('ui-offcanvas')}}"
                                            class="{{ Request::is('ui-offcanvas') ? 'active' : '' }}">Offcanvas</a></li>
                                    <li><a href="{{route('ui-pagination')}}"
                                            class="{{ Request::is('ui-pagination') ? 'active' : '' }}">Pagination</a>
                                    </li>
                                    <li><a href="{{route('ui-popovers')}}"
                                            class="{{ Request::is('ui-popovers') ? 'active' : '' }}">Popovers</a></li>
                                    <li><a href="{{route('ui-progress')}}"
                                            class="{{ Request::is('ui-progress') ? 'active' : '' }}">Progress</a></li>
                                    <li><a href="{{route('ui-placeholders')}}"
                                            class="{{ Request::is('ui-placeholders') ? 'active' : '' }}">Placeholders</a>
                                    </li>
                                    <li><a href="{{route('ui-rangeslider')}}"
                                            class="{{ Request::is('ui-rangeslider') ? 'active' : '' }}">Range Slider</a>
                                    </li>
                                    <li><a href="{{route('ui-spinner')}}"
                                            class="{{ Request::is('ui-spinner') ? 'active' : '' }}">Spinner</a></li>
                                    <li><a href="{{route('ui-sweetalerts')}}"
                                            class="{{ Request::is('ui-sweetalerts') ? 'active' : '' }}">Sweet Alerts</a>
                                    </li>
                                    <li><a href="{{route('ui-nav-tabs')}}"
                                            class="{{ Request::is('ui-nav-tabs') ? 'active' : '' }}">Tabs</a></li>
                                    <li><a href="{{route('ui-toasts')}}"
                                            class="{{ Request::is('ui-toasts') ? 'active' : '' }}">Toasts</a></li>
                                    <li><a href="{{route('ui-tooltips')}}"
                                            class="{{ Request::is('ui-tooltips') ? 'active' : '' }}">Tooltips</a></li>
                                    <li><a href="{{route('ui-typography')}}"
                                            class="{{ Request::is('ui-typography') ? 'active' : '' }}">Typography</a>
                                    </li>
                                    <li><a href="{{route('ui-video')}}"
                                            class="{{ Request::is('ui-video') ? 'active' : '' }}">Video</a></li>
                                    <li><a href="{{route('ui-sortable')}}"
                                            class="{{ Request::is('ui-sortable') ? 'active' : '' }}">Sortable</a></li>
                                    <li><a href="{{route('ui-swiperjs')}}"
                                            class="{{ Request::is('ui-swiperjs') ? 'active' : '' }}">Swiperjs</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('ui-ribbon', 'ui-clipboard', 'ui-drag-drop', 'ui-rangeslider', 'ui-rating', 'ui-text-editor', 'ui-counter', 'ui-scrollbar', 'ui-stickynote', 'ui-timeline') ? 'active subdrop' : '' }}"><span>Advanced
                                        UI</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('ui-ribbon')}}"
                                            class="{{ Request::is('ui-ribbon') ? 'active' : '' }}">Ribbon</a></li>
                                    <li><a href="{{route('ui-clipboard')}}"
                                            class="{{ Request::is('ui-clipboard') ? 'active' : '' }}">Clipboard</a></li>
                                    <li><a href="{{route('ui-drag-drop')}}"
                                            class="{{ Request::is('ui-drag-drop') ? 'active' : '' }}">Drag & Drop</a>
                                    </li>
                                    <li><a href="{{route('ui-rangeslider')}}"
                                            class="{{ Request::is('ui-rangeslider') ? 'active' : '' }}">Range Slider</a>
                                    </li>
                                    <li><a href="{{route('ui-rating')}}"
                                            class="{{ Request::is('ui-rating') ? 'active' : '' }}">Rating</a></li>
                                    <li><a href="{{route('ui-text-editor')}}"
                                            class="{{ Request::is('ui-text-editor') ? 'active' : '' }}">Text Editor</a>
                                    </li>
                                    <li><a href="{{route('ui-counter')}}"
                                            class="{{ Request::is('ui-counter') ? 'active' : '' }}">Counter</a></li>
                                    <li><a href="{{route('ui-scrollbar')}}"
                                            class="{{ Request::is('ui-scrollbar') ? 'active' : '' }}">Scrollbar</a></li>
                                    <li><a href="{{route('ui-stickynote')}}"
                                            class="{{ Request::is('ui-stickynote') ? 'active' : '' }}">Sticky Note</a>
                                    </li>
                                    <li><a href="{{route('ui-timeline')}}"
                                            class="{{ Request::is('ui-timeline') ? 'active' : '' }}">Timeline</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('chart-apex', 'chart-c3', 'chart-js', 'chart-morris', 'chart-flot', 'chart-peity') ? 'active subdrop' : '' }}"><span>Charts</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('chart-apex')}}"
                                            class="{{ Request::is('chart-apex') ? 'active' : '' }}">Apex Charts</a></li>
                                    <li><a href="{{route('chart-c3')}}"
                                            class="{{ Request::is('chart-c3') ? 'active' : '' }}">Chart C3</a></li>
                                    <li><a href="{{route('chart-js')}}"
                                            class="{{ Request::is('chart-js') ? 'active' : '' }}">Chart Js</a></li>
                                    <li><a href="{{route('chart-morris')}}"
                                            class="{{ Request::is('chart-morris') ? 'active' : '' }}">Morris Charts</a>
                                    </li>
                                    <li><a href="{{route('chart-flot')}}"
                                            class="{{ Request::is('chart-flot') ? 'active' : '' }}">Flot Charts</a></li>
                                    <li><a href="{{route('chart-peity')}}"
                                            class="{{ Request::is('chart-peity') ? 'active' : '' }}">Peity Charts</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('icon-fontawesome', 'icon-feather', 'icon-ionic', 'icon-material', 'icon-pe7', 'icon-simpleline', 'icon-themify', 'icon-weather', 'icon-typicon', 'icon-flag', 'icon-tabler', 'icon-bootstrap', 'icon-remix') ? 'active subdrop' : '' }}"><span>Primary
                                        Icons</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('icon-fontawesome')}}"
                                            class="{{ Request::is('icon-fontawesome') ? 'active' : '' }}">Fontawesome
                                            Icons</a></li>
                                    <li><a href="{{route('icon-feather')}}"
                                            class="{{ Request::is('icon-feather') ? 'active' : '' }}">Feather Icons</a>
                                    </li>
                                    <li><a href="{{route('icon-ionic')}}"
                                            class="{{ Request::is('icon-ionic') ? 'active' : '' }}">Ionic Icons</a></li>
                                    <li><a href="{{route('icon-material')}}"
                                            class="{{ Request::is('icon-material') ? 'active' : '' }}">Material
                                            Icons</a></li>
                                    <li><a href="{{route('icon-pe7')}}"
                                            class="{{ Request::is('icon-pe7') ? 'active' : '' }}">Pe7 Icons</a></li>
                                    <li><a href="{{route('icon-simpleline')}}"
                                            class="{{ Request::is('icon-simpleline') ? 'active' : '' }}">Simpleline
                                            Icons</a></li>
                                    <li><a href="{{route('icon-themify')}}"
                                            class="{{ Request::is('icon-themify') ? 'active' : '' }}">Themify Icons</a>
                                    </li>
                                    <li><a href="{{route('icon-weather')}}"
                                            class="{{ Request::is('icon-weather') ? 'active' : '' }}">Weather Icons</a>
                                    </li>
                                    <li><a href="{{route('icon-typicon')}}"
                                            class="{{ Request::is('icon-typicon') ? 'active' : '' }}">Typicon Icons</a>
                                    </li>
                                    <li><a href="{{route('icon-flag')}}"
                                            class="{{ Request::is('icon-flag') ? 'active' : '' }}">Flag Icons</a></li>
                                    <li><a href="{{route('icon-tabler')}}"
                                            class="{{ Request::is('icon-tabler') ? 'active' : '' }}">Tabler Icons</a>
                                    </li>
                                    <li><a href="{{route('icon-bootstrap')}}"
                                            class="{{ Request::is('icon-bootstrap') ? 'active' : '' }}">Bootstrap
                                            Icons</a></li>
                                    <li><a href="{{route('icon-remix')}}"
                                            class="{{ Request::is('icon-remix') ? 'active' : '' }}">Remix Icons</a></li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('form-basic-inputs', 'form-checkbox-radios', 'form-input-groups', 'form-grid-gutters', 'form-select', 'form-fileupload', 'form-mask','form-horizontal', 'form-vertical', 'form-floating-labels', 'form-mask', 'form-validation', 'form-select2', 'form-wizard', 'form-pickers') ? 'active subdrop' : '' }}"><span>
                                        Forms</span><span class="menu-arrow"></span></a>
                                <ul>
                                    <li class="submenu submenu-two">
                                        <a href="javascript:void(0);"
                                            class="{{ Request::is('form-basic-inputs', 'form-checkbox-radios', 'form-input-groups', 'form-grid-gutters', 'form-select', 'form-fileupload', 'form-mask') ? 'active subdrop' : '' }}"><span>Form
                                                Elements</span><span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('form-basic-inputs')}}"
                                                    class="{{ Request::is('form-basic-inputs') ? 'active' : '' }}">Basic
                                                    Inputs</a></li>
                                            <li><a href="{{route('form-checkbox-radios')}}"
                                                    class="{{ Request::is('form-checkbox-radios') ? 'active' : '' }}">Checkbox
                                                    & Radios</a></li>
                                            <li><a href="{{route('form-input-groups')}}"
                                                    class="{{ Request::is('form-input-groups') ? 'active' : '' }}">Input
                                                    Groups</a></li>
                                            <li><a href="{{route('form-grid-gutters')}}"
                                                    class="{{ Request::is('form-grid-gutters') ? 'active' : '' }}">Grid
                                                    & Gutters</a></li>
                                            <li><a href="{{route('form-select')}}"
                                                    class="{{ Request::is('form-select') ? 'active' : '' }}">Form
                                                    Select</a></li>
                                            <li><a href="{{route('form-mask')}}"
                                                    class="{{ Request::is('form-mask') ? 'active' : '' }}">Input
                                                    Masks</a></li>
                                            <li><a href="{{route('form-fileupload')}}"
                                                    class="{{ Request::is('form-fileupload') ? 'active' : '' }}">File
                                                    Uploads</a></li>
                                        </ul>
                                    </li>
                                    <li class="submenu submenu-two">
                                        <a href="javascript:void(0);"
                                            class="{{ Request::is('form-horizontal', 'form-vertical', 'form-floating-labels') ? 'active subdrop' : '' }}"><span>
                                                Layouts</span><span class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="{{route('form-horizontal')}}"
                                                    class="{{ Request::is('form-horizontal') ? 'active' : '' }}">Horizontal
                                                    Form</a></li>
                                            <li><a href="{{route('form-vertical')}}"
                                                    class="{{ Request::is('form-vertical') ? 'active' : '' }}">Vertical
                                                    Form</a></li>
                                            <li><a href="{{route('form-floating-labels')}}"
                                                    class="{{ Request::is('form-floating-labels') ? 'active' : '' }}">Floating
                                                    Labels</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('form-validation')}}"
                                            class="{{ Request::is('form-validation') ? 'active' : '' }}">Form
                                            Validation</a></li>
                                    <li><a href="{{route('form-select2')}}"
                                            class="{{ Request::is('form-select2') ? 'active' : '' }}">Select2</a></li>
                                    <li><a href="{{route('form-wizard')}}"
                                            class="{{ Request::is('form-wizard') ? 'active' : '' }}">Form Wizard</a>
                                    </li>
                                    <li><a href="{{route('form-pickers')}}"
                                            class="{{ Request::is('form-pickers') ? 'active' : '' }}">Form Picker</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('tables-basic', 'data-tables') ? 'active subdrop' : '' }}"><span>Tables</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('tables-basic')}}"
                                            class="{{ Request::is('tables-basic') ? 'active' : '' }}">Basic Tables </a>
                                    </li>
                                    <li><a href="{{route('data-tables')}}"
                                            class="{{ Request::is('data-tables') ? 'active' : '' }}">Data Table </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                    class="{{ Request::is('maps-vector', 'maps-leaflet') ? 'active subdrop' : '' }}"><span>Maps</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="{{route('maps-vector')}}"
                                            class="{{ Request::is('maps-vector') ? 'active' : '' }}">Vector</a></li>
                                    <li><a href="{{route('maps-leaflet')}}"
                                            class="{{ Request::is('maps-leaflet') ? 'active' : '' }}">Leaflet</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="extras">
                        <ul>
                            <li class="menu-title"><span>Help</span></li>
                            <li><a href="https://dreamspos.dreamstechnologies.com/documentation/laravel.html"
                                    target="_blank"><span>Documentation</span></a></li>
                            <li><a href="https://dreamspos.dreamstechnologies.com/documentation/changelog.html"
                                    target="_blank"><span>Changelog v2.2.5</span></a></li>
                            <li class="submenu">
                                <a href="javascript:void(0);"><span>Multi Level</span><span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    <li><a href="javascript:void(0);">Level 1.1</a></li>
                                    <li class="submenu submenu-two"><a href="javascript:void(0);">Level 1.2<span
                                                class="menu-arrow inside-submenu"></span></a>
                                        <ul>
                                            <li><a href="javascript:void(0);">Level 2.1</a></li>
                                            <li class="submenu submenu-two submenu-three"><a
                                                    href="javascript:void(0);">Level 2.2<span
                                                        class="menu-arrow inside-submenu inside-submenu-two"></span></a>
                                                <ul>
                                                    <li><a href="javascript:void(0);">Level 3.1</a></li>
                                                    <li><a href="javascript:void(0);">Level 3.2</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Two Col Sidebar -->
@endif