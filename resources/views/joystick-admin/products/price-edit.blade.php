@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/products" class="btn btn-primary btn-sm">Назад</a>
  </p>
  <form action="/admin/products-price/update" method="POST">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="category_id">Категории</label>
      <select id="category_id" name="category_id" class="form-control">
        <option value=""></option>
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse) { ?>
          <?php foreach ($nodes as $node) : ?>
            <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
            <?php $traverse($node->children, $prefix.'___'); ?>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($categories); ?>
      </select>
    </div>
    <div class="form-group">
      <label for="operation">Оператор</label>
      <select class="form-control" name="operation" id="operation">
        <option value="1">* умножение</option>
        <option value="2">/ деление</option>
        <option value="3">+ плюс</option>
        <option value="4">- минус</option>
      </select>
    </div>
    <div class="form-group">
      <label for="number">Цифра</label>
      <input type="text" class="form-control" id="number" name="number" maxlength="80" value="{{ (old('number')) ? old('number') : '' }}" required>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </form>
@endsection
