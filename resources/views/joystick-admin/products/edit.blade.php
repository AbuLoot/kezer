@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Редактирование</h2>

  @include('joystick-admin.partials.alerts')

  <div class="row">
    <div class="col-md-6">
      <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="#">Инфо</a></li>
        <li role="presentation"><a href="/admin/products/{{ $product->id }}/comments">Коментарии</a></li>
      </ul>
    </div>
    <div class="col-md-6">
      <p class="text-right">
        <a href="/admin/products" class="btn btn-primary btn-sm">Назад</a>
      </p>
    </div>
  </div><br>

  <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="PUT">
    {!! csrf_field() !!}

    <div class="form-group">
      <label for="title">Заголовок</label>
      <input type="text" class="form-control" id="title" name="title" minlength="5" maxlength="80" value="{{ (old('title')) ? old('title') : $product->title }}" required>
    </div>
    <div class="form-group">
      <label for="slug">Slug</label>
      <input type="text" class="form-control" id="slug" name="slug" minlength="2" maxlength="80" value="{{ (old('slug')) ? old('slug') : $product->slug }}">
    </div>
    <div class="form-group">
      <label for="sort_id">Номер</label>
      <input type="text" class="form-control" id="sort_id" name="sort_id" maxlength="5" value="{{ (old('sort_id')) ? old('sort_id') : $product->sort_id }}">
    </div>
    <div class="form-group">
      <label for="category_id">Категории</label>
      <select id="category_id" name="category_id" class="form-control" required>
        <option value=""></option>
        <?php $traverse = function ($nodes, $prefix = null) use (&$traverse, $product) { ?>
          <?php foreach ($nodes as $node) : ?>
            <?php if ($node->id == $product->category_id) : ?>
              <option value="{{ $node->id }}" selected>{{ PHP_EOL.$prefix.' '.$node->title }}</option>
            <?php else : ?>
              <option value="{{ $node->id }}">{{ PHP_EOL.$prefix.' '.$node->title }}</option>
            <?php endif; ?>
            <?php $traverse($node->children, $prefix.'___'); ?>
          <?php endforeach; ?>
        <?php }; ?>
        <?php $traverse($categories); ?>
      </select>
    </div>
    <div class="form-group">
      <label for="company_id">Компания</label>
      <select id="company_id" name="company_id" class="form-control">
        <option value=""></option>
        @foreach($companies as $company)
          @if ($company->id == $product->company_id)
            <option value="{{ $company->id }}" selected>{{ $company->title }}</option>
          @else
            <option value="{{ $company->id }}">{{ $company->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="barcode">Артикул</label>
      <input type="text" class="form-control" id="barcode" name="barcode" value="{{ (old('barcode')) ? old('barcode') : $product->barcode }}">
    </div>
    <div class="form-group">
      <label for="price">Цена</label>
      <div class="input-group">
        <input type="text" class="form-control" id="price" name="price" maxlength="10" value="{{ (old('price')) ? old('price') : $product->price }}">
        <div class="input-group-addon">〒</div>
      </div>
    </div>
    <div class="form-group">
      <label for="days">Срок доставки</label>
      <div class="input-group">
        <input type="text" class="form-control" id="days" name="days" maxlength="10" value="{{ (old('days')) ? old('days') : $product->days}}">
        <div class="input-group-addon">дней</div>
      </div>
    </div>
    <div class="form-group">
      <label for="count">Количество товара</label>
      <input type="number" class="form-control" id="count" name="count" minlength="5" maxlength="80" value="{{ (old('count')) ? old('count') : 0 }}">
    </div>
    <div class="form-group">
      <label for="condition">Состояние товара</label>
      <select class="form-control" name="condition" id="condition">
        <option value="1">Новый</option>
        <option value="2">Бывший в употреблении</option>
      </select>
    </div>
    <div class="form-group">
      <label for="presense">Статус товара</label>
      <select class="form-control" name="presense" id="presense">
        <option value="1">В наличии</option>
        <option value="2">В наличии нет</option>
      </select>
    </div>
    <div class="form-group">
      <label for="options_id">Опции (зажмите Ctrl чтобы выбрать несколько вариантов)</label>
      <select id="options_id" name="options_id[]" class="form-control" size="10" multiple>
        <option value=""></option>
        @forelse ($grouped as $data => $group)
          <optgroup label="{{ $data }}">
            @foreach ($group as $option)
              @if ($product->options->contains($option->id))
                <option value="{{ $option->id }}" selected>{{ $option->title }}</option>
              @else
                <option value="{{ $option->id }}">{{ $option->title }}</option>
              @endif
            @endforeach
          </optgroup>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="meta_title">Мета заголовок</label>
      <input type="text" class="form-control" id="meta_title" name="meta_title" maxlength="255" value="{{ (old('meta_title')) ? old('meta_title') : $product->meta_title }}">
    </div>
    <div class="form-group">
      <label for="meta_description">Мета описание</label>
      <input type="text" class="form-control" id="meta_description" name="meta_description" maxlength="255" value="{{ (old('meta_description')) ? old('meta_description') : $product->meta_description }}">
    </div>
    <div class="form-group">
      <label for="characteristic">Характеристика</label>
      <textarea class="form-control" name="characteristic" rows="6" maxlength="2000">{{ (old('characteristic')) ? old('characteristic') : $product->characteristic }}</textarea>
    </div>
    <div class="form-group">
      <a target="_blank" href="/admin/edit-page/{{ $product->id }}" class="btn btn-primary">Редактировать страницу</a>
    </div>
    <div class="form-group">
      <label for="description">Описание</label>
      <textarea class="form-control" name="description" rows="6" maxlength="2000">{{ (old('description')) ? old('description') : $product->description }}</textarea>
    </div>
    <div class="form-group" id="gallery">
      <label>Галерея</label><br>
      <?php $images = ($product->images == true) ? unserialize($product->images) : []; ?>
      <?php $key_last = array_key_last($images); ?>
      @for ($i = 0; $i <= (($key_last >= 6) ? $key_last : 5); $i++)
        @if(array_key_exists($i, $images))
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width:300px;height:200px;">
              <img src="/img/products/{{ $product->path.'/'.$images[$i]['present_image'] }}">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
            <div>
              <span class="btn btn-default btn-sm btn-file">
                <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Изменить</span>
                <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                <input type="file" name="images[]" accept="image/*">
              </span>
              <label>
                <input type="checkbox" name="remove_images[]" value="{{ $i }}"> Удалить
              </label>
              <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
            </div>
          </div>
        @else
          <div class="fileinput fileinput-new" data-provides="fileinput">
            <div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>
            <div>
              <span class="btn btn-default btn-sm btn-file">
                <span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>
                <span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>
                <input type="file" name="images[]" accept="image/*">
              </span>
              <a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>
            </div>
          </div>
        @endif
      @endfor
    </div>
    <div>
      <button type="button" class="btn btn-success" onclick="addFileinput(this);">Добавить загрузчик</button>
    </div>
    <br>
    <div class="form-group">
      <label for="modes_id">Режим (зажмите Ctrl чтобы выбрать несколько вариантов)</label>
      <select id="modes_id" name="modes_id[]" class="form-control" size="6" multiple>
        <option value=""></option>
        @foreach($modes as $mode)
          @if ($product->modes->contains($mode->id))
            <option value="{{ $mode->id }}" selected>{{ $mode->title }}</option>
          @else
            <option value="{{ $mode->id }}">{{ $mode->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="lang">Язык</label>
      <select id="lang" name="lang" class="form-control" required>
        <option value=""></option>
        @foreach($languages as $language)
          @if ($product->lang == $language->slug)
            <option value="{{ $language->slug }}" selected>{{ $language->title }}</option>
          @else
            <option value="{{ $language->slug }}">{{ $language->title }}</option>
          @endif
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="status">Статус:</label>
      @foreach(trans('statuses.data') as $num => $status)
        <label>
          <input type="radio" id="status" name="status" value="{{ $num }}" @if ($num == $product->status) checked @endif> {{ $status }}
        </label>
      @endforeach
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">Обновить</button>
    </div>
  </form>
@endsection

@section('head')
  <link href="/joystick/css/jasny-bootstrap.min.css" rel="stylesheet">
  <script src='https://cdn.tiny.cloud/1/s9hqkvt9a9gdfym5yyaz2pgllizccjq8p71rxv2s5gp714p4/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea',
      height: 300,
      plugins: [
        'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
        'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
        'save table directionality emoticons template paste'
      ],
      content_css: ['/css/style.css', '/css/custom.css'],
      menubar: 'file edit view insert format tools table help',
      toolbar: 'insertfile undo redo | formatselect fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor removeformat | link image media | code',
      font_formats: 'Playfair Display; Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva;'

    });
  </script>
@endsection

@section('scripts')
  <script src="/joystick/js/jasny-bootstrap.js"></script>
  <script>
    function addFileinput(i) {
      var fileinput = 
        '<div class="fileinput fileinput-new" data-provides="fileinput">' +
            '<div class="fileinput-preview thumbnail" style="width:300px;height:200px;" data-trigger="fileinput"></div>' +
            '<div>' +
              '<span class="btn btn-default btn-sm btn-file">' +
                '<span class="fileinput-new"><i class="glyphicon glyphicon-folder-open"></i>&nbsp; Выбрать</span>' +
                '<span class="fileinput-exists"><i class="glyphicon glyphicon-folder-open"></i>&nbsp;</span>' +
                '<input type="file" name="images[]" accept="image/*">' +
              '</span>' +
              '<a href="#" class="btn btn-default btn-sm fileinput-exists" data-dismiss="fileinput"><i class="glyphicon glyphicon-trash"></i> Удалить</a>' +
            '</div>' +
          '</div>';

      $('#gallery').append(fileinput);
    }
  </script>
@endsection
