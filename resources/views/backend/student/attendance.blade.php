@extends('backend.layouts.student_master')
@section('title', 'Attendance Reports')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Attendance </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group col-md-4 col-sm-12 col-md-offset-4">
                                <select name="month" id="month" class="form-control">
                                    <option value="">Select month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="form-group  col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 mb-lg-0">
                                <button type="button" class="btn  btn-success form-control"
                                        onclick="getMonthlyReports()">Filter
                                </button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="not_found">
                                <img src="{{asset('assets/images/empty_box.png')}}" width="200px">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="attendance_content"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 55%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }

    </style>
    <script>
        document.body.classList.add("sidebar-collapse");
        $(document).ready(function () {
            var div = document.getElementById('attendance_content');
            div.style.visibility = 'hidden';
        });

        function getMonthlyReports() {
            var month = $("#month").val();

            if (month != '') {

                var div = document.getElementById('attendance_content');
                div.style.visibility = 'visible';
                $('#manage_all').DataTable().clear();
                $('#manage_all').DataTable().destroy();


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: 'attendance',
                    type: "POST",
                    data: {
                        "month": month,
                        "_token": CSRF_TOKEN
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        $("#attendance_content").html(data.html);
                    },
                    error: function (result) {
                        $("#attendance_content").html("Sorry Cannot Load Data");
                    }
                });
            } else {
                swal("Warning!", "Please Select all field!!", "error");
            }
        }
    </script>

    <script type="text/javascript">


        function get_sections(val) {
            $("#section_id").empty();
            $.ajax({
                type: 'GET',
                url: 'getSections/' + val,
                success: function (data) {
                    $("#section_id").html(data);
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });
        }

        function reload_table() {
            table.ajax.reload(null, false); //reload datatable ajax
        }


        function create() {

            $("#modal_data").empty();
            $('.modal-title').text('Add New Attendance'); // Set Title to Bootstrap modal title

            $.ajax({
                type: 'GET',
                url: 'attendances/create',
                success: function (data) {
                    $("#modal_data").html(data.html);
                    $('#myModal').modal('show'); // show bootstrap modal
                },
                error: function (result) {
                    $("#modal_data").html("Sorry Cannot Load Data");
                }
            });

        }


        $("#manage_all").on("click", ".edit", function () {

            $("#modal_data").empty();
            $('.modal-title').text('Edit Attendance'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'attendances/' + id + '/edit',
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
            $('.modal-title').text('View Attendance'); // Set Title to Bootstrap modal title

            var id = $(this).attr('id');

            $.ajax({
                url: 'attendances/' + id,
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
    <script type="text/javascript">

        $(document).ready(function () {

            $("#manage_all").on("click", ".delete", function () {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var id = $(this).attr('id');
                swal({
                    title: "Are you sure",
                    text: "Deleted data cannot be recovered!!",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    showLoaderOnConfirm: true,
                    confirmButtonAttendance: "btn-danger",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel"
                }, function () {
                    $.ajax({
                        url: 'attendances/' + id,
                        data: {"_token": CSRF_TOKEN},
                        type: 'DELETE',
                        dataType: 'json',
                        success: function (data) {

                            if (data.type === 'success') {

                                swal("Done!", "Successfully Deleted", "success");
                                reload_table();

                            } else if (data.type === 'danger') {

                                swal("Error deleting!", "Try again", "error");

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            swal("Error deleting!", "Try again", "error");
                        }
                    });
                });
            });
        });

    </script>
@stop