<?php $items = session('items'); ?>

<div class="row custom-row">
  @foreach ($products as $product)
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-6 mt-30">
      <div class="single-product-wrap">
        <div class="product-image">
          <a href="/p/{{ $product->slug }}"><img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}"></a>
          @foreach($product->modes as $m)
            @if(in_array($m->slug, ['recommend', 'novelty', 'best-price', 'stock', 'plus-gift']))
              <span class="label-product label-new">new</span>
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