@can('permission-view')
    <a data-toggle='tooltip' style="display:none;" class='btn btn-info btn-xs view' id='{{$id}}' title='View'> <i
            class='fa fa-eye'></i></a>
@endcan
@can('permission-create')
    <a data-toggle='tooltip' class='btn btn-primary btn-xs edit' id='{{$id}}' title='Edit'> <i
            class='fa fa-pencil-square-o'></i></a>
@endcan
@can('permission-delete')
    <a data-toggle='tooltip' class='btn btn-danger btn-xs  delete' id='{{$id}}' title='Delete'> <i
            class='fa fa-trash-o'></i></a>
@endcan