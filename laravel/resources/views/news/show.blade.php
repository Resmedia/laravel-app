@extends('layouts.app')
@include('meta::manager', [
     'title'         => $news->title,
     'description'   => 'Новости, ' . $news->title,
])

@section('content')
    <div class="post-card h-100 col-12 d-inline-block">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">
                    <a href="/">На главную</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">
                    <a href="/news">Новости</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{$news->title}}</li>
            </ol>
        </nav>
        <h1>{{ $news->title }}</h1>
        <br>
        @if(!empty($images))
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach($images as $key => $image)
                    <div class="carousel-item <?= $key == 0 ? 'active' : '' ?>">
                        <img class="d-block w-100" src="/uploads/<?= $image ?>">
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Назад</span>
            </a>
            <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Вперед</span>
            </a>
        </div>
        @endif
        <br>
        <h2 class="small">{{ !empty($news->category) ? $news->category->name : '' }}</h2>
        <br>
        <div class="mb-3">
            <small class="text-muted">{{  !empty($news->author) ? $news->author->name : ''}}</small>
            ,
            <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->posted_at) }}</small>
        </div>

        <div class="post-content">
            {!! $news->content !!}
        </div>
        <br>
        <br><br><br>
    </div>
@endsection
