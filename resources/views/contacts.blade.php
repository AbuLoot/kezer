@extends('layout')

@section('meta_title', $page->meta_title)

@section('meta_description', $page->meta_description)

@section('head')

@endsection

@section('content')

  <div class="breadcrumb-area bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">{{ $page->title }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <?php
    $data_address = unserialize($contacts->data_1);
    $data_phones = unserialize($contacts->data_2);
    $data_email = unserialize($contacts->data_3);
    $phones = explode('/', $data_phones['value']);
  ?>
  <!-- content-wraper start -->
  <div class="content-wraper">
    <div class="container">
      @include('partials.alerts')

      <div class="row">
        <div class="col-lg-7 col-sm-12">
          <div class="contact-form">
            <div class="contact-form-info">
              <div class="contact-title">
                <h3 class="text-uppercase">Свяжитесь с нами</h3>
              </div>
              <form action="/send-app" method="POST">
                @csrf
                 <div class="contact-page-form">
                   <div class="contact-input">
                    <div class="contact-inner">
                      <input type="text" name="name" id="name" minlength="2" maxlength="40" autocomplete="off" placeholder="Ваше имя*" required>
                    </div>
                    <div class="contact-inner">
                      <input type="email" name="email" id="email" autocomplete="off" placeholder="Ваш e-mail*" required>
                    </div>
                    <div class="contact-inner">
                      <input type="tel" pattern="(\+?\d[- .]*){7,13}" name="phone" minlength="5" maxlength="20" placeholder="Введите номер телефона*" required>
                    </div>
                    <div class="contact-inner contact-message">
                      <textarea name="message" id="message" autocomplete="off" placeholder="Ваш текст*" required></textarea>
                    </div>
                  </div>
                  <div class="contact-submit-btn">
                    <button class="submit-btn" type="submit">Отправить сообщение</button>
                    <p class="form-messege"></p>
                  </div>
                 </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-5 col-sm-12">
          <div class="contact-infor">
            <div class="contact-title">
              <h3 class="text-uppercase">Наши контакты</h3>
            </div>
            <div class="contact-dec">
              {{ $page->content }}
            </div>
            <div class="contact-address">
              <ul>
                <li><i class="fa fa-home"></i> <span>{{ $data_address['value'] }}</span> </li>
                <li><i class="fa fa-envelope-o">&nbsp;</i> {{ $data_email['value'] }}</li>
                @foreach($phones as $phone)
                  <?php $href = str_replace(' ', '', $phone); ?>
                  <li><a href="tel:{{ $href }}"><i class="fa fa-phone"></i> <span>{{ $phone }}</span></a></li>
                @endforeach
              </ul>
            </div>
            <!-- <div class="work-hours">
              <h3><strong>Working hours</strong></h3>
              <p><strong>Monday &ndash; Saturday</strong>: &nbsp;08AM &ndash; 22PM</p>
            </div> -->
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

@endsection