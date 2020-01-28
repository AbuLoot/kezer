<!DOCTYPE html>
<html class="no-js" lang="ru">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>@yield('meta_title', 'Biotic - Продукты долголетия')</title>
  <meta name="description" content="@yield('meta_description', 'Biotic - Продукты долголетия')">
  <meta name="author" content="issayev.adilet@gmail.com">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.ico">
  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/assets/css/plugins.css">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link rel="stylesheet" href="/assets/css/custom.css">

  <link href="/bower_components/typeahead.js/dist/typeahead.bootstrap.css" rel="stylesheet">
  @yield('head')

  <script src="/assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
<?php
  $data_address = unserialize($contacts->data_1);
  $data_phones = unserialize($contacts->data_2);
  $data_email = unserialize($contacts->data_3);
  $phones = explode('/', $data_phones['value']);
?>
<div class="main-wrapper">
  <div class="header-area">
    <!-- header-top start -->
    <div class="header-top bg-black">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 order-2 order-lg-1 d-none d-sm-block">
            <div class="top-left-wrap">
              <ul class="phone-email-wrap">
                @foreach($phones as $phone)
                  <li><a href="tel:{{ $phone }}"><i class="fa fa-phone"></i> {{ $phone }}</a></li>
                @endforeach
                <li><a href="mailto:{{ $data_email['value'] }}"><i class="fa fa-envelope-open-o"></i> {{ $data_email['value'] }}</a></li>
              </ul>
              <ul class="link-top">
                {!! $contacts->content !!}
              </ul>
            </div>
          </div>
          <div class="col-lg-4 order-1 order-lg-2">
            <div class="top-selector-wrapper">
              <ul class="single-top-selector">
                <li class="setting-top list-inline-item">
                  @guest
                    <a href="/cs-login">Войти</a>
                  @else
                    <div class="btn-group">
                      <button class="dropdown-toggle"><i class="fa fa-user-circle-o"></i> {{ Auth::user()->name }} <i class="fa fa-angle-down"></i></button>
                      <div class="dropdown-menu">
                        <ul>
                          <li><a href="/profile">Мой аккаунт</a></li>
                          <li><a href="/orders">Мои заказы</a></li>
                          <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                              @csrf
                            </form>
                          </li>
                        </ul>
                      </div>
                    </div>
                  @endguest
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Header-bottom start -->
    <div class="header-bottom-area header-sticky">
      <div class="container">
        <div class="row custom-xs-row">
          <div class="col-lg-2 col-4">
            <!-- logo start -->
            <div class="logo">
              <a href="/"><img src="/assets/images/logo/logo.png" alt=""></a>
            </div>
          </div>
          <div class="col-lg-7 d-none d-lg-block">
            <!-- main-menu-area start -->
            <div class="main-menu-area">
              <nav class="main-navigation">
                <ul>
                  <?php $traverse = function ($categories, $parent_slug = NULL) use (&$traverse) { ?>
                    <?php foreach ($categories as $category) : ?>
                      <?php if ($category->isRoot() && $category->descendants->count() > 0) : ?>
                        <li>
                          <a href="/catalog/{{ $category->slug .'/'. $category->id }}" class="text-uppercase"><b>{{ $category->title }} <i class="fa fa-angle-down"></i></b></a>
                          <?php if ($category->descendants->count() > 10) : ?>
                            <ul class="mega-menu custom-menu-">
                              <?php $traverse($category->children, $category->slug.'/'); ?>
                            </ul>
                          <?php else : ?>
                            <ul class="sub-menu">
                              <?php $traverse($category->children, $category->slug.'/'); ?>
                            </ul>
                          <?php endif; ?>
                        </li>
                      <?php elseif ($category->descendants->count() >= 1) : ?>
                        <li>
                          <a href="/catalog/{{ $parent_slug . $category->slug .'/'. $category->id }}"><b>{{ $category->title }}</b></a>
                          <ul>
                            <?php $traverse($category->children, $category->slug.'/'); ?>
                          </ul>
                        </li>
                      <?php elseif ($category->ancestors->count() == 2) : ?>
                        <li><a href="/catalog/{{ $parent_slug . $category->slug .'/'. $category->id }}">{{ $category->title }}</a></li>
                      <?php else : ?>
                        <li><a href="/catalog/{{ $parent_slug . $category->slug .'/'. $category->id }}" class="text-uppercase"><b>{{ $category->title }}</b></a></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                  @guest
                    <li><a href="/cs-login" class="text-uppercase d-none d-sm-block d-md-none"><b>Войти</b></a></li>
                  @else
                    <li><a href="/profile" class="text-uppercase d-none d-sm-block d-md-none">Мой аккаунт</a></li>
                  @endguest
                </ul>
              </nav>
            </div>
          </div>
          <div class="col-lg-3 col-8">
            <div class="header-bottom-right">
              <div class="block-search">
                <div class="trigger-search"><i class="fa fa-search"></i> <span>Поиск</span></div>
                <div class="search-box main-search-active">
                  <form action="/search" method="get" class="search-box-inner">
                    <input type="search" name="text" class="typeahead-goods" data-provide="typeahead" placeholder="Поиск одежды...">
                    <button class="search-btn search-submit" type="submit"><i class="fa fa-search"></i></button>
                  </form>
                </div>
              </div>
              <div class="shoping-cart">
                <div class="btn-group">
                  <?php $items = session('items'); ?>
                  <!-- Mini Cart Button start -->
                  <a href="/cart" class="ml--15"><i class="fa fa-shopping-cart"></i> Корзина (<span id="count-items">{{ (is_array($items)) ? count($items['products_id']) : 0 }}</span>)</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <!-- mobile-menu start -->
            <div class="mobile-menu d-block d-lg-none"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  @yield('content')

  <!-- Footer Aare Start -->
  <footer class="footer-area mt--100">
    <!-- footer-top start -->
    <div class="footer-top pt--50 section-pb">
       <div class="container">
         <div class="row">
           <div class="col-lg-3 col-md-6">
            <!-- footer-info-area start -->
            <div class="footer-info-area">
              <div class="footer-logo">
                <a href="/"><img src="/assets/images/logo/logo-white.png" alt=""></a>
              </div>
              <div class="desc_footer">
                <p>Сіздің Туркиядағы сенімді серіктесіңіз</p>
                <p>Ваш надежный партнер в Турции</p>
              </div>
            </div>
           </div>
          <div class="col-lg-3 col-md-6">
            <!-- footer-info-area start -->
            <div class="footer-info-area">
              <div class="footer-title text-uppercase">
                <h3>Контакты</h3>
              </div>
              <div class="desc_footer">
                <p><i class="fa fa-home"></i> <span>{{ $data_address['value'] }}</span> </p>
                @foreach($phones as $phone)
                  <p><a href="tel:{{ $phone }}" class="text-white"><i class="fa fa-phone"></i> <span>{{ $phone }}</span></a></p>
                @endforeach
                <p><a href="mailto:{{ $data_email['key'] }}"><i class="fa fa-envelope-open-o"></i> {{ $data_email['value'] }}</a></p>
                <div class="link-follow-footer">
                  <ul class="footer-social-share">
                    {!! $contacts->content !!}
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6">
            <!-- footer-info-area start -->
            <div class="footer-info-area">
              <div class="footer-title text-uppercase">
                <h3>Страницы</h3>
              </div>
              <div class="desc_footer">
                <ul>
                  @foreach($pages as $page)
                    <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
         </div>
       </div>
    </div>

    <div class="footer-buttom">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-7">
            <div class="copy-right">
              <p>Kezer - все права зарезервированы {{ date('Y') }}</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-5">
            <p class="text-right text-white">Разработчик: <a href="mailto:issayev.adilet@gmail.com">issayev.adilet@gmail.com</a></p>
          </div>
        </div>
      </div>
    </div>
  </footer>

</div>

<!-- JS
============================================ -->

<script src="/assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="/assets/js/popper.min.js"></script>
<script src="/assets/js/bootstrap.min.js"></script>
<script src="/assets/js/plugins.js"></script>
<script src="/assets/js/ajax-mail.js"></script>
<script src="/assets/js/main.js"></script>

<script src="/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></script>
<!-- Typeahead Initialization -->
<script>
  jQuery(document).ready(function($) {
    // Set the Options for "Bloodhound" suggestion engine
    var engine = new Bloodhound({
      remote: {
        url: '/search-ajax?text=%QUERY%',
        wildcard: '%QUERY%'
      },
      datumTokenizer: Bloodhound.tokenizers.whitespace('text'),
      queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    $(".typeahead-goods").typeahead({
      hint: true,
      highlight: true,
      minLength: 2
    }, {
      limit: 10,
      source: engine.ttAdapter(),
      displayKey: 'title',

      templates: {
        empty: [
          '<li>&nbsp;&nbsp;&nbsp;Ничего не найдено.</li>'
        ],
        suggestion: function (data) {
          return '<li class="list-group-item"><a href="/p/' + data.id + '-' + data.slug + '"><img class="list-img" src="/img/products/' + data.path + '/' + data.image + '"> ' + data.title + '<br><span>Код: ' + data.barcode + '</span> <span>ОЕМ: ' + data.oem + '</span></a></li>'
        }
      }
    });
  });
</script>

@yield('scripts')

</body>
</html>