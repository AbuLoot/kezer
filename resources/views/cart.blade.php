@extends('layout')

@section('meta_title', 'Корзина')

@section('meta_description', 'Корзина')

@section('head')

@endsection

@section('content')

  <div class="breadcrumb-area bg-grey">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <ul class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="/">Главная</a></li>
            <li class="breadcrumb-item active">Корзина</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="content-wraper">
    <div class="container">
      @include('partials.alerts')

      <div class="row">
        <div class="col-12">
          @if ($products->count() > 0)
            <h3><b>Оформление заказа</b></h3>
            <form action="/store-order" method="post" class="cart-table">
              {!! csrf_field() !!}
              <div class="table-content table-responsive">
                <table class="table table-hover">
                  <thead class="d-none d-sm-block">
                    <tr class="row no-gutters">
                      <th class="col-md-2 plantmore-product-thumbnail">Картинка</th>
                      <th class="col-md-3 cart-product-name">Продукт</th>
                      <th class="col-md-2 plantmore-product-price">Цена</th>
                      <th class="col-md-2 plantmore-product-quantity">Количество</th>
                      <th class="col-md-2 plantmore-product-subtotal">Сумма</th>
                      <th class="col-md-1 plantmore-product-remove">Удалить</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $total_sum = 0; ?>
                    @foreach ($products as $product)
                      <?php $quantity = session('items')['products_id'][$product->id]['quantity']; ?>
                      <?php $option_id = session('items')['products_id'][$product->id]['option_id']; ?>
                      <?php $total_sum += $product->price * $quantity; ?>
                      <tr class="row no-gutters">
                        <td class="col-md-2 col-6 border-top plantmore-product-thumbnail"><a href="/img/products/{{ $product->path.'/'.$product->image }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" style="width:80px;height:80px;"></a></td>
                        <td class="col-md-3 col-6 border-top plantmore-product-name text-left">
                          <a href="/p/{{ $product->slug }}">{{ $product->title }}</a>
                          <span>Номер: <b>{{ $product->barcode }}</b></span>
                          <span>Цвет: <b>{{ $product->options->firstWhere('id', $option_id)->title }}</b></span>
                        </td>
                        <td class="col-md-2 col-3 plantmore-product-price"><span class="amount">{{ $product->price }}〒</span></td>
                        <td class="col-md-2 col-3 plantmore-product-quantity">
                          <div class="quantity">
                            <div class="cart-plus-minus">
                              <input class="cart-plus-minus-box" type="text" name="count[{{ $product->id }}]" id="input-quantity-{{ $product->id }}" data-price="{{ $product->price }}" size="4" min="1" value="{{ $quantity }}">
                              <div class="dec qtybutton" onclick="decrement_quantity('{{ $product->id }}')"><i class="fa fa-angle-down"></i></div>
                              <div class="inc qtybutton" onclick="increment_quantity('{{ $product->id }}')"><i class="fa fa-angle-up"></i></div>
                            </div>
                          </div>
                        </td>
                        <td class="col-md-2 col-3 product-subtotal"><span class="sum-{{ $product->id }}">{{ $product->price * $quantity }}</span>〒</td>
                        <td class="col-md-1 col-3 plantmore-product-remove"><a href="/destroy-from-cart/{{ $product->id }}" onclick="return confirm('Удалить запись?')"><i class="fa fa-close"></i></a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>

              <div class="checkout-details-wrapper mt--30">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="billing-details-wrap">
                      <h3 class="shoping-checkboxt-title">Платежные реквизиты</h3>
                      <div class="row">
                        <div class="col-lg-6">
                          <p class="single-form-row">
                            <label>Имя <span class="required">*</span></label>
                            <input type="text" name="name" id="name" placeholder="Имя *" value="<?php echo (\Auth::check()) ? \Auth::user()->name : old('name'); ?>" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-6">
                          <p class="single-form-row">
                            <label>Фамилия <span class="required">*</span></label>
                            <input type="text" name="surname" id="surname" placeholder="Фамилия *" value="<?php echo (\Auth::check()) ? \Auth::user()->surname : old('surname'); ?>" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Номер телефона <span class="required">*</span></label>
                            <input type="tel" name="phone" id="phone" placeholder="Номер телефона *" value="<?php echo (\Auth::check()) ? \Auth::user()->phone : old('phone'); ?>" minlength="5" maxlength="20" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" name="email" id="email" placeholder="Email *" value="<?php echo (\Auth::check()) ? \Auth::user()->email : old('email'); ?>" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Название компании</label>
                            <input type="text" placeholder="Компания" name="company_name" id="company_name" value="{{ old('company_name') }}" minlength="2" maxlength="50" placeholder="Адрес *">
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <div class="single-form-row">
                            <label>Страна / город <span class="required">*</span></label>
                            <div class="nice-select wide">
                              <select id="city_id" name="city_id" required>
                                <option>Выберите регион...</option>
                                @foreach($countries as $country)
                                  <optgroup label="{{ $country->title }}">
                                    @foreach($country->cities as $city)
                                      <option value="{{ $city->id }}">{{ $city->title }}</option>
                                    @endforeach
                                  </optgroup>
                                @endforeach
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Адрес <span class="required">*</span></label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" placeholder="Адрес *" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Почтовый индекс</label>
                            <input type="text" name="postcode" minlength="4" maxlength="40">
                          </p>
                        </div>
                        @empty(\Auth::user())
                          <div class="col-lg-12">
                            <div class="checkout-box-wrap">
                              <label><input type="checkbox" name="create-account" id="chekout-box"> Создать аккаунт?</label>
                              <div class="account-create single-form-row">
                                <label class="creat-pass">Пароль <span>*</span></label>
                                <input type="password" class="input-text">
                              </div>
                            </div>
                          </div>
                        @endempty
                        <div class="col-lg-12">
                          <p class="single-form-row m-0">
                            <label>Примечание к заказу</label>
                            <textarea name="notes" placeholder="Дополнительная информация..." class="data_1" rows="2" cols="5"></textarea>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="your-order-wrapper">
                      <h3 class="shoping-checkboxt-title">Ваш заказ</h3>
                      <div class="your-order-wrap">
                        <div class="your-order-table table-responsive">
                          <table>
                            <tr class="shipping">
                              <th><b>Способ доставки</b></th>
                              <td>
                                <ul>
                                  @foreach(trans('orders.get') as $k => $v)
                                    <li>
                                      <label>
                                        <input type="radio" name="get" value="{{ $k }}"> {{ $v['value'] }}
                                      </label>
                                    </li>
                                  @endforeach
                                </ul>
                              </td>
                            </tr>
                            <tr>
                              <th><b>Метод оплаты</b></th>
                              <td>
                                <ul>
                                  @foreach(trans('orders.pay') as $k => $v)
                                    <li>
                                      <label>
                                        <input type="radio" name="pay" value="{{ $k }}"> {{ $v['value'] }}
                                      </label>
                                    </li>
                                  @endforeach
                                </ul>
                              </td>
                            </tr>
                            <tr class="order-total">
                              <th><b>Итоговая сумма</b></th>
                              <td><strong><span class="total-sum">{{ $total_sum }}</span>₸</strong></td>
                            </tr>
                          </table>

                          <div class="order-button-payment">
                            <input type="submit" value="Разместить заказ">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          @else
            <h2>Корзина пуста</h2>
            <p><a href="/" class="btn btn-lg btn-primary">Перейти к покупкам</a></p>
          @endif
        </div>
      </div>

    </div>
  </div>
@endsection


@section('scripts')
<script>
  function increment_quantity(product_id) {

    var inputQuantityElement = $("#input-quantity-"+product_id);
    var newQuantity = parseInt($(inputQuantityElement).val()) + 1;
    addToCart(product_id, newQuantity);
  }

  function decrement_quantity(product_id) {

    var inputQuantityElement = $("#input-quantity-"+product_id);
    if ($(inputQuantityElement).val() > 1) {
      var newQuantity = parseInt($(inputQuantityElement).val()) - 1;
      addToCart(product_id, newQuantity);
    }
  }

  function addToCart(product_id, new_quantity) {

    $.ajax({
      type: "get",
      url: '/add-to-cart/'+product_id,
      dataType: "json",
      data: {
        "quantity": new_quantity
      },
      success: function(data) {
        var sum = parseInt(data.price) * data.quantity;
        var total_sum = $('.total-sum');

        $('.sum-'+product_id).text(sum);
        $('.total-sum').text(data.total_sum);

        // $('*[data-product-id="'+productId+'"]').replaceWith('<a href="/cart" class="btn btn-default btn-lg" data-toggle="tooltip" data-placement="top" title="Перейти в корзину">Оплатить</a>');
      }
    });
  }
</script>
@endsection