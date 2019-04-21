{!! Form::model($settings, ['method' => 'PATCH','id'=>'edit']) !!}
<div id="status"></div>
<div class="form-group col-xs-12 col-sm-12 col-md-6">
    <strong>Name</strong>
    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
    <span id="error_name" class="has-error"></span>
</div>
<div class="form-groupcol-xs-12 col-sm-12 col-md-6">
    <strong>Slogan</strong>
    {!! Form::text('slogan', null, array('placeholder' => 'Slogan','class' => 'form-control')) !!}
    <span id="error_slogan" class="has-error"></span>
</div>
<div class="clearfix"></div>
<div class="form-group col-xs-12 col-sm-12 col-md-3">
    <strong>Contact</strong>
    {!! Form::text('contact', null, array('placeholder' => 'Name','class' => 'form-control', 'required')) !!}
    <span id="error_contact" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-3">
    <strong>Email:</strong>
    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control', 'required')) !!}
    <span id="error_email" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-3">
    <strong>Registration:</strong>
    {!! Form::text('reg', null, array('placeholder' => 'Registration','class' => 'form-control', 'required')) !!}
    <span id="error_reg" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-3">
    <strong>Stablished Year:</strong>
    {!! Form::text('stablished', null, array('placeholder' => 'Stablished Year','class' => 'form-control', 'required')) !!}
    <span id="error_stablished" class="has-error"></span>
</div>
<div class="clearfix"></div>
<div class="form-group col-xs-12 col-sm-12 col-md-5">
    <strong>Address</strong>
    {!! Form::text('address', null, array('placeholder' => 'Address','class' => 'form-control', 'required')) !!}
    <span id="error_address" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-2">
    <strong>Running Session</strong>
    <select name="running_year" class="form-control">
        <option value="">Running Session</option>
        @for($i = 0; $i < 10; $i++)
            <option value="{{ 2018+$i }}-{{ 2018+$i+1 }}"
            @if($app_settings->running_year == (2018+$i).'-'.(2018+$i+1)) {{ 'selected' }} @endif>
                {{ 2018+$i }}-{{ 2018+$i+1 }}
            </option>
        @endfor
    </select><span id="error_address" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-3">
    <strong>Website:</strong>
    {!! Form::text('website', null, array('placeholder' => 'Website','class' => 'form-control', 'required')) !!}
    <span id="error_stablished" class="has-error"></span>
</div>
<div class="form-group col-xs-12 col-sm-12 col-md-2">
    <strong>Website Layout</strong>
    <select name="layout" id="layout" class="form-control">
        <option value="{{ $settings->layout}}">{{ $settings->layout ? 'Fullwidth' : 'Boxed' }}</option>
        <option value="1">Fullwidth</option>
        <option value="0">Boxed</option>
    </select>
    <span id="error_layout" class="has-error"></span>
</div>
<div class="clearfix"></div>
<div class="col-md-12">
    <label for="logo">Upload Image</label>
    <input id="logo" type="file" name="logo" style="display:none">
    <div class="input-group">
        <div class="input-group-btn">
            <a class="btn btn-success" onclick="$('input[id=logo]').click();">Browse</a>

        </div><!-- /btn-group -->

        <input type="text" name="SelectedFileName" class="form-control" id="SelectedFileName"
               value="{{$settings->logo}}" readonly>

    </div>
    <div style="clear:both;"></div>
    <p class="help-block">File Extention must be jpg, jpeg, png. </p>
    <span id="error_photo" class="has-error"></span>
    <script type="text/javascript">
        $('input[id=logo]').change(function () {
            $('#SelectedFileName').val($(this).val());
        });
    </script>
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
    $("#layout option").val(function (idx, val) {
        $(this).siblings("[value='" + this.value + "']").remove();
        return val;
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
                    required: 'Please enter name'
                }

            },
            submitHandler: function (form) {

                var myData = new FormData($("#edit")[0]);
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                myData.append('_token', CSRF_TOKEN);

                $.ajax({
                    url: 'settings/' + '{{ $settings->id }}',
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
            }
            // <- end 'submitHandler' callback
        });                    // <- end '.validate()'

    });
</script>