@extends('layouts.app')
@section('content')
    <main class="py-4">
        <h1>
            Вы в административной панели
        </h1>
        <a href="{{url('/admin/news')}}">Перейти к редактированию новостей</a>
        @yield('content')
    </main>
@endsection
