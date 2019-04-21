@can('settings-view')
    <a data-toggle='tooltip' class='btn btn-info btn-xs view' id='{{$id}}' title='View'> <i
            class='fa fa-eye'></i></a>
@endcan
@can('settings-edit')
    <a data-toggle='tooltip' class='btn btn-primary btn-xs edit' id='{{$id}}' title='Edit'> <i
            class='fa fa-pencil-square-o'></i></a>
@endcan