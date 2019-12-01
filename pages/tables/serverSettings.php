<?php

$rootDir = '/land-page/adminLTE/';
include $_SERVER['DOCUMENT_ROOT'] . $rootDir . 'define.php';

?>

<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Data Tables</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper" id="vue-app" >

    <?php include INC_DIR . '/header.php'; ?>

    <?php include INC_DIR . '/left-menu.php'; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Основные настройки
                <small>(system settings)</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-bank"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>


        <section class="content">

            <!-- start of pbx connection config -->

            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Настройка подключения к АТС</h3>
                </div>
                <div class="box-body">
                    <form role="form" method="POST" action="/pbxconfig">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>IP адрес или имя сервера АТС:</label>
                                    <input type="text" class="form-control" id="pbx_host" name="pbx_host" placeholder="IP адрес или имя сервера АТС" value="" required="" disabled="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Схема подключения:</label>
                                    <select class="form-control" name="pbx_scheme" id="pbx_scheme">
                                        <option selected="">tcp://</option>
                                        <option>tls://</option>
                                    </select>
                                    <!--input type="text" class="form-control" id="pbx_scheme" name="pbx_scheme" placeholder="Схема подключения" value="tcp://" required disabled-->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Порт подключения:</label>
                                    <input type="text" class="form-control" id="pbx_port" name="pbx_port" placeholder="Порт подключения" value="" required="" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Имя пользователя:</label>
                                    <input type="text" class="form-control" id="pbx_username" name="pbx_username" placeholder="Имя пользователя" value="" required="" disabled="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Пароль:</label>
                                    <input type="password" class="form-control" id="pbx_secret" name="pbx_secret" placeholder="Пароль" value="" required="" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Таймаут подключения(сек.)</label>
                                    <input type="text" class="form-control" id="pbx_connect_timeout" name="pbx_connect_timeout" placeholder="Таймаут подключения" value="10" required="" disabled="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Таймаут чтения(сек.)</label>
                                    <input type="text" class="form-control" id="pbx_read_timeout" name="pbx_read_timeout" placeholder="Таймаут чтения" value="0.01" required="" disabled="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Технология (SIP/PJSIP etc):</label>
                                    <input type="text" class="form-control" id="pbx_tech" name="pbx_tech" placeholder="Технология" value="SIP" required="" disabled="">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Контекст:</label>
                                    <input type="text" class="form-control" id="pbx_context" name="pbx_context" placeholder="Контекст" value="" required="" disabled="">
                                </div>
                            </div>
                        </div>
                        <small>* таймауты не могут превышать 295 сек.</small>
                        <button type="submit" class="btn btn-block btn-success" style="width:150px" disabled=""><i class="fa fa-fw fa-save"></i>Сохранить</button>
                    </form>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>

            </div>

            <!-- end of pbx connection config -->
            <a name="notifications"></a>
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Настройка оповещений о проблемах</h3>
                </div>
                <div class="box-body">
                    <form role="form" method="POST" action="/pbxconfig">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email для уведомлений (можно указать несколько через запятую)</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="email для уведомлений" value="support@vistep.ru" required="" disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div div="" class="form-group">
                                    <label>
                                        <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-disabled bootstrap-switch-id-sms bootstrap-switch-animate" style="width: 98px;"><div class="bootstrap-switch-container" style="width: 145px; margin-left: -48px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 48px;">ON</span><span class="bootstrap-switch-label" style="width: 48px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 48px;">OFF</span><input type="checkbox" id="sms" name="sms" class="minimal" onchange="check_sms();" disabled=""></div></div> SMS-оповещения
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Номер телефона для sms-уведомлений</label>
                                    <input disabled="disabled" id="phone" type="text" class="form-control" name="phone" placeholder="+71234567890" value="" required="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p>SMS.RU предлагает до 5 бесплатных sms-сообщений в день.<br>
                                    Для их активации нажмите <a href="https://vistep.sms.ru" target="blank">здесь</a> и зарегистрируйтесь, после необходимо скопировать значение api_id из <a href="https://sms.ru/?panel=api" target="blank">вашего личного кабинета</a> в поле справа.<br><br>
                                    Также вы можете пополнить баланс для отправки sms через наш сервис любым удобным способом:
                                </p><ul>
                                    <li>WebMoney R561513348792, Z236357299613</li>
                                    <li><a href="https://money.yandex.ru/to/410011875034405" target="blank">Яндекс.Деньги</a></li>
                                    <li><a href="https://vistep.ru/contact/" target="blank">Банковский перевод</a></li>
                                </ul>
                                В назначении платежа укажите название вашей организации и текст "за sms".
                                <p></p>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>SMS.RU api_id</label>
                                    <input disabled="disabled" type="text" class="form-control" id="api_id" name="api_id" placeholder="api_id сайта sms.ru" value="">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-block btn-success" style="width:150px" disabled=""><i class="fa fa-fw fa-save"></i>Сохранить</button>
                    </form>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>

            </div>

            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Поддержка АТС</h3>
                </div>
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                Рады представить вам новую услугу: "Поддержка АТС".<br>
                                Всего за <b>1500р</b> в месяц мы возьмем под свое "крыло" вашу телефонную станцию, <br> моментально отреагируем на сообщения системы мониторинга и устраним возникающие проблемы. <br> <strong>Дополнительно поможем Вам с настройкой Вашей АТС (мелкие правки, дополнения).</strong><br>
                                Для подключения напишите нам через меню <a href="/support">Help desk</a> или на почту <a href="mailto:support@vistep.ru?subject=Поддержка АТС">support@vistep.ru</a>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-muted">Баланс вашего мониторинг-счета составляет 0 руб. <br>Активировать услугу нет возможности.</p>
                            <div div="" class="form-group">
                                <label>
                                    <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-disabled bootstrap-switch-id-monitoring bootstrap-switch-animate" style="width: 98px;"><div class="bootstrap-switch-container" style="width: 145px; margin-left: -48px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 48px;">ON</span><span class="bootstrap-switch-label" style="width: 48px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 48px;">OFF</span><input disabled="" type="checkbox" id="monitoring" name="monitoring" class="minimal" onchange="check_monitoring();"></div></div>  Поддержка АТС                       </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>

            </div>
        </section>


    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>


    <?php include INC_DIR . '/bottom.pages.php'; ?>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!-- page script -->
<script>

    /**/
    $(function () {
        $('#example1').DataTable()
        $('#example2').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
    })
    /***/

</script>


<!-- vue app  -->
<script>

    var app = new Vue({
        el: '#vue-app',
        data: {

            formStatus : false,

            item: {
                name: '',
                number: '',
                phone : '',
                site  : '',
            },

            itemModel: {

                name: '',
                number: '',
                phone : '',
                site  : '',

            },

            tHeader: {

                name: 'Название',
                number: 'Номер регистрации',
                phone: 'Номер телефона',
                site : 'Сайт',
                //edit : 'Редактировать',
                //delete : 'Удалить',

            },

            tranks: [

                {
                    name: 'trank 1',
                    number: '3456789',
                    phone : '734-23-90',
                    site : 'имя сайта 1',
                },
                {
                    name: 'trank 2',
                    number: '907839',
                    phone : '740-34-67',
                    site : 'имя сайта 2',
                },
                {
                    name: 'trank 3',
                    number: '8900654',
                    phone : '700-45-67',
                    site : 'имя сайта 3',
                },
            ]


        },


        methods : {

            addItem(obj) {
                switch(obj) {
                    case 'trank' :

                        break;
                }
            },

            editItem(row, obj) {
                switch(obj) {
                    case 'trank' :
                        this.formStatus = true;
                        this.item = row;
                        break;
                }
            },

            openForm(obj) {
                switch(obj) {
                    case 'trank' :
                        this.formStatus = true;
                        this.item = this.itemModel;
                        break;
                }
            },

            closeForm(obj) {
                switch(obj) {
                    case 'trank' :
                        this.formStatus = false;
                        this.item = this.itemModel;
                        break;
                }
            },
        },


    })

</script>

</body>
</html>
