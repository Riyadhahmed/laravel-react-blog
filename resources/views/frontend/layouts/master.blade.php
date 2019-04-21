<!DOCTYPE html>
<html>
<head>
    @include('frontend.layouts.head')
</head>
<body>
<div class="{{ $app_settings->layout ? '' : 'container' }}">
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>
    <!-- header section -->

    <!-- header section end-->
    <section class="main-section">
        @yield('content')
    </section>
    <!-- Footer section -->
    <footer class="footer-section">
        @include('frontend.layouts.footer')
    </footer>
</div>
</body>
</html>
