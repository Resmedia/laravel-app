<?php /** @var $news \App\News */?>
<div class="card">
    <div class="card-body">
        <h4 class="card-title"><a href="{{ url("/news/{$news->id}")}}">{{$news->title}}</a> </h4>

        <p class="card-text">
            <small class="text-muted">
                {{ !empty($news->author) ? $news->author->name : '' }}
            </small>
        </p>
        <p class="card-text">
            @if(!empty($news->category))
            <small class="text-muted">
                <a href="{{ url("/news/category/{$news->category->id}")}}"> {{ $news->category->name }}</a>
            </small>
            @endif
        </p>
        <p class="card-text">
            <small class="text-muted">{{ App\Helpers\Helper::humanize_date($news->posted_at) }}</small>
            <br>
        </p>
    </div>
</div>