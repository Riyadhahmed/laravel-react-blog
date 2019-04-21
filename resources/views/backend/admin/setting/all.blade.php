@extends('backend.layouts.master')
@section('title', ' All Settings')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Settings </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="manage_all" class="table table-collapse table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Layout</th>
                                    <th>Running Year</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 75%;
                border-radius: 5px;
            }
        }
    </style>
    <script>
        $(function () {
            table = $('#manage_all').DataTable({

                processing: true,
                serverSide: true,
                ajax: '{!! route('admin.allSetting.settings') !!}',
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'layout', name: 'layout'},
                    {data: 'running_year', name: 'running_year'},
                    {data: 'action', name: 'action'}
                ],
                "autoWidth": false,
            });
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });

        });
    </script>
    <script type="text/javascript">

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }


        $("#manage_all").on("click", ".edit", function () {

            $("#modal_data").empty();
            $('.modal-title').text('Edit Setting'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'settings/' + id + '/edit',
                type: 'get',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        });

        $("#manage_all").on("click", ".view", function () {

            $("#modal_data").empty();
            $('.modal-title').text('View Setting'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'settings/' + id,
                type: 'get',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        });

    </script>
@stop
