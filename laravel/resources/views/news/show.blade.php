@extends('layouts.app')
@include('meta::manager', [
     'title'         => $news->title,
     'description'   => 'Новости, ' . $news->title,
])

@section('content')
  <div class="post-card h-100 col-12 d-inline-block">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="/">На главную</a></li>
        <li class="breadcrumb-item" aria-current="page"><a href="/news">Новости</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$news->title}}</li>
      </ol>
    </nav>
    <h1>{{ $news->title }}</h1>

    <h2>{{ $news->category->name }}</h2>

    <div class="mb-3">
      <small class="text-muted">{{ $news->author->name }}</small>,
      <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->posted_at) }}</small>
    </div>

    <div class="post-content">
      {!! $news->content !!}
    </div>
  </div>
@endsection
