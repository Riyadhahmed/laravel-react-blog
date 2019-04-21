{!! Form::model($user, ['method' => 'PATCH','id'=>'edit']) !!}
<div id="status"></div>
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Name:</strong>
        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
    </div>
    <span id="error_name" class="has-error"></span>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Email:</strong>
        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required')) !!}
    </div>
    <span id="error_email" class="has-error"></span>
</div>
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Password:</strong>
        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','required')) !!}
    </div>
    <span id="error_password" class="has-error"></span>
</div>
<div class="col-xs-12 col-sm-12 col-md-6">
    <div class="form-group">
        <strong>Confirm Password:</strong>
        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control','required')) !!}
    </div>
    <span id="error_confirm-password" class="has-error"></span>
</div>
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-12 col-md-12">
    <strong>Assign Role:</strong> <br/><br/>
    <div class='form-group'>
        @foreach ($roles as $role)
            {{ Form::checkbox('roles[]',  $role->id, $user->roles, array('class'=>'data-check flat-green') ) }}
            {{ Form::label($role->name, ucfirst($role->name)) }}
        @endforeach
    </div>
</div>
<div class="clearfix"></div>
<div class="form-group col-md-12">
    <button type="submit" class="btn btn-success button-submit"
            data-loading-text="Loading..."><span class="fa fa-save fa-fw"></span> Save
    </button>
    <button type="button" class="btn btn-default" data-dismiss="modal"><span
            class="fa fa-times-circle fa-fw"></span> Cancel
    </button>
</div>
<div class="clearfix"></div>
{!! Form::close() !!}


<script>
    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });
    $(document).ready(function () {
        $('#loader').hide();
        $('#edit').validate({// <- attach '.validate()' to your form
            // Rules for form validation
            rules: {
                name: {
                    required: true
                }
            },
            // Messages for form validation
            messages: {
                name: {
                    required: 'Enter User Name'
                }
            },
            submitHandler: function (form) {

                var list_id = [];
                $(".data-check:checked").each(function () {
                    list_id.push(this.value);
                });
                if (list_id.length > 0) {

                    //  var title = $("#msg_title").val();
                    //  var details = $("#msg_details").val();

                    var myData = new FormData($("#edit")[0]);
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    myData.append('_token', CSRF_TOKEN);
                    // myData.append('roles', list_id);


                    swal({
                        title: "Confirm to assign " + list_id.length + " roles",
                        text: "Assign roles to this user!",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "Yes, Assign!"
                    }, function () {

                        $.ajax({
                            url: 'users/' + '{{ $user->id }}',
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
                                    swal("Done!", "It was succesfully done!", "success");
                                    reload_table();
                                    notify_view(data.type, data.message);
                                    $('#loader').hide();
                                    $("#submit").prop('disabled', false); // disable button
                                    $("html, body").animate({scrollTop: 0}, "slow");
                                    $('#myModal').modal('hide'); // hide bootstrap modal

                                } else if (data.type === 'error') {
                                    if (data.errors) {
                                        $.each(data.errors, function (key, val) {
                                            $('#error_' + key).html(val);
                                        });
                                    }
                                    $("#status").html(data.message);
                                    $('#loader').hide();
                                    $("#submit").prop('disabled', false); // disable button
                                    swal("Error sending!", "Please try again", "error");

                                }

                            }
                        });
                    });

                }
                else {
                    swal("", "Please select a role!", "warning");
                }

            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>