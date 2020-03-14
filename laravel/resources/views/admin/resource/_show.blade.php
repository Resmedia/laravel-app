<?php /** @var $resource \App\Resource */ ?>
<tr>
    <td>
        {{$resource->id}}
    </td>
    <td>
        {{$resource->name}}
    </td>
    <td>
        <div class="btn-group-sm">
            <a
                    href="{{ url("/admin/resource/{$resource->id}/edit") }}"
                    class="btn btn-light btn-group"
            >
                Редактировать
            </a>
            <a
                    href="{{ url("/admin/resource/{$resource->id}/delete") }}"
                    class="btn btn-danger btn-group"
            >
                Удалить
            </a>
        </div>
    </td>
</tr>

