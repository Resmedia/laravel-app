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
            <h1 class="display-5">Обновление пользователя</h1>

            <div class="flex-column">
                <?php foreach (Storage::files("/users/$user->id") as $image) : ?>
                <div class="align-items-center">
                    <img width="100px" src="/uploads/<?= $image ?>">
                    <div class="btn btn-link" onclick="deleteImage('<?= $image ?>')">Удалить</div>
                </div>
                <?php endforeach; ?>
            </div>

            <br/>
            <br/>
            <form method="post" action='{{ url("/admin/users/$user->id") }}' enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <?= Form::file('file') ?>

                <div class="form-group">
                    <?= Form::label('name', 'ФИО'); ?>
                    <?= Form::text('name', $user->name, ['class' => 'form-control']); ?>
                        @if($errors->has('name'))
                            @foreach ($errors->get('name') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="form-group">
                    <?= Form::label('email', 'Email'); ?>
                    <?= Form::text('email', $user->email, ['class' => 'form-control']) ?>
                        @if($errors->has('email'))
                            @foreach ($errors->get('email') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>

                <div class="form-group">
                    <?= Form::label('rules', 'Права'); ?>
                    <?= Form::select('rules', $rules, $user->rules, ['class' => 'form-control']); ?>
                        @if($errors->has('rules'))
                            @foreach ($errors->get('rules') as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                </div>
                <div class="form-group">
                    <?= Form::label('newPassword', 'Новый пароль'); ?>
                    <?= Form::text('newPassword', '', ['class' => 'form-control']); ?>
                        @if($errors->has('newPassword'))
                            @foreach ($errors->get('newPassword') as $error)
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
            url: '/admin/users/delete-image'
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
