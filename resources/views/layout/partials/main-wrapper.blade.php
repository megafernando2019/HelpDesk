@if (Route::is(['lock-screen']))
    <div class="main-wrapper login-body">
@elseif (Route::is(['pos']))
    <div class="main-wrapper pos-five">
@elseif (Route::is(['pos-3']))
    <div class="main-wrapper pos-two">
@elseif (Route::is(['pos-4']))
    <div class="main-wrapper pos-three">
@elseif (Route::is(['pos-5']))
    <div class="main-wrapper pos-three pos-four">
@else
    <div class="main-wrapper">
@endif