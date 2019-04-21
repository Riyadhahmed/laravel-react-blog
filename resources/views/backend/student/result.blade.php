@extends('backend.layouts.student_master')
@section('title', 'Student Result')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> View Result </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="form-group col-md-6 col-sm-12 col-md-offset-2">
                                <select name="exam_id" id="exam_id" class="form-control" required>
                                    <option value="" selected disabled>Select a Exam</option>
                                    @foreach($exams as $exam)
                                        <option value="{{$exam->id}}">{{$exam->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group  col-xl-2 col-lg-2 col-md-2 col-sm-12 mb-3 mb-lg-0">
                                <button type="button" class="btn  btn-success form-control"
                                        onclick="generateMarksheet()">Get Marksheet
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
                </div>
            </div>
        </div>
    </div>
    <style>
        @media screen and (min-width: 768px) {
            #myModal .modal-dialog {
                width: 95%;
                border-radius: 5px;
            }
        }

        #not_found {
            margin-top: 30px;
            z-index: 0;
        }

    </style>
    <script>
        function generateMarksheet() {

            var exam_id = $("#exam_id").val();

            if (exam_id != null) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: 'generateMarksheet',
                    type: "POST",
                    data: {
                        "exam_id": exam_id,
                        "_token": CSRF_TOKEN
                    },
                    dataType: 'json',
                    beforeSend: function () {
                        $('body').plainOverlay('show');
                    },
                    success: function (data) {
                        $('body').plainOverlay('hide');
                        $("#modal_data").html(data.html);
                        $('#myModal').modal('show'); // show bootstrap modal
                    },
                    error: function (result) {
                        $('body').plainOverlay('hide');
                        $("#status").html("Sorry Cannot Load Data");
                    }
                });
            } else {
                swal("Warning!", "Please Select all field!!", "error");
            }
        }
    </script>
@stop