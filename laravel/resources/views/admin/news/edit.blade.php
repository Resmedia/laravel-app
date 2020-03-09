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

            <div class="flex-column">
                <?php foreach (Storage::files("/news/$news->id") as $image) : ?>
                <div class="align-items-center">
                    <img width="100px" src="/uploads/<?= $image ?>">
                    <div class="btn btn-link" onclick="deleteImage('<?= $image ?>')">Удалить</div>
                </div>
                <?php endforeach; ?>
            </div>

            <br/>
            <br/>
            <form method="post" action='{{ url("/admin/news/$news->id") }}' enctype="multipart/form-data">
                @method('PATCH')
                @csrf

                <?= Form::file('file') ?>

                <div class="form-group">
                    <?= Form::label('title', 'Название новости'); ?>
                    <?= Form::text('title', $news->title, ['class' => 'form-control']); ?>
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
                    <?= Form::textarea('content', $news->content, ['class' => 'form-control', 'rows' => 6]) ?>
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
                    <?= Form::select('category_id', $categories, $news->category->id, ['class' => 'form-control']); ?>
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
                    <?= Form::text('slug', $news->slug, ['class' => 'form-control']); ?>
                        @if($errors->has('slug'))
                            @foreach ($errors->get('slug') as $error)
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

<script>
    deleteImage = url => {
        $.ajax({
            method: 'POST',
            data: {
                url: url,
                "_token": "{{ csrf_token() }}"
            },
            url: '/admin/news/delete-image'
        }).then(request => {
            let data = JSON.parse(request);
            if(data.status === 200) {
                location.reload()
            } else {
                console.log(data.message);
            }
        })
    }
</script>
