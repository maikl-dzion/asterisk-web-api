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
                Внутренние номера
                <small>(extensions)</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-bank"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Data tables</li>
            </ol>
        </section>

        <section class="content">

            <script>
                window.internal = {};
                $(document).ajaxStop(function () {
                    if (!window.fail){
                        $('#savebtn').removeClass('btn-primary');
                        $('#savebtn').addClass('btn-success');
                        $('.overlay').hide();
                    } else {
                        $('#savebtn').removeClass('btn-primary');
                        $('#savebtn').addClass('btn-danger');
                        $('.overlay').hide();
                    }
                });
                (function(a){

                    a.addinput = function(){
                        $('#numbersth').append('<tr data-id="0" id="0">'+
                            '<td> <input type="text" class="form-control number" value="" placeholder="Номер телефона"></td>'+
                            '<td> <input type="text" class="form-control full_name" value="" placeholder="Фамилия Имя Отчество сотрудника"></td>'+
                            '<td> <input type="text" class="form-control password" value="" placeholder="Пароль для авторизации в статистике"></td>'+
                            '<td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger"> <i class="fa fa-fw fa-minus-circle"></i> Удалить </button> </td>'+
                            '</tr>');
                        location.href='#0';
                    }

                    a.savenumbers = function(){
                        window.fail=false;
                        var error = false;
                        var numbers = [];
                        if ($('#numbersth tr').length==1) {
                            return false;
                        }
                        $('.overlay').show();
                        $('#numbersth tr').each(function(i, row){
                            if (i>0){
                                tr = $(row);
                                var data = {};
                                data.id = tr.data('id');
                                data.full_name = tr.find('.full_name').val();
                                data.number = tr.find('.number').val();
                                data.password = tr.find('.password').val();
                                if (data.number === '' || data.full_name === ''){
                                    tr.css("background-color", "#F08080");
                                    $('#errormodaltext').html('Заполните все поля');
                                    $('#errormodal').modal('show');
                                    $('.overlay').hide();
                                    location.href='#'+data.id;
                                    error = true;
                                    return false;
                                }
                                if (!/^[a-zA-Zа-яА-ЯёЁ0-9\,\_\-\:\'\)\(\./\s]*$/.test(data.full_name)) {
                                    tr.css("background-color", "#F08080");
                                    $('#errormodaltext').html('Допустимые символы в ФИО: Аа-Яя, Aa-Zz, 0-9 и ,.()_-:`');
                                    $('#errormodal').modal('show');
                                    $('.overlay').hide();
                                    location.href='#'+data.id;
                                    error = true;
                                    return false;
                                }
                                if (!/^[a-zA-Zа0-9\_\-\+]*$/.test(data.number)) {
                                    tr.css("background-color", "#F08080");
                                    $('#errormodaltext').html('Номер телефона может содержать только буквы, цифры и +');
                                    $('#errormodal').modal('show');
                                    $('.overlay').hide();
                                    location.href='#'+data.id;
                                    error = true;
                                    return false;
                                }
                                numbers.push(data);
                                tr.css("background-color", "#FFF");
                            }
                        });
                        if (!error){
                            data={numbers: JSON.stringify(numbers)};
                            $.post('/internal/add',data,function(r){
                                if (r.status==false){
                                    window.fail=true;
                                    $('#errormodaltext').html('Не удалось сохранить Внутренние номера, проверьте введенные данные и попробуйте сохранить еще раз.');
                                    $('#errormodal').modal('show');
                                    return false;
                                } else {
                                    return true;
                                }
                            });
                        }
                    }

                    a.reset = function(el){
                        var tr = $(el).parent().parent();
                        var bt = tr.find('.savebtn');
                        bt.removeClass('btn-success');
                        bt.addClass('btn-primary');
                    }

                    a.removenumber = function(el){
                        var tr = $(el).parent().parent();
                        var id = tr.data('id');
                        if(id == 0)
                            tr.remove();
                        if(id != 0){
                            //Отпровляем на удаление
                            $.get('/internal/remove',{'aid':id},function(r){
                                if (r === "ok"){
                                    tr.remove();
                                } else {
                                    alert('непредвиденная ошибка');
                                }
                            });
                        }

                    }

                    a.upload = function(){
                        $('.overlay').show();
                        $.get('/internal/upload',null,function(r){
                            if (r === "ok"){
                                location.reload();
                            } else {
                                $('.overlay').hide();
                                alert('непредвиденная ошибка');
                            }
                        });
                    }

                })(window.internal);

            </script>

            <div class="box">
                <div class="box-header with-border"><button class="btn btn-block btn-default" style="width:250px" onclick="internal.upload();" disabled=""><i class="fa fa-fw fa-download"></i>Загрузить номера из БД</button><button class="btn btn-block btn-success" style="width:250px" onclick="internal.addinput();" disabled=""><i class="fa fa-fw fa-plus-circle"></i>Добавить внутренний номер</button></div>
                <div class="box-body scrolldiv">
                    <table class="table table-bordered">
                        <tbody id="numbersth">
                        <tr>
                            <th>Номер телефона</th>
                            <th>Фамилия Имя Отчество сотрудника</th>
                            <th>Установить новый пароль</th>
                            <th>Удалить</th>
                        </tr>

                        <tr data-id="30388" id="30388">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="505" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="NOC" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30436" id="30436">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="105" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Shaihutdinov_R." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30437" id="30437">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="107" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="OMTS" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30438" id="30438">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="109" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Malahova_E." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30439" id="30439">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="114" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Constructors" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30440" id="30440">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="212" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Aksenov_A." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30441" id="30441">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="220" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Peremitin_U." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30442" id="30442">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="221" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Devyatov_E." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30443" id="30443">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="231" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Kambolina_M." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30444" id="30444">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="232" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Leshenko_A." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30455" id="30455">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="235" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Chepkasov_V." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30456" id="30456">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="236" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Loparev_P." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30457" id="30457">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="237" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Lishikov_E." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30458" id="30458">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="239" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Gorelov_I." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30459" id="30459">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="240" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Suhina_L." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30460" id="30460">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="241" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Fadeev_A" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30461" id="30461">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="300" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Haritonov_V." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30462" id="30462">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="124" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Aksenov_A" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30463" id="30463">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="130" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Sulejmanova_US" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30464" id="30464">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="131" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="New_User_131" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30465" id="30465">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="132" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="New_User_132" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30466" id="30466">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="133" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Chepkasov_VA" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30467" id="30467">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="134" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Lenovo-temp1" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30468" id="30468">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="135" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Lenovo-temp2" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30469" id="30469">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="136" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Serejkin_DV" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30470" id="30470">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="137" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Suhih_LS" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30471" id="30471">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="138" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Lenovo-temp5" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30472" id="30472">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="139" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Lenovo-temp6" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30473" id="30473">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="150" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Sklad" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30474" id="30474">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="200" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Grebinka_T" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30475" id="30475">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="201" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Shaihutdinov_RH" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30476" id="30476">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="202" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Makarov_GB" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="30478" id="30478">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="333" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="wer" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="32565" id="32565">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="001" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="KPP" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="32566" id="32566">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="100" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Hamidulin_SV" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="32674" id="32674">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="101" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Hamidulin_AS" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39299" id="39299">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="104" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Makarov_GL" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39563" id="39563">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="102" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Belih_T." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39564" id="39564">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="103" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Buh_TD" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39565" id="39565">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="106" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Yurist" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39566" id="39566">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="108" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Bukhanskij_V." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39567" id="39567">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="110" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Maslov_M." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39568" id="39568">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="111" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Pleshkova_O." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39569" id="39569">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="112" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Tehnolog" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39570" id="39570">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="113" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Starikov_S." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39571" id="39571">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="210" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Bajenova_O." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39572" id="39572">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="211" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Krasilova_V." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39573" id="39573">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="230" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Sulejmanova_U." placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39574" id="39574">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="666" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Kuznetsov_S" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>


                        <tr data-id="39575" id="39575">
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control number" value="777" placeholder="Номер телефона" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control full_name" value="Romanenko_EO" placeholder="Фамилия Имя Отчество сотрудника" disabled="">  </td>
                            <td> <input onkeypress="internal.reset(this);" type="text" class="form-control password" value="" placeholder="Внимание! Пароль не установлен" disabled="">  </td>
                            <td> <button onclick="internal.removenumber(this);" type="button" class="btn btn-danger" disabled=""> <i class="fa fa-fw fa-minus-circle" disabled=""></i> Удалить </button> </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <div class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
                <div class="box-footer">
                    <button id="savebtn" onclick="internal.savenumbers();" type="button" class="btn btn-block btn-primary savebtn" style="width:250px" disabled=""> <i class="fa fa-fw fa-save"></i> Сохранить номера</button>
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
