@extends('layouts.app')

@section('content')
    <br/>
    <br/>
    <br/>
    <div class="d-flex justify-content-between col-12">
        <h2>Последние новости</h2>
    </div>
  @include ('news/_list')
@endsection
