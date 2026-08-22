<!DOCTYPE html>
@include('layout.partials.theme-settings')

<head>
    @include('layout.partials.title-meta')

    @include('layout.partials.head-css')
</head>

@include('layout.partials.body')

@component('components.loader')
@endcomponent

    <!-- Main Wrapper -->
    @include('layout.partials.main-wrapper')

        @if (!Route::is(['under-maintenance', 'coming-soon','error-404','error-500','two-step-verification-3','two-step-verification-2','two-step-verification','email-verification-3','email-verification-2','email-verification','reset-password-3','reset-password-2','reset-password','forgot-password-3','forgot-password-2','forgot-password','register-3','register-2','register','signin-3','signin-2','signin','success','success-2','success-3','lock-screen']))
            @include('layout.partials.topbar')
            @include('layout.partials.sidebar')
            @include('layout.partials.horizontal-sidebar')
            @include('layout.partials.twocolumn-sidebar')
        @endif

        @yield('content')

    </div>
    <!-- /Main Wrapper -->

@component('components.modalpopup')
@endcomponent

@include('layout.partials.vendor-scripts')

</body>
</html>
