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
                  <li><a href="/profile" class="nav-link">Мой аккаунт</a></li>
                  <li> <a href="#" class="nav-link"><b>Заказы</b></a></li>
                  <li>
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Выйти') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </li>
                </ul><br>
              </div>
              <div class="col-md-12 col-lg-10">
                <h3>Заказы</h3>
                <div class="table-responsive">
                  <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Номер</th>
                        <th>Товар</th>
                        <th>Регион</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($orders as $order)
                        <tr>
                          <td>{{ $order->id }}</td>
                          <td>
                            <?php $countAllProducts = unserialize($order->count); $i = 0; ?>
                            @foreach ($countAllProducts as $id => $countProduct)
                              @if (isset($order->products[$i]) AND $order->products[$i]->id == $id)
                                <div class="row">
                                  <div class="col-md-4">
                                    <img src="/img/products/{{ $order->products[$i]->path.'/'.$order->products[$i]->image }}" class="mr-3" style="width:90px;height:auto;">
                                  </div>
                                  <div class="col-md-8">
                                    <h5 class="mt-0"><a href="/p/{{ $order->products[$i]->id.'-'.$order->products[$i]->slug }}">{{ $order->products[$i]->title }}</a></h5>
                                    {{ $order->products[$i]->price }}$. <span>{{ $countProduct . ' шт.' }}</span>
                                  </div>
                                </div>
                              @endif
                              <?php $i++; ?>
                            @endforeach
                          </td>
                          <td><span class="amount">{{ $order->price }}</span>$</td>
                          <td>{{ $order->city->country->title.', '.$order->city->title.', '.$order->address }}</td>
                          <td>{{ trans('orders.statuses.'.$order->status) }}</td>
                        </tr>
                      @empty
                        <h4>Нет заказов</h4>
                      @endforelse
                    </tbody>
                  </table>
                </div>
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