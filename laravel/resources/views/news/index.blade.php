@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page"><a href="/">На главную</a></li>
            @if($category)
                <li class="breadcrumb-item" aria-current="page"><a href="/news">Новости</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Новости</li>
            @endif
        </ol>
    </nav>
    <div class="d-flex justify-content-between col-12">
        <h2>Последние новости</h2>
    </div>
    <br>
    <nav class="col-12 d-flex justify-content-between">
        @foreach($categories as  $category)
            <h3><a href="/news/category/{{$category->id}}">{{$category->name}}</a></h3>
        @endforeach
    </nav>
    <br>
  @include ('news/_list')
@endsection
