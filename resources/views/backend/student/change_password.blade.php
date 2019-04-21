@extends('backend.layouts.student_master')
@section('title', 'Change Password')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Change Password</p>
                </div>
                <div class="box-body">
                    <div class="row">
                        <form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div id="status"></div>
                            {{method_field('PATCH')}}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for=""> New Password </label>
                                <input type="password" class="form-control" id="password" name="password" value=""
                                       placeholder="Type New Password" required>
                                <span id="error_name" class="has-error"></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success" id="submit"><span
                                        class="fa fa-save fa-fw"></span> Save
                                </button>
                            </div>
                            <div class="clearfix"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function () {

            $('#loader').hide();

            $('#edit').validate({// <- attach '.validate()' to your form
                // Rules for form validation
                rules: {
                    password: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                // Messages for form validation
                messages: {
                    name: {
                        required: 'Enter name'
                    }
                },
                submitHandler: function (form) {

                    var myData = new FormData($("#edit")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);

                    $.ajax({
                        url: 'change_password',
                        type: 'POST',
                        data: myData,
                        dataType: 'json',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function () {
                            $('#loader').show();
                            $("#submit").prop('disabled', true); // disable button
                        },
                        success: function (data) {
                            if (data.type === 'success') {
                                notify_view(data.type, data.message);
                                $('#loader').hide();
                                $("#submit").prop('disabled', false); // disable button
                                $("html, body").animate({scrollTop: 0}, "slow");
                                $('#myModal').modal('hide'); // hide bootstrap modal
                                $('.has-error').html('');

                            } else if (data.type === 'error') {
                                $('.has-error').html('');
                                if (data.errors) {
                                    $.each(data.errors, function (key, val) {
                                        $('#error_' + key).html(val);
                                    });
                                }
                                $("#status").html(data.message);
                                $('#loader').hide();
                                $("#submit").prop('disabled', false); // disable button

                            }
                        }
                    });
                }
                // <- end 'submitHandler' callback
            });                    // <- end '.validate()'

        });
    </script>
@endsection
