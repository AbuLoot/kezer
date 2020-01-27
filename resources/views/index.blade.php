@extends('layout')

@section('meta_title', '')

@section('meta_description', '')

@section('head')

@endsection

@section('content')

  <?php $items = session('items'); ?>

  <!-- Hero Slider -->
  <div class="hero-slider hero-slider-one">
    @foreach($slide_items as $key => $slide_item)
      <div class="single-slide" style="background-image: url(img/slide/{{ $slide_item->image }})">
        <div class="hero-content-one container">
          <div class="row">
            <div class="col"> 
              <div class="slider-text-info text-white">
                <h2>{{ $slide_item->title }}</h2>
                <p>{{ $slide_item->marketing }}</p>
                <a href="/{{ $slide_item->link }}" class="btn slider-btn uppercase"><span><i class="fa fa-plus"></i> Shop Now</span></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
    <div class="single-slide" style="background-image: url(img/slide/1.png)">
      <div class="hero-content-one container">
        <div class="row">
          <div class="col"> 
            <div class="slider-text-info">
              <h1 class="display-4 text-white">Сіздің Туркиядағы сенімді серіктесіңіз</h1>
              <h2 class="text-white">Ваш надежный партнер в Турции</h2>
              <!-- <a href="/" class="btn slider-btn uppercase"><span><i class="fa fa-plus"></i> Подробнее</span></a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Categories List Post area-->
  @if($relevant_categories->isNotEmpty())
    <div class="poslistcategories-area mt--30-">
      <div class="container-fluid plr-30">
        <div class="row">
          @foreach($relevant_categories as $relevant_category)
            <div class="col-lg-4 col-6">
              <div class="categories-list-post-item mt--30">
                 <img src="/filemanager/{{ $relevant_category->image }}" alt="{{ $relevant_category->title }}">
                 <a href="/catalog/{{ $relevant_category->slug .'/'. $relevant_category->id }}" class="category-inner">{{ $relevant_category->title }}</a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  <!-- Product Area -->
  <div class="product-area mt--70">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Новые поступления</h2>
            <!-- <p>Тренд одежд 2020 года</p> -->
          </div>
        </div>
      </div>
      <div class="row custom-row">
        @foreach($mode_new->products->where('status', 1)->take(8) as $new_product)
          <div class="col-6 col-md-3 col-lg-3">
            <div class="single-product-wrap">
              <div class="product-image">
                <a href="/p/{{ $new_product->slug }}"><img src="/img/products/{{ $new_product->path.'/'.$new_product->image }}" alt="{{ $new_product->title }}"></a>
                @foreach($new_product->modes as $m)
                  @if(in_array($m->slug, ['recommend', 'novelty', 'best-price', 'stock', 'plus-gift']))
                    <span class="label-product label-new">new</span>
                    <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                  @endif
                @endforeach
              </div>
              <div class="product-content">
                <h3><a href="/p/{{ $new_product->slug }}">{{ $new_product->title }}</a></h3>
                <div class="price-box">
                  <span class="new-price">{{ $new_product->price }}〒</span>
                </div>
                <div class="product-action">
                  @if (is_array($items) AND isset($items['products_id'][$new_product->id]))
                    <a href="/cart" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>
                  @else
                    <button class="add-to-cart" data-product-id="{{ $new_product->id }}" onclick="addToCart(this);" title="Добавить в корзину"><i class="fa fa-plus"></i> В корзину</button>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  <!-- Product Area -->
  <div class="product-area mt--70">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-title">
            <h2>Лучшие одежды</h2>
          </div>
        </div>
      </div>
      <div class="row custom-row">
        @foreach($mode_best->products->where('status', 1)->take(8) as $best_product)
          <div class="col-6 col-md-3 col-lg-3">
            <div class="single-product-wrap">
              <div class="product-image">
                <a href="/p/{{ $best_product->slug }}"><img src="/img/products/{{ $best_product->path.'/'.$best_product->image }}" alt="{{ $best_product->title }}"></a>
                @foreach($best_product->modes as $m)
                  @if(in_array($m->slug, ['recommend', 'novelty', 'best-price', 'stock', 'plus-gift']))
                    <span class="label-product label-new">new</span>
                    <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                  @endif
                @endforeach
              </div>
              <div class="product-content">
                <h3><a href="/p/{{ $best_product->slug }}">{{ $best_product->title }}</a></h3>
                <div class="price-box">
                  <span class="new-price">{{ $best_product->price }}〒</span>
                </div>
                <div class="product-action">
                  @if (is_array($items) AND isset($items['products_id'][$best_product->id]))
                    <a href="/cart" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>
                  @else
                    <button class="add-to-cart" data-product-id="{{ $best_product->id }}" onclick="addToCart(this);" title="Добавить в корзину"><i class="fa fa-plus"></i> В корзину</button>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
  
  <!-- Banner area -->
  @if($stock_categories->isNotEmpty())
    <div class="banner-area-two mt--70">
      <div class="container-fluid plr-40">
        <div class="row">
          @foreach($stock_categories as $stock_category)
            <div class="col-lg-6 col-md-6">
              <div class="single-banner-two mt--30">
                <a href="/catalog/{{ $stock_category->slug .'/'. $stock_category->id }}">
                  <img src="/filemanager/{{ $stock_category->image }}" alt="{{ $stock_category->title }}">
                </a>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  @endif

  <!-- Our Advantages -->
  @if($advantages != NULL)
    <div class="our-services-area section-pt-70">
      <div class="container">
        {!! $advantages->content !!}
      </div>
    </div>
  @endif


  <!-- Our Brand Area -->
  <div class="our-brand-area mt--70">
    <div class="container">
      <div class="row our-brand-active text-center">
        @foreach ($companies as $company)
          <div class="col-12">
            <div class="single-brand">
              <a href="/catalog/brand/{{ $company->slug }}"><img src="/img/companies/{{ $company->logo }}" alt="{{ $company->title }}"></a>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

@endsection


@section('scripts')
  <script>
    function addToCart(i) {
      var productId = $(i).data("product-id");

      if (productId != '') {
        $.ajax({
          type: "get",
          url: '/add-to-cart/'+productId,
          dataType: "json",
          data: {},
          success: function(data) {
            $('*[data-product-id="'+productId+'"]').replaceWith('<a href="/cart" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>');
            $('#count-items').text(data.countItems);
            alert('Товар добавлен в корзину');
          }
        });
      } else {
        alert("Ошибка сервера");
      }
    }
  </script>
@endsection