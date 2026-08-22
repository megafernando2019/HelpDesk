@if (!Route::is(['under-maintenance', 'coming-soon', 'error-404', 'error-500','two-step-verification-3','two-step-verification-2','two-step-verification','email-verification-3','email-verification-2','email-verification','reset-password-3','reset-password-2','reset-password','forgot-password-3','forgot-password-2','forgot-password','register-3','register-2','register','signin-3','signin-2','signin','success','success-2','success-3','layout-horizontal','layout-hovered','layout-boxed','layout-rtl','pos','pos-2','pos-3','pos-4','pos-5']))
    <body>
@endif

@if (Route::is(['layout-horizontal']))
    <body class="menu-horizontal">
@endif

@if (Route::is(['layout-hovered']))
    <body class="mini-sidebar expand-menu">
@endif

@if (Route::is(['layout-boxed']))
    <body class="mini-sidebar layout-box-mode">
@endif

@if (Route::is(['layout-rtl']))
    <body class="layout-mode-rtl">
@endif

@if (Route::is(['under-maintenance', 'coming-soon', 'error-404', 'error-500']))
    <body class="error-page">
@endif

@if (Route::is(['two-step-verification', 'email-verification', 'reset-password', 'forgot-password', 'register-2', 'register', 'signin', 'success']))
    <body class="account-page">
@endif

@if (Route::is(['two-step-verification-3', 'two-step-verification-2', 'success-2', 'success-3', 'signin-3', 'signin-2', 'reset-password-3', 'reset-password-2', 'forgot-password-3', 'forgot-password-2', 'email-verification-3', 'email-verification-2', 'register-3']))
    <body class="account-page bg-white">
@endif

@if (Route::is(['lock-screen']))
    <img src="{{URL::asset('build/img/bg/lock-screen-bg.png')}}" alt="bg" class="lock-screen-bg position-absolute img-fluid d-sm-none d-md-none d-lg-flex">
@endif

@if (Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
    <body class="pos-page">
@endif