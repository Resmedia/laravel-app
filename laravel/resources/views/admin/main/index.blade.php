@extends('layouts.app')
@section('content')
    <main class="py-4">
        <h1>
            Вы в административной панели
        </h1>
        <a class="btn btn-success" href="{{url('/admin/news')}}">Перейти к редактированию новостей</a>
        <br/>
        <br/>
        <a class="btn btn-success" href="{{url('/admin/users')}}">Перейти к редактированию пользователей</a>
        <br/>
        <br/>
        <a class="btn btn-success" href="{{url('/admin/parser')}}">Спарсить новости</a>
        <br/>
        <br/>
        <a class="btn btn-success" href="{{url('/admin/resource')}}">RSS новостей</a>
        @yield('content')
    </main>
@endsection
