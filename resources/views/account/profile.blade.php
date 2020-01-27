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
              <div class="col-md-12 col-lg-10">
                <h3>Информация</h3>
                <dl class="row">
                  <dt class="col-sm-3">Имя</dt>
                  <dd class="col-sm-9">{{ $user->surname . ' ' . $user->name }}</dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Email</dt>
                  <dd class="col-sm-9">{{ $user->email }}</dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Номер телефона</dt>
                  <dd class="col-sm-9">{{ $user->profile->phone }}</dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Обо мне</dt>
                  <dd class="col-sm-9">{{ $user->profile->about }}</dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Город</dt>
                  <dd class="col-sm-9">{{ $user->profile->city->title }}</dd>
                </dl>
                <dl class="row">
                  <dt class="col-sm-3">Пол</dt>
                  <dd class="col-sm-9">{{ ($user->profile->sex == "woman") ? 'Женщина' : 'Мужчина' }}</dd>
                </dl>
                <a href="/profile/edit" class="btn">Редактировать</a>
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