@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin">Главная административной панели</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin/news">Новости список</a>
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-5">Создание новости</h1>
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
            <form method="post" action="{{ url('/admin/news') }}" multiple>
                @method('POST')
                @csrf
                <input type="file" name="file">
                <div class="form-group">
                    <?= Form::label('title', 'Название новости'); ?>
                    <?= Form::text('title', null, ['class' => 'form-control']); ?>
                </div>

                <div class="form-group">
                    <?= Form::label('content', 'Название новости'); ?>
                    <?= Form::textarea('content', null, ['class' => 'form-control', 'rows' => 6]) ?>
                </div>

                <div class="form-group">
                    <?= Form::label('category_id', 'Категория'); ?>
                    <?= Form::select('category_id', $categories, null, ['class' => 'form-control']); ?>
                </div>
                <div class="form-group">
                    <?= Form::label('slug', 'URL новости'); ?>
                    <?= Form::text('slug', null, ['class' => 'form-control']); ?>
                </div>
                <?= Form::submit('Создать', ['class' => 'btn btn-success float-right']); ?>
            </form>
        </div>
    </div>
@endsection
