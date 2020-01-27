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
            <li class="breadcrumb-item active">Регистрация</li>
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
              <a href="/cs-login">
                <h4>Вход</h4>
              </a>
              <a href="/cs-register" class="active">
                <h4>Регистрация</h4>
              </a>
            </div>
            <div class="login-form-container">
              <div class="login-register-form">
                <form method="POST" action="/cs-register">
                  @csrf
                  <div class="login-input-box">
                    <input type="text" name="name" value="{{ old('name') }}" minlength="2" maxlength="40" placeholder="Имя *" required>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Email *" required>
                    <input type="password" name="password" id="password" minlength="6" maxlength="60" placeholder="Придумайте пароль" required>
                    <input type="password" name="password_confirmation" id="password-confirm" minlength="6" maxlength="60" placeholder="Введите пароль повторно" required>
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

@endsection


@section('scripts')
  <script>
    window.onload = function () {
      document.getElementById("password").onchange = validatePassword;
      document.getElementById("password-confirm").onchange = validatePassword;
    }
    function validatePassword() {
      var pass1 = document.getElementById("password").value;
      var pass2 = document.getElementById("password-confirm").value;
      if (pass1 != pass2) {
        document.getElementById("password-confirm").setCustomValidity("Пароли не совпадают");
      } else {
        document.getElementById("password-confirm").setCustomValidity('');
        //empty string means no validation error
      }
    }
  </script>

@endsection