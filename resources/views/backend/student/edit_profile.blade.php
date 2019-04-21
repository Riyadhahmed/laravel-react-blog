@extends('backend.layouts.student_master')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Update Profile</p>
                </div>
                <div class="box-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="row">
                        <form id='edit' action="" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div id="status"></div>
                            {{method_field('PATCH')}}
                            <div class="form-group col-md-6 col-sm-12">
                                <label for=""> Student Name </label>
                                <input type="text" class="form-control" id="name" name="name" value="{{$student->name}}"
                                       placeholder="" required>
                                <span id="error_name" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Student ID </label>
                                <input type="text" class="form-control" id="std_code" name="std_code"
                                       value="{{$student->std_code}}"
                                       placeholder="" required readonly>
                                <span id="error_std_code" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Gender </label>
                                <select name="gender" class="form-control">
                                    <option value="{{$student->gender}}">{{$student->gender}}</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <span id="error_gender" class="has-error"></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Religion </label>
                                <select name="religion" class="form-control">
                                    <option value="{{$student->religion}}">{{$student->religion}}</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddhist">Buddhist</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Others">Others</option>
                                </select>
                                <span id="error_religion" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Date of Birth </label>
                                <input type="text" class="form-control" id="dob" name="dob"
                                       value="{{$student->dob}}"/>
                                <span id="error_dob" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Blood Group </label>
                                <input type="text" class="form-control" id="blood_group" name="blood_group"
                                       value="{{$student->blood_group}}"
                                       placeholder="">
                                <span id="error_blood_group" class="has-error"></span>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for=""> Contact </label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                       value="{{$student->phone}}"
                                       placeholder="" required>
                                <span id="error_phone" class="has-error"></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-12 col-sm-12">
                                <label for=""> Address </label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{$student->address}}"
                                       placeholder="">
                                <span id="error_address" class="has-error"></span>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for=""> Email </label>
                                <input type="text" class="form-control" id="email" name="email"
                                       value="{{$student->email}}"
                                       placeholder="">
                                <span id="error_email" class="has-error"></span>
                            </div>
                            <div class="col-md-8">
                                <label for="photo">Upload Image</label>
                                <input id="photo" type="file" name="photo" style="display:none">
                                <div class="input-group">
                                    <div class="input-group-btn">
                                        <a class="btn btn-success" onclick="$('input[id=photo]').click();">Browse</a>
                                    </div><!-- /btn-group -->
                                    <input type="text" name="SelectedFileName" class="form-control"
                                           id="SelectedFileName"
                                           value="{{$student->file_path}}" readonly>
                                </div>
                                @if ($errors->has('photo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file_path') }}</strong>
                                     </span>
                                @endif

                                <div class="clearfix"></div>
                                <p class="help-block">File must be jpg, jpeg, png.</p>
                                <script type="text/javascript">
                                    $('input[id=photo]').change(function () {
                                        $('#SelectedFileName').val($(this).val());
                                    });
                                </script>
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

            $('#dob').datepicker({format: "yyyy-mm-dd"}).on('changeDate', function (e) {
                $(this).datepicker('hide');
            });
            $('#loader').hide();

            $('#edit').validate({// <- attach '.validate()' to your form
                // Rules for form validation
                rules: {
                    name: {
                        required: true
                    },
                    phone: {
                        required: true,
                        number: true
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
                        url: 'edit_profile',
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
