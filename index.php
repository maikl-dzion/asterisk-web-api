<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'bootstrap.php';

// include ROOT_DIR . '/pages/' .$routeName. '.php';

//$setJsScript = $setTemplate = '';
//
//$comDir   = 'components';
//$pagesDir = 'mainpages';
//
//$vueComponentsArray = array(
//
//    'main'       => array('dir' => $pagesDir),
//    'extensions' => array('dir' => $pagesDir),
//    'trunks'     => array('dir' => $pagesDir),
//    'groups'     => array('dir' => $pagesDir),
//    'designer_calls'  => array('dir' => $pagesDir),
//    'core_settings'   => array('dir' => $pagesDir),
//    'system_entities' => array('dir' => $pagesDir),
//    'systemObjects'   => array('dir' => $pagesDir),
//    'constructors'   => array('dir' => $pagesDir),
//    'constructorLinks' => array('dir' => $pagesDir),
//
//    'tests'           => array('dir' => $pagesDir),
//
//    'extension' => array('dir' => $comDir),
//    'group'     => array('dir' => $comDir),
//    'queue'     => array('dir' => $comDir),
//    'ivr'       => array('dir' => $comDir),
//    'trunk'     => array('dir' => $comDir),
//    'inline_route_create' => array('dir'  => $comDir),
//    'outline_route_create' => array('dir' => $comDir),
//
//);
//
//$filesPrint = new SetVueComponentsPrint($vueComponentsArray);
//$setJsScript = $filesPrint->setJs();

$resourceObj = new IncludedAssetsResources(DIR_SRC);

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
    <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">

    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">

    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/jsplumbtoolkit-defaults.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/jsplumbtoolkit-demo.css">
    <link rel="stylesheet" href="assets/css/demo.css">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!--    <script src="http://bolderfest.ru/ARCHIVES/lg.js"></script>-->

    <script src="src/lib/jsplumb.js"></script>

    <script>

        var siteUrl   = '<?php echo SITE_URL;?>';
        var routeName = '<?php echo $routeName;?>';

        var getApiUrl   = 'https://192.168.3.15/admin-lte/admin/config.php';
        var postApiUrl  = 'https://192.168.3.15/admin-lte/admin/config.php';

        var remoteApiUrl  = 'https://192.168.3.15/admin-lte/admin/config.php';
        var localApiUrl   = 'api/';
        var instance      = {};

        var locHash = location.hash;
        if(!locHash) {
            location.hash = '#mainPage';
        }

    </script>

    <style>

        .cdr-items-table {
            border:1px gainsboro solid;
        }

        .cdr-items-table th, .cdr-items-table td{
           border:1px gainsboro solid;
        }

    </style>
</head>

<?php
// ----- TEMPLATES INC ----
$resourceObj->render('pages/views', TEMPLATE_EXP);
$resourceObj->render('components/views', TEMPLATE_EXP);
?>

<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav" data-demo-id="statemachine">

<div class="main-wrapper"
     id="vue-app" >

     <v-app>

        <auth-form-com :auth_form_state="authFormState"></auth-form-com>

        <template>

            <v-toolbar primary color="primary"  >

                <a href=""  class="router-link-active">
                    <div role="img" aria-label="Vuetify Logo" class="v-responsive v-image" style="height:38px;width:38px;">
                        <div class="v-responsive__sizer" style="padding-bottom: 114.504%;"></div>
                        <div class="v-image__image v-image__image--contain"
                             style="background-image: url(&quot;https://cdn.vuetifyjs.com/images/logos/v-alt.svg&quot;); background-position: center center;"></div>
                        <div class="v-responsive__content"></div>
                    </div>
                </a>

                <v-toolbar-title
                     class="white--text" style="border-right:3px white solid; padding-right:25px;" >Intervis
                </v-toolbar-title>

                <template v-for="(row, page) in routes" >
                    <div :key="page"  class="app-top-menu" >
                        <a @click="setPageName(page)" :href="siteUrl + '/index.php?#' + page" v-html="row.label" ></a>
                    </div>
                </template>

<!--                <router-link class="" to="/MainPage">Главная</router-link>-->
<!--                <router-link class="" to="/ConstructorLinks">Конструктор связей</router-link>-->

                <v-spacer></v-spacer>

                <v-btn icon class="white--text" ><v-icon>search</v-icon></v-btn>
                <v-btn icon class="white--text" ><v-icon>apps</v-icon></v-btn>
                <v-btn icon class="white--text" ><v-icon>refresh</v-icon></v-btn>
                <v-btn icon class="white--text" ><v-icon>more_vert</v-icon></v-btn>

            </v-toolbar>

        </template>

<!--             <template>-->
<!--                 <v-container fluid>-->
<!--                     <div class="main-content">-->
<!--                         <router-view></router-view>-->
<!--                     </div>-->
<!--                 </v-container>-->
<!--             </template>-->

            <template>
                <v-container fluid>
                    <div class="main-content">
                        <component :is="pageLoader"></component>
                    </div>
                </v-container>
            </template>

</v-app></div>


<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script> -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<script src="bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<script src="plugins/input-mask/jquery.inputmask.js"></script>
<script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="plugins/iCheck/icheck.min.js"></script>

<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/demo.js"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.5.1"></script>-->

<script src="https://unpkg.com/vue"></script>
<script src="https://unpkg.com/http-vue-loader"></script>
<script src="https://unpkg.com/vue-resource@1.5.1/dist/vue-resource.min.js"></script>
<script src="https://unpkg.com/vue-router/dist/vue-router.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>

<?php

$JsDirNames = array(
    'functions'  => array('exp' => JS_EXP), // -- FUNCTIONS
    'models'     => array('exp' => JS_EXP), // -- MODELS
    'services'   => array('exp' => JS_EXP), // -- SERVICES
    'simpleComs' => array('exp' => JS_EXP), // -- SINGLE COMPONENTS (Однофайловые компоненты)
    'components' => array('exp' => JS_EXP), // --  COMPONENTS
    'CRUD'       => array('exp' => JS_EXP), // --
    'jsPlum'     => array('exp' => JS_EXP), // --
    'pages'      => array('exp' => JS_EXP), // --  PAGES
);

foreach ($JsDirNames as $name => $values) {
    $resourceObj->render($name, JS_EXP, $values);
}

?>

<!-- # ROUTES FILE-->
<script src="src/routes.js"></script>

<!-- # APP FILE --->
<script src="src/app.js"></script>

</body>
</html>
