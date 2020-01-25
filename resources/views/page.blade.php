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
            <li class="breadcrumb-item active">{{ $page->title }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- content-wraper start -->
  <div class="content-wraper">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          {!! $page->content !!}
        </div>
      </div>
    </div>
  </div>

@endsection


@section('scripts')

@endsection