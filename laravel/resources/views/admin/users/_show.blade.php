<?php /** @var $users \App\News */ ?>
<tr>
    <td>
        {{$users->id}}
    </td>
    <td>
        <a target="_blank" href="{{ url("/users/{$users->id}")}}">{{$users->name}}</a>
    </td>
    <td>
        {{ isset($users->created_at) ? App\Helpers\Helper::humanize_date($users->created_at) : 'Нет даты' }}
    </td>
    <td>
        <div class="btn-group-sm">
            <a
                    href="{{ url("/admin/users/{$users->id}/edit") }}"
                    class="btn btn-light btn-group"
            >

                Редактировать
            </a>
            <a
                    href="{{ url("/admin/users/{$users->id}/delete") }}"
                    class="btn btn-danger btn-group"
            >
                Удалить
            </a>
        </div>
    </td>
</tr>

