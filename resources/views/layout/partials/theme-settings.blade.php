@if (Route::is(['layout-horizontal']))
    <html lang="en" data-layout="horizontal">
@elseif (Route::is(['layout-detached']))
    <html lang="en" data-layout="detached">
@elseif (Route::is(['layout-modern']))
    <html lang="en" data-layout="modern">
@elseif (Route::is(['layout-two-column']))
    <html lang="en" data-layout="twocolumn">
@elseif (Route::is(['layout-hovered']))
    <html lang="en" data-layout="layout-hovered">
@elseif (Route::is(['layout-boxed']))
    <html lang="en" data-layout="default" data-width="box">
@elseif (Route::is(['layout-rtl']))
    <html lang="en" data-layout-mode="light_mode">
@elseif (Route::is(['layout-dark']))
    <html lang="en" data-theme="dark">
@else
    <html lang="en">
@endif