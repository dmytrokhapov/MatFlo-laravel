
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/guest_css.css')}}">
  <link href="{{asset('css/sweetAlert.css')}}" rel="stylesheet">
  <style>
    .error{
        color: red;
        margin-bottom: 0 !important;
    }

    input.valid + .error{
        display: none;
    }

  </style>
  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- Select Dropdown -->
<script src="{{asset('js/jquery.nice-select.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('.custom-select-design').niceSelect();      
    FastClick.attach(document.body);
  });    
</script>

{{-- <script src="{{asset('assets/js/jquery.min.js')}}"></script> --}}
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sweetAlert.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/ipfs/dist/index.min.js" crossorigin="anonymous"></script>
<script src="{{asset('plugins/waypoints/lib/jquery.waypoints.js')}}"></script>
<script src="{{asset('plugins/counterup/jquery.counterup.min.js')}}"></script>
{{-- <script src="{{asset('js/custom.min.js')}}"></script> --}}
<script src="{{asset('js/dashboard1.js')}}"></script>
<script type="text/javascript" src="{{asset('js/web3.min.js')}}"></script>
<script src="{{asset('plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
<script type="text/javascript" src="{{asset('js/abi/CoffeeSupplyChainAbi.js')}}"></script>
<script type="text/javascript" src="{{asset('js/abi/SupplyChainUserAbi.js')}}"></script>

<script src="{{asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
<script type="text/javascript" src="{{asset('js/app/app.js')}}"></script>
</head>
<body class="hold-transition login-page">
@if(!Request::is('login'))
<div class="container"><a class="box_login_link" href="{{route('login')}}">< Back to Sign in</a></div>
@endif
<div class="login-box">
  <!-- /.login-logo -->
  {{$slot}}
</div>
<div class="footer-menu">
    <ul>
        <li><a href="javascript:void(0);">Terms of Use</a></li>
        <li><a href="javascript:void(0);">Cookies</a></li>
        <li><a href="javascript:void(0);">About Us</a></li>
        <li><a href="javascript:void(0);">Help Center</a></li>
    </ul>
</div>
{{-- <script type="text/javascript" src="{{asset('js/app/app.js')}}"></script> --}}
<!-- /.login-box -->
</body>
</html>
