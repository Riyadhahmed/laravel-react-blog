<div class="pull-right hidden-xs">
    Version 1.0.0
</div>
Developed By <a href="http://www.w3xplorers.com" target="_blank">W3xplorers Bangladesh</a>
<script src="{{ asset('/assets/js/adminlte.min.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.plainoverlay.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('/assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/assets/plugins/fastclick/fastclick.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/assets/js/app.min.js') }}"></script>

<script src="{{ asset('/assets/js/bootstrap-notify.min.js') }}"></script>

<!-- Sweet Alert library -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/iCheck/flat/_all.css') }}">
<script src="{{ asset('/assets/plugins/iCheck/icheck.min.js') }}"></script>

<!-- Sweet Alert library -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/sweet-alert/sweetalert.css') }}">
<script src="{{ asset('/assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>


<!-- Datepicker library -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/datepicker/datepicker3.css') }}">
<script src="{{ asset('/assets/plugins/datepicker/bootstrap-datepicker.js') }}"></script>


<!-- Sweet Alert library -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/select2/select2.min.css') }}">
<script src="{{ asset('/assets/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('assets/js/jquery.printElement.min.js') }}"></script>
<script>
    $.fn.modal.Constructor.prototype.enforceFocus = function () {
    };
    setTimeout(function () {
        $('.alert').fadeOut('slow');
    }, 5000); // <-- time in milliseconds
</script>
<script>
    function notify_view(type, message) {
        $.notify({
            message: message
        }, {
            type: type,
            allow_dismiss: true,
            offset: {x: '30', y: '65'},
            spacing: 10,
            z_index: 1031,
            delay: 200,
            animate: {enter: 'animated fadeInDown', exit: 'animated fadeOutUp'}
        });
    }
</script>