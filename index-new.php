<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'bootstrap.php';
// include ROOT_DIR . '/pages/' .$routeName. '.php';

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Top Navigation</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script>

        var siteUrl = '<?php echo SITE_URL;?>';
        var routeName = '<?php echo $routeName;?>';

        var getApiUrl = 'https://192.168.3.15/admin/config.php';
        var postApiUrl = 'https://192.168.3.15/admin/config.php';
        var localApiUrl = 'api/';

    </script>

    <style>
        .select2-container--default .select2-selection--single {
            border-radius: 0px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 20px;
        }

        .add-trunk-form label {
            color: #3f51b5;
            font-style: italic;
        }
    </style>

</head>

<?php

$pagesDir = 'mainpages';
$comsDir  = 'components';

$vueTemplatesArr = array(
     //-- страницы
    'main'           => array('dir' => $pagesDir),
    'extensions'     => array('dir' => $pagesDir),
    'trunks'         => array('dir' => $pagesDir),
    'groups'         => array('dir' => $pagesDir),
    'designer_calls' => array('dir' => $pagesDir),

    //-- компоненты
    'trunk'          => array('dir' => $comsDir),
);

?>

<!--- VUE_TEMPLATES --->
<?php foreach($vueTemplatesArr as $fileName => $val) {
    $vueType = 'com';
    if($val['dir'] == $pagesDir) $vueType = 'page';
    $viewFile = '/src/' . $val['dir']. '/views/' .$fileName . '.php';
    $templateFile = ROOT_DIR . $viewFile;
    if(file_exists($templateFile)) { ?>
        <template id="<?php echo $fileName; ?>-<?php echo $vueType;?>">
            <?php include $templateFile; ?>
        </template>
    <?php
    } else {
        die($templateFile .'- not file');
    }
}
?>
<!--- /.VUE_TEMPLATES --->

<!--
<template id="trunk-com">
    <?php include ROOT_DIR . '/src/components/views/trunk.php'; ?>
</template>
-->

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">

<div class="wrapper" id="vue-app">

    <?php require INC_DIR . '/headerNew.php'; ?>

    <!-- Full Width Column -->
    <div class="content-wrapper">
        <div class="container">
            <component :is="getPageName()"></component>
        </div><!-- /.content -->
    </div><!-- /.container -->

    <footer class="main-footer">
        <div class="container">
            <div class="pull-right hidden-xs"><b>Version</b> 2.4.0</div>
            <strong>Copyright &copy; 2014-2018 .</strong> All rights reserved.
        </div>
    </footer>

</div><!-- ./wrapper -->

<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="bower_components/fastclick/lib/fastclick.js"></script>

<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="plugins/input-mask/jquery.inputmask.js"></script>

<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>

<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
        //Date range as a button
        $('#daterange-btn').daterangepicker(
            {
                ranges   : {
                    'Today'       : [moment(), moment()],
                    'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                    'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate  : moment()
            },
            function (start, end) {
                $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
            }
        )

        //Date picker
        $('#datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass   : 'iradio_minimal-red'
        })
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass   : 'iradio_flat-green'
        })

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false
        })
    })
</script>

<!--<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>-->
<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/http-vue-loader"></script>

<!-- FUNCTIONS -->
<script src="src/functions.js"></script>

<!-- SERVICES -->
<script src="src/services/http.js"></script>
<script src="src/services/mixins.js"></script>

<!--  MODELS -->
<script src="src/models/models.js"></script>

<!--  COMPONENTS -->
<!--<script src="src/components/trunk.js"></script>-->

<!-- PAGES ---->
<?php

foreach($vueTemplatesArr as $fileName => $val) {
    $scriptUrl  = 'src/' . $val['dir'] . '/' . $fileName . '.js';
    $scriptFile = ROOT_DIR . '/' . $scriptUrl;
    if (file_exists($scriptFile)) { ?>
        <script src="<?php echo $scriptUrl; ?>"></script>
        <?php
    } else {
        die($scriptFile . '- not script file');
    }
}

?>

<!--
<script src="src/mainpages/main.js"></script>
<script src="src/mainpages/extensions.js"></script>
<script src="src/mainpages/trunks.js"></script>
<script src="src/mainpages/groups.js"></script>
-->
<!-- APP ---->
<script src="src/app.js"></script>

</body>
</html>
