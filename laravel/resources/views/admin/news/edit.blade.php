@extends('layouts.app')
@section('content')
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
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
                        <textarea id="content" name="content" class="form-control">
                            {!! old('content', $news->content) !!}
                        </textarea>
                        <script>
                            CKEDITOR.on('instanceReady', function (ev) {
                                ev.editor.on('paste', function (evt) {
                                    evt.data.dataValue = stripTags(evt.data.dataValue, // Clean all. Tag allowed list
                                        '<i>' +
                                        '<s>' +
                                        '<em>' +
                                        '<b>' +
                                        '<p>' +
                                        '<br>' +
                                        '<hr>' +
                                        '<ul>' +
                                        '<li>' +
                                        '<ol>' +
                                        '<a>' +
                                        '<td>' +
                                        '<tr>' +
                                        '<div>' +
                                        '<table>' +
                                        '<tbody>' +
                                        '<thead>' +
                                        '<strong>' +
                                        '<blockquote>'
                                    );
                                    evt.data.dataValue = evt.data.dataValue.replace(/&nbsp;/g, ' '); // remove spaces &nbsp
                                    evt.data.dataValue = evt.data.dataValue.replace(/<p><\/p>/g, '<br/>'); // Replace empty <p> to <br/>
                                    evt.data.dataValue = evt.data.dataValue.replace(/style=*/g, ''); // Remove all styles
                                    evt.data.dataValue = evt.data.dataValue.replace(/align=*/g, ''); // Remove all algins
                                    evt.data.dataValue = evt.data.dataValue.replace(/height=*/g, ''); // Remove all height
                                    evt.data.dataValue = evt.data.dataValue.replace(/width=*/g, ''); // Remove all width
                                }, null, null, 9);
                            });

                            CKEDITOR.editorConfig = function (config) {
                                config.allowedContent = true;
                                config.disallowedContent = 'span';
                                config.removeFormatTags = 'span;';
                                config.uiColor = '#f2f2f2';
                                config.scayt_autoStartup = false;
                                config.format_tags = 'h3;h4;h5;pre';
                                config.toolbarCanCollapse = true;

                                config.toolbar = [
                                    {name: 'tools', items: ['Source', 'Maximize', 'RemoveFormat', 'ShowBlocks', 'Find', '-', 'Undo', 'Redo']},
                                    {
                                        name: 'clipboard',
                                        groups: ['clipboard', 'undo'],
                                    },
                                    {name: 'links', items: ['Link', 'Unlink', 'Anchor', '-', 'Image']},
                                    {name: 'document', groups: ['mode', 'document', 'doctools']},
                                    {name: 'insert', items: ['Table', 'HorizontalRule', 'SpecialChar', 'Iframe']},

                                    {
                                        name: 'basicstyles',
                                        groups: ['basicstyles', 'cleanup'],
                                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-']
                                    },
                                    {
                                        name: 'paragraph',
                                        groups: ['list', 'indent', 'blocks', 'align'],
                                        items: [
                                            'JustifyLeft', 'JustifyCenter',
                                            'JustifyRight', 'JustifyBlock', '-',
                                            'NumberedList',
                                            'BulletedList', '-',
                                            'Outdent', 'Indent', '-',
                                            'Blockquote', 'CreateDiv', '-',
                                        ]
                                    },

                                    {name: 'styles', items: ['Format', 'FontSize']},
                                    {name: 'colors', items: ['TextColor', 'BGColor']},
                                ];
                            };

                            let options = {
                                filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
                                filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
                                filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
                                filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
                            };

                            CKEDITOR.replace('content', options);

                            function stripTags(input, allowed) {
                                allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
                                let tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
                                let commentsAndPhpTags = /<![\s\S]*?>|<\?(?:php)?[\s\S]*?\?>/gi;
                                return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
                                    return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
                                });
                            }
                        </script>
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
