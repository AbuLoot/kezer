@extends('layout')

@section('meta_title', '')

@section('meta_description', '')

@section('head')

@endsection

@section('content')

  <div class="breadcrumb-area bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Мой аккаунт</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="content-wraper">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="account-dashboard">
            <div class="row">
              <div class="col-md-12 col-lg-2">
                <ul class="nav flex-column dashboard-list">
                  <li><a href="#" class="nav-link"><b>Мой аккаунт</b></a></li>
                  <li> <a href="/orders" class="nav-link">Заказы</a></li>
                  <li>
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul>
              </div>
              <div class="col-md-8 col-lg-8">
                <h3>Редактировать</h3>
                <form action="/profile" method="post">
                  {!! csrf_field() !!}
                  <div class="account-input-box">
                    <div class="row">
                      <div class="col-sm-6">
                        <label><b>Имя</b></label>
                        <input type="text" name="name" value="{{ (old('name')) ? old('name') : $user->name }}" minlength="2" maxlength="40" placeholder="Имя *" required>
                      </div>
                      <div class="col-sm-6">
                        <label><b>Фамилия</b></label>
                        <input type="text" name="surname" value="{{ (old('surname')) ? old('surname') : $user->surname }}" minlength="2" maxlength="40" placeholder="Имя *" required>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <label><b>Email</b></label>
                        <input type="email" name="email" value="{{ (old('email')) ? old('email') : $user->email }}" placeholder="Email *" required>
                      </div>
                      <div class="col-sm-6">
                        <label><b>Номер телефона</b></label>
                        <input type="tel" name="phone" id="phone" placeholder="Номер телефона" value="{{ (old('phone')) ? old('phone') : $user->profile->phone }}" minlength="5" maxlength="20" required>                        
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <label><b>Страна / город</b></label>
                        <div class="nice-select wide">
                          <select id="city_id" name="city_id" required>
                            <option>Выберите регион...</option>
                            @foreach($countries as $country)
                              <optgroup label="{{ $country->title }}">
                                @foreach($country->cities as $city)
                                  @if ($city->id == $user->profile->city_id)
                                    <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                                  @else
                                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                                  @endif
                                @endforeach
                              </optgroup>
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <label><b>Обо мне</b></label>
                        <p class="single-form-row">
                          <textarea name="about" placeholder="Дополнительная информация..." class="data_1" rows="2" cols="5">{{ $user->profile->about }}</textarea>
                        </p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <label><b>Новый пароль</b></label>
                        <input type="password" name="password" id="password" minlength="6" maxlength="60" placeholder="Придумайте пароль">
                      </div>
                      <div class="col-sm-6">
                        <label><b>Введите пароль повторно</b></label>
                        <input type="password" name="password_confirmation" id="password-confirm" minlength="6" maxlength="60" placeholder="Введите пароль повторно">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <label><b>Пол</b></label>
                        <div class="input-radio">
                          <span class="custom-radio"><input type="radio" value="man" name="sex" <?php if ($user->profile->sex == "man") echo 'selected'; ?>> Мужчина</span>
                          <span class="custom-radio"><input type="radio" value="woman" name="sex" <?php if ($user->profile->sex == "woman") echo 'selected'; ?>> Женщина</span>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <label><b>Дата рождения</b></label>
                        <input type="date" name="birthday" placeholder="MM/DD/YYYY" value="{{ (old('birthday')) ? old('birthday') : $user->profile->birthday }}">
                      </div>
                    </div>
                  </div>
                  <div class="button-box">
                    <button class="btn default-btn" type="submit">Сохранить</button>
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

@endsection