@extends('layouts.app')

@section('content')
  <div class="bg-white post-card h-100 col-12 d-inline-block" style="padding: 40vh 30px;">
    <h1>{{ $news->title }}</h1>

    <div class="mb-3">
      <small class="text-muted">{{ $news->author->name }}</small>,
      <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->posted_at) }}</small>
    </div>

    <div class="post-content">
      {!! $news->content !!}
    </div>
  </div>
@endsection
