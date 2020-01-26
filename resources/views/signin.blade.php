@extends('layout')

@section('meta_title', '')

@section('meta_description', '')

@section('head')

@endsection

@section('content')

  <!-- breadcrumb-area start -->
  <div class="breadcrumb-area bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Вход</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <!-- content-wraper start -->
  <div class="content-wraper">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 col-md-12 ml-auto mr-auto">
          <div class="login-register-wrapper">
            <!-- login-register-tab-list start -->
            <div class="login-register-tab-list nav">
              <a class="active" data-toggle="tab" href="#lg1">
                <h4>Вход</h4>
              </a>
              <a data-toggle="tab" href="#lg2">
                <h4>Регистрация</h4>
              </a>
            </div>
            <div class="tab-content">
              <div id="lg1" class="tab-pane active">
                <div class="login-form-container">
                  <div class="login-register-form">
                    <form method="POST" action="/login-cs">
                      @csrf
                      <div class="login-input-box">
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email *" required>
                        <input type="password" name="password" id="password" minlength="2" required>
                      </div>
                      <div class="button-box">
                        <!-- <div class="login-toggle-btn">
                          <input type="checkbox">
                          <label>Remember me</label>
                          <a href="#">Forgot Password?</a>
                        </div> -->
                        <div class="button-box">
                          <button class="login-btn btn" type="submit"><span>Войти</span></button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div id="lg2" class="tab-pane">
                <div class="login-form-container">
                  <div class="login-register-form">
                    <form method="POST" action="/register-cs">
                      @csrf
                      <div class="login-input-box">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" minlength="2" maxlength="40" placeholder="Имя *" required>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email *" required>
                        <input type="password" name="password" id="password" minlength="2" required>
                      </div>
                      <div class="button-box">
                        <button class="register-btn btn" type="submit"><span>Регистрация</span></button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

@endsection