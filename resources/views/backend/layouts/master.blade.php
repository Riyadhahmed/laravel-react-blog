<!DOCTYPE html>
<html>
<head>
    @include('backend.layouts.head')
</head>
<body class="hold-transition skin-green-light sidebar-mini fixed">
<div class="se-pre-con"></div>
<div class="wrapper">
    <header class="main-header">
        @include('backend.layouts.topbar')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('backend.layouts.sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{--<section class="content-header">--}}
            {{--<div class="row">--}}
                {{--<ol class="breadcrumb">--}}
                    {{--<li><a href=""><i class="fa fa-dashboard"></i>--}}
                            {{--Home</a></li>--}}
                    {{--<li class="active"></li>--}}
                {{--</ol>--}}
            {{--</div>--}}
        {{--</section>--}}
        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        @include('backend.partials.modal')
        @include('backend.layouts.footer')
        @include('backend.layouts.datatable')
    </footer>
</div>
<!-- ./wrapper -->
</body>
</html>