@extends('layouts.app')

@section('content')
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
