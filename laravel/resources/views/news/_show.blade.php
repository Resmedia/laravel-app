<?php /** @var $news \App\News */?>
<div class="card">
    @if (!empty(Storage::files("/news/$news->id")))
        <img alt="image" class="card-img-top" src="/uploads/<?= Storage::files("/news/$news->id")[0] ?>">
    @endif
    <div class="card-body">
        <h5 class="card-title"><a href="{{ url("/news/{$news->id}")}}">{{$news->title}}</a></h5>
        <p class="card-text">
            <small class="text-muted">
                {{ !empty($news->author) ? $news->author->name : '' }}
            </small>
            @if(!empty($news->category))
                <div class="text-muted">
                    Категория: <a href="{{ url("/news/category/{$news->category->id}")}}">{{ $news->category->name }}</a>
                </div>
            @endif
        </p>
        <div class="col-12">
            <div class="row justify-content-between align-items-lg-center">
                <a class="btn btn-primary" href="{{ url("/news/{$news->id}")}}">Подробнее</a>
                <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->posted_at) }}</small>
            </div>
        </div>
    </div>
</div>