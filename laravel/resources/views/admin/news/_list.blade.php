<table class="table table-bordered table-striped col-12">
    <thead>
       <tr>
           <td>
               ID
           </td>
           <td>
               Автор
           </td>
           <td>
               Название
           </td>
           <td>
               Дата
           </td>
           <td width="230">
               Действия
           </td>
       </tr>
    </thead>
    <tbody>
    @each('admin/news/_show', $models, 'news', 'admin/news/_empty')
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $models->links() }}
</div>
