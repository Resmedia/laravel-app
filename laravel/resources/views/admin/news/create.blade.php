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
            <script src={{ url('/js/synctranslit.js') }}></script>
            <h1 class="display-5">Создание новости</h1>

            <form method="post" action="{{ url('/admin/news') }}" multiple>
                @method('POST')
                @csrf

                <?= Form::file('file') ?>

                <div class="form-group">
                    <?= Form::label('title', 'Название новости'); ?>
                    <?= Form::text('title', null, ['class' => 'form-control']); ?>
                        @if($errors->has('title'))
                            @foreach ($errors->get('title') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="form-group">
                    <?= Form::label('content', 'Текст новости'); ?>
                    <?= Form::textarea('content', null, ['class' => 'form-control', 'rows' => 6]) ?>
                        @if($errors->has('content'))
                            @foreach ($errors->get('content') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="form-group">
                    <?= Form::label('category_id', 'Категория'); ?>
                    <?= Form::select('category_id', $categories, null, ['class' => 'form-control']); ?>
                        @if($errors->has('category_id'))
                            @foreach ($errors->get('category_id') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>
                <div class="form-group">
                    <?= Form::label('slug', 'URL новости'); ?>
                    <?= Form::text('slug', null, ['class' => 'form-control']); ?>
                        @if($errors->has('slug'))
                            @foreach ($errors->get('slug') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>
                <?= Form::submit('Создать', ['class' => 'btn btn-success float-right']); ?>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(() => $('#title').syncTranslit({destination: 'slug'}));
    </script>
@endsection
