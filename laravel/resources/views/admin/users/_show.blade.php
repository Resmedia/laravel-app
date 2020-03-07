<?php /** @var $users \App\News */ ?>
<tr>
    <td>
        {{$users->id}}
    </td>
    <td>
        <a target="_blank" href="{{ url("/users/{$users->id}")}}">{{$users->name}}</a>
    </td>
    <td>
        {{ App\Helpers\Helper::humanize_date($users->created_at) }}
    </td>
    <td>
        <div class="btn-group-sm">
            <a
                    href="{{ url("/admin/users/edit/{$users->id}") }}"
                    class="btn btn-light btn-group"
            >

                Редактировать
            </a>
            <a
                    href="{{ url("/admin/users/delete/{$users->id}") }}"
                    class="btn btn-danger btn-group"
            >
                Удалить
            </a>
        </div>
    </td>
</tr>

