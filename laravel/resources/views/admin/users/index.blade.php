@extends('layouts.app')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="/admin">Главная административной панели</a>
            </li>
        </ol>
    </nav>
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="panel-title col-12">
        <a href="{{url('/admin/users/create')}}" class="btn float-right btn-success">Создать пользователя</a>
        <br/><br/>
    </div>
    @include ('admin/users/_list')
@endsection
