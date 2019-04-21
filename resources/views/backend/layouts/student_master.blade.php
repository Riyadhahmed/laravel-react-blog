<!DOCTYPE html>
<html>
<head>
    @include('backend.layouts.head')
</head>
<body class="hold-transition skin-green-light sidebar-mini fixed">
<div class="se-pre-con"></div>
<div class="wrapper">
    <header class="main-header">
        @include('backend.layouts.student_topbar')
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        @include('backend.layouts.student_sidebar')
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
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