@extends('layout')

@section('meta_title', $product->meta_title ?? $product->title)

@section('meta_description', $product->meta_description ?? $product->title)

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
            <li class="breadcrumb-item"><a href="/catalog/{{ $product->category->slug.'/'.$product->category->id }}">{{ $product->category->title }}</a></li>
            <li class="breadcrumb-item active">{{ $product->title }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- content-wraper start -->
  <div class="content-wraper">
    <div class="container">
      <div class="row single-product-area">
        <div class="col-lg-6 col-md-6">
          <!-- Product Details Left -->
          <div class="product-details-left">
            <div class="product-details-images slider-lg-image-1">
              @if ($product->images != '')
                <?php $images = unserialize($product->images); ?>
                @foreach ($images as $k => $image)
                  <div class="lg-image">
                    <a href="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" class="img-poppu"><img src="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" alt="{{ $product->title }}"></a>
                  </div>
                @endforeach
              @else
                <div class="lg-image">
                  <a href="/assets/images/product/1.jpg" class="img-poppu"><img src="/assets/images/product/1.jpg" alt="product image"></a>
                </div>
              @endif
            </div>
            <div class="product-details-thumbs slider-thumbs-1">
              @if ($product->images != '')
                @foreach ($images as $k => $image)
                  <div class="sm-image"><img src="/img/products/{{ $product->path.'/'.$images[$k]['present_image'] }}" alt="{{ $product->title }}"></div>
                @endforeach
              @else
                <div class="sm-image"><img src="/assets/images/product/2.jpg" alt="product image thumb"></div>
              @endif
            </div>
          </div>
        </div>

        <div class="col-lg-6 col-md-6">
          <div class="product-details-view-content">
            <div class="product-info">
              <h2>{{ $product->title }}</h2>
              <div class="price-box">
                <span class="new-price">${{ number_format($product->price, 2, '.', ' ') }}</span>
              </div>
              <span><b>Номер: {{ $product->barcode }}</b></span><hr>
              {!! $product->characteristic !!}
              <div class="single-add-to-cart">
                <form action="/add-to-cart/{{ $product->id }}" class="cart-quantity" method="get">
                  @csrf
                  <div class="product-variants">
                    <div class="produt-variants-size">
                      <label>Цвета</label>
                      <select class="form-control-select" id="option_id" class="option_id">
                        @foreach($product->options as $option)
                          <option value="{{ $option->id }}" title="{{ $option->title }}">{{ $option->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div><br>
                  <?php $items = session('items'); ?>
                  @if (is_array($items) AND isset($items['products_id'][$product->id]))
                    <a href="/cart" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>
                  @else
                    <div class="quantity">
                      <label>Количество</label>
                      <div class="cart-plus-minus">
                        <input class="cart-plus-minus-box" name="count[{{ $product->id }}]" id="quantity" data-price="{{ number_format($product->price, 2, '.', ' ') }}" size="4" min="1" value="1">
                        <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                        <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                      </div>
                    </div>
                    <button class="add-to-cart" type="button" data-product-id="{{ $product->id }}" onclick="addToCart(this);" title="Добавить в корзину">В корзину</button>
                  @endif
                </form>
              </div>
              @if($product->presense == 1)
                <div class="product-availability">
                  <i class="fa fa-check"></i> В наличии
                </div>
              @endif
            </div>
          </div>
        </div> 
      </div>
      <div class="row">
        <div class="col-12">
          <div class="product-details-tab mt--60">
            <ul role="tablist" class="mb--50 nav">
              <li class="active" role="presentation">
                <a data-toggle="tab" role="tab" href="#description" class="active">Описание</a>
              </li>
              <li role="presentation">
                <a data-toggle="tab" role="tab" href="#reviews">Отзывы</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="col-12">
          <div class="product_details_tab_content tab-content">
            <!-- Start Single Content -->
            <div class="product_tab_content tab-pane active" id="description" role="tabpanel">
              <div class="product_description_wrap">
                <div class="product_desc mb--30">
                  {!! $product->description !!}
                </div>
              </div>
            </div>

            <!-- Start Single Content -->
            <div class="product_tab_content tab-pane" id="reviews" role="tabpanel">
              <div class="review_address_inner">
                <!-- Start Single Review -->
                <div class="pro_review">
                  <div class="review_thumb">
                    <img alt="review images" src="/assets/images/review/1.jpg">
                  </div>
                  <div class="review_details">
                    <div class="review_info">
                      <h4><a href="#">Gerald Barnes</a></h4>
                      <ul class="product-rating d-flex">
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                      </ul>
                      <div class="rating_send">
                        <a href="#"><i class="fa fa-reply"></i></a>
                      </div>
                    </div>
                    <div class="review_date">
                      <span>27 Jun, 2018 at 3:30pm</span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                  </div>
                </div>

                <!-- Start Single Review -->
                <div class="pro_review ans">
                  <div class="review_thumb">
                    <img alt="review images" src="/assets/images/review/2.jpg">
                  </div>
                  <div class="review_details">
                    <div class="review_info">
                      <h4><a href="#">Gerald Barnes</a></h4>
                      <ul class="product-rating d-flex">
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                        <li><span class="fa fa-star"></span></li>
                      </ul>
                      <div class="rating_send">
                        <a href="#"><i class="fa fa-reply"></i></a>
                      </div>
                    </div>
                    <div class="review_date">
                      <span>27 Jun, 2018 at 4:32pm</span>
                    </div>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                  </div>
                </div>

              </div>

              <!-- Start Rating Area -->
              <div class="rating_wrap">
                <h2 class="rating-title">Write  A review</h2>
                <h4 class="rating-title-2">Your Rating</h4>
                <div class="rating_list">
                  <ul class="product-rating d-flex">
                    <li><span class="fa fa-star"></span></li>
                    <li><span class="fa fa-star"></span></li>
                    <li><span class="fa fa-star"></span></li>
                    <li><span class="fa fa-star"></span></li>
                    <li><span class="fa fa-star"></span></li>
                  </ul>
                </div>
              </div>
              <!-- End RAting Area -->
              <div class="comments-area comments-reply-area">
                <div class="row">
                  <div class="col-lg-12">
                    <form action="#" class="comment-form-area">
                      <div class="comment-input">
                        <p class="comment-form-author">
                          <label>Name <span class="required">*</span></label> 
                          <input type="text" required="required" name="Name">
                        </p>
                        <p class="comment-form-email">
                          <label>Email <span class="required">*</span></label> 
                          <input type="text" required="required" name="email">
                        </p>
                      </div>
                      <p class="comment-form-comment">
                        <label>Comment</label> 
                        <textarea class="comment-notes" required="required"></textarea>
                      </p>
                      <div class="comment-form-submit">
                        <input type="submit" value="Post Comment" class="comment-submit">
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

  <!-- Product Area Start -->
  <div class="product-area section-pt">/
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- section-title start -->
          <div class="section-title">
            <h2>Дополнительные товары</h2>
          </div>
        </div>
      </div>
      <!-- product-wrapper start -->
      <div class="product-wrapper">
        <div class="row product-slider">

          @foreach ($products as $product)
            <div class="col-12">
              <div class="single-product-wrap">
                <div class="product-image">
                  <a href="/p/{{ $product->slug }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}"></a>
                  @foreach($product->modes as $m)
                    @if(in_array($m->slug, ['recommend', 'novelty', 'best-price', 'stock', 'plus-gift']))
                      <span class="label-product label-new">new</span>
                      <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                    @endif
                  @endforeach
                  <div class="quick_view">
                    <a href="#" title="quick view" class="quick-view-btn" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-search"></i></a>
                  </div>
                </div>
                <div class="product-content">
                  <h3><a href="/p/{{ $product->slug }}">{{ $product->title }}</a></h3>
                  <div class="price-box">
                    <span class="new-price">${{ $product->price }}</span>
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
      </div>
    </div>
  </div>

@endsection


@section('scripts')
  <script>
    function addToCart(i) {
      var productId = $(i).data("product-id");
      var optionId = $("#option_id").val();
      var quantity = $("input#quantity").val();

      $.ajax({
        type: "get",
        url: '/add-to-cart/'+productId,
        dataType: "json",
        data: {
          "option_id": optionId,
          "quantity": quantity
        },
        success: function(data) {
          $('*[data-product-id="'+productId+'"]').replaceWith('<a href="/cart" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>');
          $('#count-items').text(data.countItems);
          $('div.quantity').remove();
          alert('Товар добавлен в корзину');
        }
      });
    }
  </script>
@endsection