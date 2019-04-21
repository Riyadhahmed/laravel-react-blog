@extends('backend.layouts.student_master')
@section('title', 'Syllabus')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Syllabus</p>
                </div>
                <div class="box-body">
                    <div class="row" id="syllabus_content">
                        <div class="col-md-12 col-sm-12 table-responsive">
                            <table id="manage_all" class="table table-collapse table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Class</th>
                                    <th>Title</th>
                                    <th>Subject</th>
                                    <th>Syllabus</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            table = $('#manage_all').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 25,
                ajax: '{!! route('student.getSyllabus.syllabus') !!}',
                columns: [
                    {data: 'rownum', name: 'rownum'},
                    {data: 'class', name: 'class'},
                    {data: 'title', name: 'title'},
                    {data: 'subject', name: 'subject'},
                    {data: 'file_path', name: 'file_path'}
                ],
                "columnDefs": [
                    {"className": "text-center", "targets": "_all"}
                ],
                "autoWidth": false,
            });
            $('.dataTables_filter input[type="search"]').attr('placeholder', 'Type here to search...').css({
                'width': '220px',
                'height': '30px'
            });
        });
    </script>
@endsection
