	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{URL::asset('build/img/favicon.png')}}">

	<!-- Apple Touch Icon -->
	<link rel="apple-touch-icon" sizes="180x180" href="{{URL::asset('build/img/apple-touch-icon.png')}}">

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'layout-horizontal', 'layout-detached', 'layout-modern', 'layout-two-column', 'layout-hovered', 'layout-boxed', 'layout-dark', 'layout-rtl', 'success', 'success-2', 'success-3']))
    <!-- Theme Script JS -->
    <script src="{{URL::asset('build/js/theme-script.js')}}"></script>
@endif

@if (!Route::is(['layout-rtl']))     
    <!-- Bootstrap CSS -->
    <link rel = 'stylesheet' href ="{{URL::asset('build/css/bootstrap.min.css')}}">
@endif 

@if (Route::is(['layout-rtl']))     
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/bootstrap.rtl.min.css')}}">
@endif  

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'success', 'success-2', 'success-3']))     
    <!-- animation CSS -->
    <link rel = 'stylesheet' href="{{URL::asset('build/css/animate.css')}}">
@endif 

    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/tabler-icons/tabler-icons.min.css')}}">

    <!-- Fontawesome CSS -->
    <link rel = 'stylesheet' href = "{{URL::asset('build/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel = 'stylesheet' href = "{{URL::asset('build/plugins/fontawesome/css/all.min.css')}}">

@if (Route::is(['add-product', 'audio-call', 'edit-product', 'domain', 'form-vertical', 'packages', 'product-list', 'purchase-transaction', 'reviews', 'subscription', 'tables-basic', 'ui-alerts', 'ui-nav-tabs', 'video-call']))     
    <!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/feather.css')}}">
@endif  

@if (Route::is(['icon-feather', 'icon-ionic']))     
<!-- Feathericon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/feather/feather.css')}}">
@endif

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'success', 'success-2', 'success-3']))     
    <!-- Datatable CSS -->
    <link rel = 'stylesheet' href="{{URL::asset('build/css/dataTables.bootstrap5.min.css')}}">

    <!-- Quill CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/quill/quill.snow.css')}}">
@endif

@if (Route::is(['icon-tabler', 'projects']))     
    <!-- Tabler Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/tabler-icons/tabler-icons.css')}}">
@endif
         
@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'success', 'success-2', 'success-3']))     
    <!-- Datetimepicker CSS -->
    <link rel = 'stylesheet' href = "{{URL::asset('build/css/bootstrap-datetimepicker.min.css')}}">
@endif

@if (Route::is(['audio-call', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5', 'product-details', 'video-call']))     
    <link rel = 'stylesheet' href = "{{URL::asset('build/plugins/owlcarousel/owl.carousel.min.css')}}">
    <link rel = 'stylesheet' href = "{{URL::asset('build/plugins/owlcarousel/owl.theme.default.min.css')}}">
@endif  

@if (Route::is(['barcode', 'file-manager', 'notes', 'plugin', 'qrcode', 'social-feed', 'todo-list', 'todo']))     
    <!-- Owl Carousel CSS -->
    <link rel = "stylesheet" href="{{URL::asset('build/css/owl.carousel.min.css')}}">
@endif  

@if (Route::is(['file-manager']))     
    <!-- Player CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/plyr.css')}}">
@endif

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'success', 'success-2', 'success-3']))     
    <!-- Select2 CSS -->
    <link rel = 'stylesheet' href="{{URL::asset('build/plugins/select2/css/select2.min.css')}}">
@endif

@if (Route::is(['icon-flag']))     
    <!-- Flag Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/flags/flags.css')}}">
@endif

@if (Route::is(['icon-ionic']))     
	<!-- Ionic CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/ionic/ionicons.css')}}">
@endif    

@if (Route::is(['icon-material']))     
    <!-- Material CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/material/materialdesignicons.css')}}">
@endif 

@if (Route::is(['icon-pe7']))     
    <!-- Pe7 CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/pe7/pe-icon-7.css')}}">       
@endif 

@if (Route::is(['icon-simpleline']))     
    <!-- Simpleline Icons CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/simpleline/simple-line-icons.css')}}">
@endif   

@if (Route::is(['icon-themify']))     
    <!-- Themify Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/themify/themify.css')}}">
@endif 

@if (Route::is(['icon-typicon']))     
    <!-- Typicon icons CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/typicons/typicons.css')}}">
@endif 

@if (Route::is(['icon-weather']))     
    <!-- Weather CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/weather/weathericons.css')}}">
@endif   

@if (Route::is(['form-wizard']))     
    <!-- Wizard CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/twitter-bootstrap-wizard/form-wizard.css')}}">
@endif

@if (Route::is(['audio-call', 'call-history', 'chat', 'video-call']))     
    <!-- Boxicons CSS -->
    <link rel = 'stylesheet' href="{{URL::asset('build/plugins/boxicons/css/boxicons.min.css')}}">
@endif

@if (Route::is(['billers', 'blog-comments', 'chat', 'contacts', 'customers', 'expired-products', 'security-settings', 'warehouse', 'form-mask']))     
    <!-- Mobile CSS-->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/intlTelInput.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/intltelinput/css/demo.css')}}">
@endif

@if (Route::is(['add-product', 'all-blog', 'blog-tag', 'domain', 'edit-product', 'email-reply', 'localization-settings', 'otp-settings', 'packages', 'product-list', 'purchase-transaction', 'reviews', 'subscription', 'varriant-attributes']))     
    <!-- Bootstrap Tagsinput CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')}}">
@endif

@if (Route::is(['dashboard', 'sales-dashboard']))     
    <!-- Map CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/jvectormap/jquery-jvectormap-2.0.5.css')}}">
@endif

@if (Route::is(['all-blog', 'blog-categories', 'blog-tag', 'best-seller', 'calendar', 'companies', 'customer-due-report', 'customer-report', 'dashboard', 'expense-report', 'form-pickers', 'income-report', 'income', 'index', 'inventory-report', 'invoice-report', 'layout-boxed', 'layout-dark', 'layout-detached', 'layout-rtl', 'layout-horizontal', 'layout-two-column', 'layout-hovered', 'notes', 'pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5', 'product-expiry-report', 'product-quantity-alert', 'product-report', 'profit-and-loss', 'projects', 'purchase-report', 'sales-dashboard', 'sales-report', 'sales-tax', 'search-list', 'sold-stock', 'stock-history', 'supplier-due-report', 'supplier-report', 'tax-reports', 'todo-list', 'todo']))     
    <!-- Daterangepikcer CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/daterangepicker/daterangepicker.css')}}">
@endif

@if (Route::is(['ui-rangeslider', 'ui-ratings']))     
    <!-- Rangeslider CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/ion-rangeslider/css/ion.rangeSlider.min.css')}}">
@endif

@if (Route::is(['ui-drag-drop', 'ui-clipboard', 'ui-sortable']))     
    <!-- Dragula CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/dragula/css/dragula.min.css')}}">
@endif

@if (Route::is(['ui-lightbox']))     
    <!-- Lightbox CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/lightbox/glightbox.min.css')}}">
@endif

@if (Route::is(['ui-scrollbar']))     
    <!-- Scrollbar CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/scrollbar/scroll.min.css')}}">
@endif

@if (Route::is(['ui-toasts']))     
    <!-- Toatr CSS -->		
    <link rel="stylesheet" href="{{URL::asset('build/plugins/toastr/toatr.css')}}">
@endif

@if (Route::is(['ui-swiperjs', 'chat', 'video-call']))     
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/swiper/swiper-bundle.min.css')}}">
@endif

@if (Route::is(['ui-stickynote', 'ui-timeline']))     
    <!-- Sticky CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/stickynote/sticky.css')}}">
@endif

@if (Route::is(['icon-bootstrap']))     
    <!-- Bootstrap Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/bootstrap/bootstrap-icons.min.css')}}">
@endif

@if (Route::is(['icon-remix']))     
    <!-- Remix Icon CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/icons/remix/fonts/remixicon.css')}}">
@endif

@if (Route::is(['form-pickers']))     
    <!-- Form Date PIckers CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/flatpickr/flatpickr.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/bootstrap-datepicker/bootstrap-datepicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/jquery-timepicker/jquery-timepicker.css')}}">
    <link rel="stylesheet" href="{{URL::asset('build/plugins/pickr/pickr-themes.css')}}">
@endif

@if (Route::is(['maps-vector']))     
    <!-- Jsvector Maps -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/jsvectormap/css/jsvectormap.min.css')}}">
@endif

@if (Route::is(['maps-leaflet']))     
    <!-- Leaflet Maps CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/leaflet/leaflet.css')}}">
@endif

@if (Route::is(['chat', 'email-reply', 'social-feed', 'search-list']))     
    <!-- Fancybox -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/fancybox/jquery.fancybox.min.css')}}">
@endif

@if (!Route::is(['signin', 'signin-2', 'signin-3', 'register', 'register-2', 'register-3', 'forgot-password', 'forgot-password-2', 'forgot-password-3', 'reset-password', 'reset-password-2', 'reset-password-3', 'email-verification', 'email-verification-2', 'email-verification-3', 'two-step-verification', 'two-step-verification-2', 'two-step-verification-3', 'lock-screen', 'error-404', 'error-500', 'coming-soon', 'under-maintenance', 'success', 'success-2', 'success-3']))     
    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{URL::asset('build/plugins/@simonwep/pickr/themes/nano.min.css')}}">
@endif

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{URL::asset('build/css/style.css')}}">

@vite('resources/css/app.css')
