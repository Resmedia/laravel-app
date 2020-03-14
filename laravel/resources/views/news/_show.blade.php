<?php /** @var $news \App\News */?>
<div class="card">
    @if (!empty(Storage::files("/news/$news->id")))
        <img alt="image" class="card-img-top" src="/uploads/<?= Storage::files("/news/$news->id")[0] ?>">
    @endif
    @if ($news->image && empty(Storage::files("/news/$news->id")))
        <img alt="image" class="card-img-top" src="<?= $news->image ?>">
    @endif
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ url($news->getUrl())}}">{{$news->title}}</a>
        </h5>
        <div class="card-text">
            <small class="text-muted">
                {{ !empty($news->author) ? $news->author->name : '' }}
            </small>
            @if(!empty($news->category))
                <div class="text-muted">
                    Категория: <a href="{{ url("/news/category/{$news->category->id}")}}">
                        {{ $news->category->name }}
                    </a>
                </div>
            @endif
        </div>
        <div class="col-12">
            <div class="row justify-content-between align-items-lg-center">
                <a class="btn btn-primary" href="{{ url($news->getUrl()) }}">Подробнее</a>
                <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->created_at) }}</small>
            </div>
        </div>
    </div>
</div>