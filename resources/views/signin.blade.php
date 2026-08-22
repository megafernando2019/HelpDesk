<?php $page = 'signin'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="account-content">
        <div class="login-wrapper bg-img" style="background-position: top;">
            <div class="login-content authent-content" style="width: 30%;">
                <form action="{{url('index')}}">
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                            <img src="{{URL::asset('build/img/logo.svg')}}" alt="img">
                        </div>
                        <a href="{{url('index')}}" class="login-logo logo-white">
                            <img src="{{URL::asset('build/img/logo-white.svg')}}"  alt="Img">
                        </a>
                        <div class="login-userheading">
                            <h3>Ingresa</h3>
                            <h4 class="fs-16">Bienvenido a nuestra suite de aplicaciones.</h4>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo electrónico <span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <input type="text" value="" class="form-control border-end-0">
                                <span class="input-group-text border-start-0">
                                    <i class="ti ti-mail"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contraseña <span class="text-danger"> *</span></label>
                            <div class="pass-group">
                                <input type="password" class="pass-input form-control">
                                <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                            </div>
                        </div>
                        <div class="form-login authentication-check">
                            <div class="row">
                                <div class="col-12 d-flex align-items-center justify-content-between">
                                    <div class="text-end">
                                        ¿Has olvidado tu contraseña?
                                        <a class="text-orange fs-16 fw-medium" href="{{url('forgot-password')}}">Haz click aquí</a>
                                    </div>
                                </div>                                    
                            </div>
                        </div>
                        <div class="form-login">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                        
                        
                        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
                        <p>&copy; Mega Travel Operadora México 1999 - 2026 All rights reserved.</p>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ========================
        End Page Content
    ========================= -->

@endsection      
