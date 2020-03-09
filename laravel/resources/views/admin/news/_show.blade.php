<?php /** @var $news \App\News */ ?>
<tr>
    <td>
        {{$news->id}}
    </td>
    <td>
        {{ !empty($news->author) ? $news->author->name : '' }}
    </td>
    <td>
        <a target="_blank" href="{{ url($news->getUrl()) }}">{{$news->title}}</a>
    </td>
    <td>
        {{ App\Helpers\Helper::humanize_date($news->created_at) }}
    </td>
    <td>
        <div class="btn-group-sm">
            <a
                    href="{{ url("/admin/news/{$news->id}/edit") }}"
                    class="btn btn-light btn-group"
            >
                Редактировать
            </a>
            <a
                    href="{{ url("/admin/news/{$news->id}/delete") }}"
                    class="btn btn-danger btn-group"
            >
                Удалить
            </a>
        </div>
    </td>
</tr>

