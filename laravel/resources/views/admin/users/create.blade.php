@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin">Главная административной панели</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin/users">Пользователи список</a>
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-5">Создание пользователя</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br />
            @endif
            <form method="post" action='{{ url("/admin/users/create") }}' enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <?= Form::file('file') ?>

                <div class="form-group">
                    <?= Form::label('name', 'ФИО'); ?>
                    <?= Form::text('name', '', ['class' => 'form-control']); ?>
                </div>

                <div class="form-group">
                    <?= Form::label('email', 'Email'); ?>
                    <?= Form::text('email', '', ['class' => 'form-control']) ?>
                </div>

                <div class="form-group">
                    <?= Form::label('rule', 'Права'); ?>
                    <?= Form::select('rule', $rules, '', ['class' => 'form-control']); ?>
                </div>
                <div class="form-group">
                    <?= Form::label('newPassword', 'Новый пароль'); ?>
                    <?= Form::text('newPassword', '', ['class' => 'form-control']); ?>
                </div>
                <?= Form::submit('Создать', ['class' => 'btn btn-success float-right']); ?>
            </form>
        </div>
    </div>
@endsection
