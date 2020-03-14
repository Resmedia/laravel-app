@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin">Главная административной панели</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin/resource">RSS список</a>
            </li>
        </ol>
    </nav>
    <div class="row">
        <div class="col-sm-8 offset-sm-2">
            <h1 class="display-5">Обновление RSS каналпа</h1>
            
            <form method="post" action='{{ url("/admin/resource/$resource->id") }}' enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                
                <div class="form-group">
                    <?= Form::label('name', 'Название ленты'); ?>
                    <?= Form::text('name', $resource->name, ['class' => 'form-control']); ?>
                        @if($errors->has('name'))
                            @foreach ($errors->get('name') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="form-group">
                    <?= Form::label('url', 'URL RSS'); ?>
                    <?= Form::text('url', $resource->url, ['class' => 'form-control']); ?>
                        @if($errors->has('url'))
                            @foreach ($errors->get('url') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>
                <?= Form::submit('Обновить', ['class' => 'btn btn-success float-right']); ?>
            </form>
        </div>
    </div>
@endsection
