@extends('layouts.app')
@section('content')
    <main class="py-4">
        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <h1>
            Изменение учетных данных
        </h1>
      <form method="post" action="{{ url('/admin/account') }}">
          @csrf
          <div class="form-group">
              <?= Form::text('name', $model->name, ['class' => 'form-control']) ?>
              @if($errors->has('name'))
                  @foreach ($errors->get('name') as $error)
                      <div class="alert alert-danger" role="alert">
                          {{ $error }}
                      </div>
                  @endforeach
              @endif
          </div>
          <div class="form-group">
              <?= Form::text('email', $model->email, ['class' => 'form-control']) ?>
              @if($errors->has('email'))
                  @foreach ($errors->get('email') as $error)
                      <div class="alert alert-danger" role="alert">
                          {{ $error }}
                      </div>
                  @endforeach
              @endif
          </div>
          <div class="form-group">
              <?= Form::text('oldPassword', '', ['class' => 'form-control', 'placeholder' => 'Введите старый пароль']) ?>
              @if($errors->has('oldPassword'))
                  @foreach ($errors->get('oldPassword') as $error)
                      <div class="alert alert-danger" role="alert">
                          {{ $error }}
                      </div>
                  @endforeach
              @endif
          </div>
          <div class="form-group">
              <?= Form::text('newPassword', '', ['class' => 'form-control', 'placeholder' => 'Введите новый пароль']) ?>
              @if($errors->has('newPassword'))
                  @foreach ($errors->get('newPassword') as $error)
                      <div class="alert alert-danger" role="alert">
                          {{ $error }}
                      </div>
                  @endforeach
              @endif
          </div>

          <?= Form::submit('Изменить', ['class' => 'btn float-right btn-success']) ?>
      </form>
    </main>
@endsection
