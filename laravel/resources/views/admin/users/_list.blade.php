<table class="table table-bordered table-striped col-12">
    <thead>
       <tr>
           <td>
               ID
           </td>
           <td>
               ФИО
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
    @each('admin/users/_show', $models, 'users', 'admin/users/_empty')
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $models->links() }}
</div>
