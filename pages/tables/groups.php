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
                Группы
                <small>(groups)</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-bank"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>

            <br>

            <a @click="openForm('form-groups')" class="btn btn-block btn-success" style="width:200px" href="#">
                <i class="fa fa-fw fa-plus-circle"></i>Добавить новую группу
            </a>

        </section>



        <section v-if="formStatus" class="content">
            <div class="box">
                <div class="box-header with-border"> <h4>Добавление новой группы</h4></div>
                <div class="box-body">
                    <form role="form" method="POST" action="/groups">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-3">
                                    <label>Название группы</label>
                                    <input type="text" class="form-control" id="group" name="group" placeholder="Название группы" required="">
                                </div>

                                <div class="col-xs-3">
                                    <label>Номер группы</label>
                                    <input type="text" class="form-control" id="group" name="group" placeholder="Название группы" required="">
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-5">
                                    <label>Все сотрудники</label>
                                    <input type="text" name="q" class="form-control" placeholder="Поиск в списке..."><select name="from[]" id="search" class="form-control" size="18" multiple="multiple">


                                        <option value="001">001 - KPP</option><option value="100">100 - Hamidulin_SV</option><option value="101">101 - Hamidulin_AS</option><option value="102">102 - Belih_T.</option><option value="103">103 - Buh_TD</option><option value="106">106 - Yurist</option><option value="107">107 - OMTS</option><option value="108">108 - Bukhanskij_V.</option><option value="109">109 - Malahova_E.</option><option value="110">110 - Maslov_M.</option><option value="111">111 - Pleshkova_O.</option><option value="112">112 - Tehnolog</option><option value="113">113 - Starikov_S.</option><option value="114">114 - Constructors</option><option value="124">124 - Aksenov_A</option><option value="130">130 - Sulejmanova_US</option><option value="131">131 - New_User_131</option><option value="132">132 - New_User_132</option><option value="133">133 - Chepkasov_VA</option><option value="134">134 - Lenovo-temp1</option><option value="135">135 - Lenovo-temp2</option><option value="136">136 - Serejkin_DV</option><option value="137">137 - Suhih_LS</option><option value="138">138 - Lenovo-temp5</option><option value="139">139 - Lenovo-temp6</option><option value="150">150 - Sklad</option><option value="200">200 - Grebinka_T</option><option value="201">201 - Shaihutdinov_RH</option><option value="202">202 - Makarov_GB</option><option value="210">210 - Bajenova_O.</option><option value="211">211 - Krasilova_V.</option><option value="212">212 - Aksenov_A.</option><option value="220">220 - Peremitin_U.</option><option value="221">221 - Devyatov_E.</option><option value="230">230 - Sulejmanova_U.</option><option value="231">231 - Kambolina_M.</option><option value="232">232 - Leshenko_A.</option><option value="235">235 - Chepkasov_V.</option><option value="236">236 - Loparev_P.</option><option value="237">237 - Lishikov_E.</option><option value="239">239 - Gorelov_I.</option><option value="240">240 - Suhina_L.</option><option value="241">241 - Fadeev_A</option><option value="300">300 - Haritonov_V.</option><option value="333">333 - wer</option><option value="505">505 - NOC</option><option value="666">666 - Kuznetsov_S</option><option value="777">777 - Romanenko_EO</option></select>
                                </div>

                                <div class="col-xs-2" style="padding-top: 80px;">
                                    <button type="button" id="search_rightAll" class="btn btn-block btn-default"><i class="glyphicon glyphicon-forward"></i></button>
                                    <button type="button" id="search_rightSelected" class="btn btn-block btn-default"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                    <button type="button" id="search_leftSelected" class="btn btn-block btn-default"><i class="glyphicon glyphicon-chevron-left"></i></button>
                                    <button type="button" id="search_leftAll" class="btn btn-block btn-default"><i class="glyphicon glyphicon-backward"></i></button>
                                </div>

                                <div class="col-xs-5">
                                    <label>В группе</label>
                                    <input type="text" name="q" class="form-control" placeholder="Поиск в списке..."><select name="members[]" id="search_to" class="form-control" size="18" multiple="multiple"><option value="104">104 - Makarov_GL</option><option value="105">105 - Shaihutdinov_R.</option></select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-block btn-success" style="width:150px"><i class="fa fa-fw fa-save"></i>Сохранить</button>
                    </form>
                </div>
            </div>

            <script type="text/javascript" src="/distr/dist/js/multiselect.min.js"></script>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#search').multiselect({
                        search: {
                            left: '<input type="text" name="q" class="form-control" placeholder="Поиск в списке..." />',
                            right: '<input type="text" name="q" class="form-control" placeholder="Поиск в списке..." />',
                        },
                        submitAllLeft: false,
                        fireSearch: function(value) {
                            return value.length > 1;
                        }
                    });
                });

                function removeGroup(id){
                    var tr=$("#"+id);
                    if(id != 0){
                        $.get('/groups/remove',{'id':id},function(r){
                            if (r === "ok"){
                                tr.remove();
                            } else {
                                alert('непредвиденная ошибка');
                            }
                        });
                    }
                }
            </script>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box scrolldiv">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody id="groupsth">
                                <tr>
                                    <th>Название группы</th>
                                    <th>Участники группы</th>
                                    <th style="width:100px">Редактировать</th>
                                    <th style="width:100px">Удалить</th>
                                </tr>
                                <tr id="22">
                                    <td> sales </td>
                                    <td> Yurist, Pleshkova_O., Tehnolog, , Aksenov_A, Sulejmanova_US </td>

                                    <td> <a href="/groups?edit=22" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(22);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="23">
                                    <td> support </td>
                                    <td> Tehnolog, , , , Sulejmanova_US, New_User_131, Serejkin_DV, Shaihutdinov_RH </td>

                                    <td> <a href="/groups?edit=23" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(23);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="24">
                                    <td> coldcalls </td>
                                    <td> Makarov_GL, New_User_131 </td>

                                    <td> <a href="/groups?edit=24" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(24);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="26">
                                    <td> Один </td>
                                    <td> KPP, Hamidulin_SV, Lenovo-temp5, Lenovo-temp6 </td>

                                    <td> <a href="/groups?edit=26" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(26);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="30">
                                    <td> aetest </td>
                                    <td> Hamidulin_SV, Belih_T., Buh_TD, Makarov_GL, Shaihutdinov_R., Yurist, OMTS, Malahova_E., Maslov_M., Pleshkova_O., Tehnolog </td>

                                    <td> <a href="/groups?edit=30" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(30);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="46">
                                    <td> Моя </td>
                                    <td> Hamidulin_SV, Shaihutdinov_R. </td>

                                    <td> <a href="/groups?edit=46" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(46);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="47">
                                    <td> test </td>
                                    <td> OMTS, New_User_131 </td>

                                    <td> <a href="/groups?edit=47" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(47);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="54">
                                    <td> 123 </td>
                                    <td> Devyatov_E., Kambolina_M. </td>

                                    <td> <a href="/groups?edit=54" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(54);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                <tr id="69">
                                    <td> RD Department </td>
                                    <td> New_User_131, Lenovo-temp2, Serejkin_DV, Lenovo-temp5 </td>

                                    <td> <a href="/groups?edit=69" type="button" class="btn btn-block btn-default"> <i class="fa fa-fw fa-edit"></i> Редактровать </a> </td>
                                    <td> <button onclick="removeGroup(69);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        <!--
                        <div class="box-footer">
                            <a class="btn btn-block btn-success" style="width:200px" href="/groups?add"><i class="fa fa-fw fa-plus-circle"></i>Добавить новую группу</a>
                        </div>
                        -->
                    </div>
                </div>
            </div>



            <script type="text/javascript" src="/distr/dist/js/multiselect.min.js"></script>

            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    $('#search').multiselect({
                        search: {
                            left: '<input type="text" name="q" class="form-control" placeholder="Поиск в списке..." />',
                            right: '<input type="text" name="q" class="form-control" placeholder="Поиск в списке..." />',
                        },
                        submitAllLeft: false,
                        fireSearch: function(value) {
                            return value.length > 1;
                        }
                    });
                });

                function removeGroup(id){
                    var tr=$("#"+id);
                    if(id != 0){
                        $.get('/groups/remove',{'id':id},function(r){
                            if (r === "ok"){
                                tr.remove();
                            } else {
                                alert('непредвиденная ошибка');
                            }
                        });
                    }
                }
            </script>
        </section>


    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>Copyright &copy; 2018
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
                this.formStatus = true;
                switch(obj) {
                    case 'groups' :
                        this.item = this.itemModel;
                        break;
                }
            },

            closeForm(obj) {
                this.formStatus = false;
                switch(obj) {
                    case 'groups' :
                        this.item = this.itemModel;
                        break;
                }
            },
        },


    })

</script>

</body>
</html>
