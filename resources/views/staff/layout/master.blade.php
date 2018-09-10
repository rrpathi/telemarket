<!DOCTYPE html>
<html lang="en">
<head>
   @include('staff.layout.header')
   
   
</head>
<style type="text/css">
	 .iti-flag {background-image: url("{{ url('intl-tel-input/img/flags.png') }}");}

    @media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
        .iti-flag {background-image: url("{{ url('intl-tel-input/img/flags@2x.png') }}");}
    }
    .intl-tel-input {width: 100%;}
</style>
@yield('style')
<body class="fixed-nav sticky-footer" id="page-top">


<!-- ===============================
    Navigation Start
====================================-->
@include('staff.layout.navbar')
<!-- =====================================================
                    End Navigations
======================================================= -->

<div class="content-wrapper">
    <div class="container-fluid">

       @yield('content')

    </div>
    <!-- /.content-wrapper -->



   @include('staff.layout.footer')
</div>
<!-- Wrapper -->
@yield('script')
@yield('scriptOnload')

</body>
</html>
