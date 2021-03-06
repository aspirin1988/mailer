<!DOCTYPE html>
<html ng-app="app">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/resources/admin/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/resources/admin/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/resources/admin/dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/resources/admin/plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="/resources/admin/plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/resources/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="/resources/admin/plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/resources/admin/plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="/resources/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="/resources/admin/dist/css/app.css">
    <link rel="stylesheet" href="/resources/admin/public/css/uikit.min.css">
    <link rel="stylesheet" href="/resources/admin/public/css/components/accordion.css">
    <link rel="stylesheet" href="/resources/admin/public/css/components/search.css">
    <link rel="stylesheet" href="/resources/admin/public/css/components/notify.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery 2.1.4 -->
    <script src="/resources/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Angular -->
    <script src="/libs/angular/angular.min.js"></script>
    <link rel="stylesheet" href="/resources/admin/dist/css/colorpicker.min.css">
    <script src="/resources/admin/dist/js/bootstrap-colorpicker-module.min.js"></script>
    <script src="/resources/admin/dist/js/angular-route.min.js"></script>
    <!-- Blink app-angular.js -->
    <script src="/resources/admin/dist/js/app-angular.js"></script>
  </head>
  <body class="hold-transition skin-blue sidebar-mini" ng-controller="blinkMainController">
    <div class="wrapper" id="main-container" style="visibility: hidden;">
      <header class="main-header" get-header></header>
      <aside class="main-sidebar" get-sidebar></aside>
      <div class="content-wrapper">
          <ng-view></ng-view>
      </div>

      <footer class="main-footer" get-footer></footer>
    </div><!-- ./wrapper -->


    <div>

      <!-- jQuery UI 1.11.4 -->
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
      <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
      <script>
        $.widget.bridge('uibutton', $.ui.button);
      </script>
      <!-- Bootstrap 3.3.5 -->
      <script src="/resources/admin/bootstrap/js/bootstrap.min.js"></script>
      <!-- Morris.js charts -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
      <script src="/resources/admin/plugins/morris/morris.min.js"></script>
      <!-- Sparkline -->
      <script src="/resources/admin/plugins/sparkline/jquery.sparkline.min.js"></script>
      <!-- jvectormap -->
      <script src="/resources/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
      <script src="/resources/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
      <!-- jQuery Knob Chart -->
      <script src="/resources/admin/plugins/knob/jquery.knob.js"></script>
      <!-- daterangepicker -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
      <script src="/resources/admin/plugins/daterangepicker/daterangepicker.js"></script>
      <!-- datepicker -->
      <script src="/resources/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
      <!-- Bootstrap WYSIHTML5 -->
      <script src="/resources/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
      <!-- Slimscroll -->
      <script src="/resources/admin/plugins/slimScroll/jquery.slimscroll.min.js"></script>
      <!-- FastClick -->
      <script src="/resources/admin/plugins/fastclick/fastclick.min.js"></script>
      <!-- AdminLTE App -->
      <script src="/resources/admin/dist/js/app.min.js"></script>
      <script src="/resources/admin/public/js/uikit.min.js"></script>
      <script src="/resources/admin/public/js/components/accordion.min.js"></script>
      <script src="/resources/admin/public/js/components/notify.min.js"></script>
      <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
      <!-- AdminLTE for demo purposes -->
      <script src="/resources/admin/dist/js/demo.js"></script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script type="text/javascript">
        google.charts.load("current", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
          var data = google.visualization.arrayToDataTable([
            ['title', 'Количество комнаний'],
            ['Work',     20],
            ['Eat',      2],
            ['Commute',  2],
            ['Watch TV', 2],
            ['Sleep',    7]
          ]);

          var options = {
            title: 'My Daily Activities',
            is3D: true,
          };

          var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
          chart.draw(data, options);
        }
      </script>
    </div>
  </body>
</html>

