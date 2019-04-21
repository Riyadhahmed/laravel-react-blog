<a class="btn btn-xs btn-default" data-toggle='tooltip' title='Download'
   href="{{ URL :: to('admin/backups/download/'.$file_name) }}"><i
        class="fa fa-cloud-download"></i></a>
<a class="btn btn-xs btn-danger delete" data-button-type="delete" data-toggle='tooltip' title='Delete'
   id="{{$file_name}}"><i class="fa fa-trash-o"></i>
    </a>