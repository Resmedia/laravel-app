@extends('layouts.app')
@section('content')
    <section id="main">
        <h1>Hello Admin</h1>

        <form action="/admin" method="POST" class="input-group">
            <input type="text" placeholder="Логин" class="form-control">
            <input type="text" placeholder="Пароль" class="form-control">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Войти</button>
            </div>
        </form>
    </section>
@endsection
