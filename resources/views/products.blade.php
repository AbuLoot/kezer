@extends('layout')

@section('meta_title', $category->meta_title)

@section('meta_description', $category->meta_description)

@section('head')

@endsection


@section('content')

  <!-- Breadcrumb -->
  <div class="breadcrumb-area bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            @foreach ($category->ancestors as $ancestor)
              @unless($ancestor->parent_id != NULL && $ancestor->children->count() > 0)
                <li class="breadcrumb-item"><a href="/catalog/{{ $ancestor->slug.'/'.$ancestor->id }}">{{ $ancestor->title }}</a></li>
              @endunless
            @endforeach
            <li class="breadcrumb-item active">{{ $category->title }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <?php $items = session('items'); ?>

  <!-- Content Wraper -->
  <div class="content-wraper">
    <div class="container">
      <div class="row">
        <div class="col-lg-3 order-2 order-lg-1">
          <div class="d-md-none d-lg-block">
            <?php if ($category->ancestors->count() == 2) : ?>
              <div class="list-group custom-list-group">
                <?php foreach ($category->getSiblings() as $sibling_category) : ?>
                  <a href="/catalog/{{ $sibling_category->slug.'/'.$sibling_category->id }}" class="list-group-item list-group-item-action">{{ $sibling_category->title }}</a>
                <?php endforeach; ?>
              </div><br>
            <?php elseif ($category->children && $category->children->count() > 0) : ?>
              <div class="list-group custom-list-group">
                <?php foreach ($category->children as $child_category) : ?>
                  <a href="/catalog/{{ $child_category->slug.'/'.$child_category->id }}" class="list-group-item list-group-item-action">{{ $child_category->title }}</a>
                <?php endforeach; ?>
              </div><br>
            <?php endif; ?>
          </div>
          <div class="sidebar-categores-box">
            <div class="sidebar-title">
              <h2>Фильтр</h2>
            </div>
            <form action="/catalog/{{ $category->slug }}" method="get" id="filter">
              {{ csrf_field() }}
              <?php $options_id = session('options'); ?>
              @foreach ($grouped as $data => $group)
                <div class="filter-sub-area">
                  <h5 class="filter-sub-titel">{{ $data }}</h5>
                  <div class="size-checkbox">
                    <ul>
                      @foreach ($group as $option)
                        <li>
                          <input type="checkbox" id="o{{ $option->id }}" name="options_id[]" value="{{ $option->id }}" @if(isset($options_id) AND in_array($option->id, $options_id)) checked @endif>
                          <a href="#"><label class="" for="o{{ $option->id }}">{{ $option->title }}</label></a>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              @endforeach
              <!-- <div class="filter-sub-area">
                <h5 class="filter-sub-titel">Color</h5>
                <div class="color-categoriy">
                  <ul>
                    <li><span class="white"></span><a href="#">White (1)</a></li>
                    <li><span class="black"></span><a href="#">Black (1)</a></li>
                    <li><span class="Orange"></span><a href="#">Orange (3) </a></li>
                    <li><span class="Blue"></span><a href="#">Blue  (2) </a></li>
                  </ul>
                </div>
              </div> -->
            </form>
          </div>
          <div class="shop-banner">
            <div class="single-banner">
              <a href="#"><img src="assets/images/banner/advertising-s1.jpg" alt=""></a>
            </div>
          </div>
        </div>
        <div class="col-lg-9 order-1 order-lg-2">
          <div class="shop-top-bar mt-95">
            <div class="shop-bar-inner">
              <span>Товаров от {{ $products->firstItem().' до '.$products->lastItem().' из '.$products->total() }}</span>
            </div>
            <div class="product-select-box">
              <div class="product-short">
                <p>Сортировать:</p>
                <select class="nice-select" id="actions">
                  @foreach(trans('data.sort') as $key => $value)
                    <option value="{{ $key }}" @if($key == session('action')) selected @endif>{{ $value }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <div class="shop-products-wrapper" id="products">
            <div class="mt--15 d-block d-sm-none">
              <?php if ($category->ancestors->count() == 2) : ?>
                <div class="list-group custom-list-group">
                  <?php foreach ($category->getSiblings() as $sibling_category) : ?>
                    <a href="/catalog/{{ $sibling_category->slug.'/'.$sibling_category->id }}" class="list-group-item list-group-item-action">{{ $sibling_category->title }}</a>
                  <?php endforeach; ?>
                </div><br>
              <?php elseif ($category->children && $category->children->count() > 0) : ?>
                <div class="list-group custom-list-group">
                  <?php foreach ($category->children as $child_category) : ?>
                    <a href="/catalog/{{ $child_category->slug.'/'.$child_category->id }}" class="list-group-item list-group-item-action">{{ $child_category->title }}</a>
                  <?php endforeach; ?>
                </div><br>
              <?php endif; ?>
            </div>
            <div class="row custom-row">
              @foreach ($products as $product)
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 mt-30">
                  <div class="single-product-wrap">
                    <div class="product-image">
                      <a href="/p/{{ $product->slug }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}"></a>
                      @foreach($product->modes as $m)
                        @if(in_array($m->slug, ['recommend', 'new', 'best-price', 'stock', 'plus-gift']))
                          <span class="label-product label-new">Новинка</span>
                          <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                        @endif
                      @endforeach
                    </div>
                    <div class="product-content">
                      <h3><a href="/p/{{ $product->slug }}">{{ $product->title }}</a></h3>
                      <div class="price-box">
                        <span class="new-price">{{ $product->price }}〒</span>
                      </div>
                      <div class="product-action">
                        @if (is_array($items) AND isset($items['products_id'][$product->id]))
                          <a href="/cart" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>
                        @else
                          <button class="add-to-cart" data-product-id="{{ $product->id }}" onclick="addToCart(this);" title="Добавить в корзину"><i class="fa fa-plus"></i> В корзину</button>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="pagination-area">
              {{ $products->links('vendor.pagination.simple-default') }}
            </div>
          </div>
        </div>
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

    // Actions
    $('#actions').change(function() {

      var action = $(this).val();
      var page = $(location).attr('href').split('catalog')[1];
      var slug = page.split('?')[0];

      $.ajax({
        type: "get",
        url: '/catalog'.page,
        dataType: "json",
        data: {
          "action": action
        },
        success: function(data) {
          $('#products').html(data);
          // location.reload();
        }
      });
    });

    // Filter products
    $('#filter').on('click', 'input', function(e) {

      var optionsId = new Array();

      $('input[name="options_id[]"]:checked').each(function() {
        optionsId.push($(this).val());
      });

      var page = $(location).attr('href').split('catalog')[1];
      var slug = page.split('?')[0];

      $.ajax({
        type: 'get',
        url: '/catalog' + slug,
        dataType: 'json',
        data: {
          'options_id': optionsId,
        },
        success: function(data) {
          $('#products').html(data);
        }
      });
    });
  </script>
@endsection