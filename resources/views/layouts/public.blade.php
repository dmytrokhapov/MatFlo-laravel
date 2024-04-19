<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{env('APP_NAME')}}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- DataTables -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('css/adminlte.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/sweetAlert.css')}}">
  {{-- <link href="{{asset('css/style.css')}}" rel="stylesheet"> --}}
   <link href="{{asset('css/custom_style.css')}}" rel="stylesheet">
   <link href="{{asset('css/pavan.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link href="{{asset('css/bootstrap-datepicker.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('plugins/Magnific-Popup-master/dist/magnific-popup.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
  <link href="{{asset('plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">
  <style>
    .form-control.valid + label.error {
        display: none !important;
    }
    .error{
        color: red;
        margin-bottom: 0 !important;
    }
    .action .custom-control{
        display: inline-table;
    }
    .hideColumn  {
        display: none;
    }

    .hide_first tr th:first-child:before , .hide_first tr th:first-child:after{
        display: none;
    }

    .hidden{
        display: none;
    }

    .align-end{
        margin-top: 30px;
    }

</style>
<script>
    // globCoinbase = "0x60AA2C9825066cF93b22B0158F4882c1BFadFf90";
    // console.log('globCoinbase--', globCoinbase);
</script>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('js/bootstrap-datepicker.min.js')}}"></script>


<script src="{{asset('js/jquery.slimscroll.js')}}"></script>
<!--Wave Effects -->
<script src="{{asset('js/waves.js')}}"></script>
{{-- <script src="{{asset('plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script> --}}
{{-- <script src="plugins/datatables/jquery.dataTables.min.js"></script> --}}
<!--Counter js -->
<script src="https://cdn.jsdelivr.net/npm/ipfs/dist/index.min.js" crossorigin="anonymous"></script>

<script>
    var list_image_url = "{{asset('img/list-action.svg')}}";
    var edit_image_url = "{{asset('img/edit.svg')}}";
</script>
<script type="text/javascript" src="{{asset('js/app/app.js')}}"></script>
<script src="{{asset('plugins/waypoints/lib/jquery.waypoints.js')}}"></script>
<script src="{{asset('plugins/counterup/jquery.counterup.min.js')}}"></script>
{{-- <script src="{{asset('js/custom.min.js')}}"></script> --}}
<script src="{{asset('js/dashboard1.js')}}"></script>
<script src="{{asset('plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/web3.min.js')}}"></script>

<script type="text/javascript" src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
<script type="text/javascript" src="{{asset('js/abi/CoffeeSupplyChainAbi.js')}}"></script>
<script type="text/javascript" src="{{asset('js/abi/SupplyChainUserAbi.js')}}"></script>
<script type="text/javascript" src="{{asset('js/abi/SupplyChainStorageAbi.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sweetAlert.js')}}"></script>
<script type="text/javascript" src="{{asset('js/parsley.min.js')}}"></script>
<script src="{{asset('plugins/switchery/dist/switchery.min.js')}}"></script>

<script src="{{asset('plugins/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript" src="{{asset('plugins/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js')}}" charset="UTF-8"></script>
<script type="text/javascript" src="{{asset('plugins/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.fr.js')}}" charset="UTF-8"></script>


<script src="{{asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('plugins/Magnific-Popup-master/dist/jquery.magnific-popup-init.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('js/adminlte.min.js')}}"></script>
<!-- Select Dropdown -->
<script src="{{asset('js/jquery.nice-select.min.js')}}"></script>
<script>
  $(document).ready(function() {
    $('.custom-select-design').niceSelect();
    // FastClick.attach(document.body);
  });
</script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{asset('dist/js/demo.js')}}"></script> --}}
</head>
<body class="hold-transition sidebar-mini admin_body">
  
<div class="wrapper">
  <!-- Navbar -->
  <div class="preloader">
    <img width="50" src="/img/spinner.svg" />
    <span>Please wait... </span>
  </div>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="logo-title">
      <a href="/" class="brand-link">
        <small>MatFlo Explorer</small>
      </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        
      </div> --}}
      <!-- /.sidebar-menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="{{route('explorer')}}" class="nav-link @if(Request::is('explorer')) active @endif">
                  <i class="nav-icon"> <img width="20" src="{{asset('img/search.svg')}}"></i><p>Explorer</p>
              </a>
            </li>
        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->

    <div class="logout">
      <ul class="nav">
        <li class="nav-item">
        </li>
      </ul>
    </div>
  </aside>
  <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display:none;">
    @csrf
  </form>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    {{$slot}}
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="{{route('dashboard')}}">{{env('APP_NAME')}}</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

</body>
<script>
  function searchDocument() {
    window.location.href = '/dashboard?q=' + $("#searchQuery").val();
  }

  function inputKeyClicked(e) {
    if(e.keyCode == 13) {
      window.location.href = '/dashboard?q=' + $("#searchQuery").val();
    }
  }
</script>
</html>
