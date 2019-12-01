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
                Внешние номера
                <small>(tranks)</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-bank"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>

        <section  >
            <div style="width:98%; padding:5px; margin:4px 0px 0px 10px" >

                <button @click="openForm('trank')" style="width:250px" type="button" class="btn btn-block btn-primary btn-flat"  >
                    Зарегистрировать новый номер
                </button>

                <!-- quick email widget -->
                <div v-if="formStatus" class="box box-info" style="margin-top:10px;" >
                    <div class="box-header">
                        <i class="fa fa-envelope"></i>

                        <h3 class="box-title">Зарегистрировать номер</h3>
                        <!-- tools box -->
                        <div class="pull-right box-tools">
                            <button @click="closeForm('trank')" type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"  title="Remove">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <!-- /. tools -->
                    </div>
                    <div class="box-body">
                        <form action="#" method="post">

                            <div class="form-group">
                                <input v-model="item.name" type="email" class="form-control" name="emailto" placeholder="Название">
                            </div>

                            <div class="form-group">
                                <input v-model="item.number" type="text" class="form-control" name="subject" placeholder="Номер регистрации">
                            </div>

                            <div class="form-group">
                                <input v-model="item.phone" type="text" class="form-control" name="subject" placeholder="Номер телефона">
                            </div>

                            <div class="form-group">
                                <input v-model="item.site" type="text" class="form-control" name="subject" placeholder="Имя сайта">
                            </div>

                            <div>
                           <textarea class="textarea" placeholder="Комментарии"
                                     style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="box-footer clearfix">
                        <button type="button" class="pull-right btn btn-default" id="sendEmail">Сохранить
                            <i class="fa fa-arrow-circle-right"></i></button>
                    </div>
                </div>

            </div>

        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">


                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Data Table With Full Features</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">

                                <thead>
                                <tr>
                                    <th v-for="(fValue, fieldName) in tHeader" >{{fValue}}</th>
                                </tr>
                                </thead>

                                <tbody>

                                <tr v-for="(row, key) in tranks" >
                                    <td v-for="(fValue, fieldName) in tHeader" >

                                        <a v-if="fieldName != 'edit'" href="#" @click="editItem(row, 'trank')" >{{row[fieldName]}}</a>

                                        <!--
                                          <a href="/groups?edit=24" type="button" class="btn btn-block btn-default">
                                             <i class="fa fa-fw fa-edit"></i> Редактровать
                                          </a>
                                        -->

                                    </td>
                                </tr>

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th v-for="(fValue, fieldName) in tHeader" >{{fValue}}</th>
                                </tr>
                                </tfoot>

                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
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
                status : 'Статус',
                //edit : 'Редактировать',
                //delete : 'Удалить',

            },

            tranks: [

                {
                    name: 'trank 1',
                    number: '3456789',
                    phone : '734-23-90',
                    site : 'имя сайта 1',
                    status : 'Доступен',
                },
                {
                    name: 'trank 2',
                    number: '907839',
                    phone : '740-34-67',
                    site : 'имя сайта 2',
                    status : 'Доступен',
                },
                {
                    name: 'trank 3',
                    number: '8900654',
                    phone : '700-45-67',
                    site : 'имя сайта 2',
                    status : 'Не доступен',
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
