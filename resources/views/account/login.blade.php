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

      @include('partials.alerts')

      <div class="row">
        <div class="col-lg-7 col-md-12 ml-auto mr-auto">
          <div class="login-register-wrapper">
            <!-- login-register-tab-list start -->
            <div class="login-register-tab-list nav">
              <a href="/cs-login" class="active">
                <h4>Вход</h4>
              </a>
              <a href="/cs-register">
                <h4>Регистрация</h4>
              </a>
            </div>
            <div class="login-form-container">
              <div class="login-register-form">
                <form method="POST" action="/cs-login">
                  @csrf
                  <div class="login-input-box">
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email *" required>
                    <input type="password" name="password" id="password" minlength="2" required>
                  </div>
                  <div class="button-box">
                    <div class="login-toggle-btn">
                      <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label for="remember">Запомнить меня</label>
                      <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    </div>
                    <div class="button-box">
                      <button class="login-btn btn" type="submit"><span>Войти</span></button>
                    </div>
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

@endsection


@section('scripts')

@endsection