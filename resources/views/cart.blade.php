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
            <li class="breadcrumb-item active">Корзина</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="content-wraper">
    <div class="container">
      <div class="row">
        <div class="col-12">
          @if ($products->count() > 0)
            <h3><b>Оформление заказа</b></h3>
            <form action="/store-order" method="post" class="cart-table">
              {!! csrf_field() !!}
              <div class="table-content table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th class="plantmore-product-thumbnail">Картинка</th>
                      <th class="cart-product-name">Продукт</th>
                      <th class="plantmore-product-price">Цена</th>
                      <th class="plantmore-product-quantity">Количество</th>
                      <th class="plantmore-product-subtotal">Сумма</th>
                      <th class="plantmore-product-remove">Удалить</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($products as $product)
                      <tr>
                        <td class="plantmore-product-thumbnail"><a href="/img/products/{{ $product->path.'/'.$product->image }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" style="width:80px;height:80px;"></a></td>
                        <td class="plantmore-product-name text-left"><a href="/p/{{ $product->slug }}">{{ $product->title }}</a></td>
                        <td class="plantmore-product-price"><span class="amount">{{ $product->price }}〒</span></td>
                        <td class="plantmore-product-quantity">
                          <div class="quantity">
                            <div class="cart-plus-minus">
                              <input class="cart-plus-minus-box" name="quantity-{{ $product->id }}" id="{{ $product->id }}" value="1" data-price="{{ $product->price }}" type="text" size="4">
                              <div class="inc qtybutton"><i class="fa fa-angle-up"></i></div>
                              <div class="dec qtybutton"><i class="fa fa-angle-down"></i></div>
                            </div>
                          </div>
                        </td>
                        <td class="product-subtotal"><span class="amount">{{ $product->price }}</span>〒</td>
                        <td class="plantmore-product-remove"><a href="/destroy-from-cart/{{ $product->id }}" onclick="return confirm('Удалить запись?')"><i class="fa fa-close"></i></a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </form>

            <div class="checkout-details-wrapper mt--30">
              <form action="/store-order" method="post">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="billing-details-wrap">
                      <h3 class="shoping-checkboxt-title">Платежные реквизиты</h3>
                      <div class="row">
                        <div class="col-lg-6">
                          <p class="single-form-row">
                            <label>Имя <span class="required">*</span></label>
                            <input type="text" placeholder="Имя *" name="name" id="name" value="{{ (old('name')) ? old('name') : '' }}" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-6">
                          <p class="single-form-row">
                            <label>Фамилия <span class="required">*</span></label>
                            <input type="text" placeholder="Фамилия *" name="surname" id="surname" value="{{ (old('surname')) ? old('surname') : '' }}" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Название компании</label>
                            <input type="text" placeholder="Компания" name="company_name" id="company_name" value="{{ old('company_name') }}" minlength="2" maxlength="50" required>
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
                            <input type="text" placeholder="Адрес *" name="address" id="address" value="{{ old('address') }}" minlength="2" maxlength="40" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Почтовый индекс</label>
                            <input type="text" name="postcode">
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Номер телефона</label>
                            <input type="tel" placeholder="Телефона *" name="phone" id="phone" value="{{ (old('phone')) ? old('phone') : \Auth::user()->phone }}" minlength="5" maxlength="20" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row">
                            <label>Email <span class="required">*</span></label>
                            <input type="email" placeholder="Email *" name="email" id="email" value="{{ (old('email')) ? old('email') : \Auth::user()->email }}" required>
                          </p>
                        </div>
                        <div class="col-lg-12">
                          <div class="checkout-box-wrap">
                            <label><input type="checkbox" id="chekout-box"> Создать аккаунт?</label>
                            <div class="account-create single-form-row">
                              <label class="creat-pass">Пароль <span>*</span></label>
                              <input type="password" class="input-text">
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <p class="single-form-row m-0">
                            <label>Примечание к заказу</label>
                            <textarea placeholder="Дополнительная информация..." class="data_1" rows="2" cols="5"></textarea>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6">
                    <div class="your-order-wrapper">
                      <h3 class="shoping-checkboxt-title">Ваш заказ</h3>
                      <!-- your-order-wrap start-->
                      <div class="your-order-wrap">
                        <div class="your-order-table table-responsive">
                          <table>
                            <tboot>
                              <tr class="shipping">
                                <th><b>Способ доставки</b></th>
                                <td>
                                  <ul>
                                    @foreach(trans('orders.get') as $k => $v)
                                      <li>
                                        <label>
                                          <input type="radio" name="get" value="{{ $v['key'] }}">
                                          {{ $v['value'] }}
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
                                          <input type="radio" name="pay" value="{{ $v['key'] }}">
                                          {{ $v['value'] }}
                                        </label>
                                      </li>
                                    @endforeach
                                  </ul>
                                </td>
                              </tr>
                              <tr class="order-total">
                                <th><b>Итоговая сумма</b></th>
                                <td><strong><span class="amount">{{ $products->sum('price') }}₸</span></strong></td>
                              </tr>
                            </tboot>
                          </table>

                          <div class="order-button-payment">
                            <input type="submit" value="Разместить заказ">
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
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

@endsection