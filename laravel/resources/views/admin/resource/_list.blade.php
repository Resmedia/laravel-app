<table class="table table-bordered table-striped col-12">
    <thead>
       <tr>
           <td>
               ID
           </td>
           <td>
               Название
           </td>
           <td width="230">
               Действия
           </td>
       </tr>
    </thead>
    <tbody>
    @each('admin/resource/_show', $models, 'resource', 'admin/resource/_empty')
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $models->links() }}
</div>
