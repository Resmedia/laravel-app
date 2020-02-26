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
            <h1 class="display-5">Обновление новости</h1>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <br/>
            @endif
            <form method="post" action='{{ url("/admin/news/update/$news->id") }}' enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <?php foreach (Storage::files("public/uploads/news/$news->id") as $image) : ?>
                <img width="100px" src="/<?= $image ?>">
                <div onclick="deleteImage('<?= $image ?>')" >Удалить</div>
                <?php endforeach; ?>

                <?= Form::file('file') ?>

                <div class="form-group">
                    <?= Form::label('title', 'Название новости'); ?>
                    <?= Form::text('title', $news->title, ['class' => 'form-control']); ?>
                </div>

                <div class="form-group">
                    <?= Form::label('content', 'Название новости'); ?>
                    <?= Form::textarea('content', $news->content, ['class' => 'form-control', 'rows' => 6]) ?>
                </div>

                <div class="form-group">
                    <?= Form::label('category_id', 'Категория'); ?>
                    <?= Form::select('category_id', $categories, $news->category->id, ['class' => 'form-control']); ?>
                </div>
                <div class="form-group">
                    <?= Form::label('slug', 'URL новости'); ?>
                    <?= Form::text('slug', $news->slug, ['class' => 'form-control']); ?>
                </div>
                <?= Form::submit('Обновить', ['class' => 'btn btn-success float-right']); ?>
            </form>
        </div>
    </div>
@endsection

<script>
    deleteImage = $url => {
        $.ajax({
            method: 'GET',
            data: $url,
            url: '/admin/news/delete-image'
        })
    }
</script>
