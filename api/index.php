<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

date_default_timezone_set('Europe/Moscow');

define('ROOT_DIR', __DIR__);

$amp_conf['AMPDBUSER']	= 'asteriskuser';
$amp_conf['AMPDBPASS']  = '123456Aa';
$amp_conf['AMPDBHOST']	= 'localhost';
$amp_conf['AMPDBNAME']	= 'asterisk';
$amp_conf['AMPDBENGINE'] = 'mysql';
$amp_conf['datasource']	= '';    //for sqlite3

$asterDbConfig = array(
    'host'     => 'localhost',
    'user'     => 'asteriskuser',
    'password' => '123456Aa',
    'dbname'   => 'asterisk',
);

$cdrDbConfig = $asterDbConfig;
$cdrDbConfig['dbname'] = 'asteriskcdrdb';

// require_once 'confFreePbx.php';

include_once 'customAutoloarder.php';


$db = new MySQLiClass($asterDbConfig);
$action  = 'getCoreInfo';
$context = $extension = $display = '';

if(!empty($_GET['action']))
    $action = $_GET['action'];

if(!empty($_GET['display']))
    $display = $_GET['display'];

$result = array();
$coreAster = new CoreAsteriskInfo($db);

// lg($_GET);

//**********************************
// --- ПОДКЛЮЧАЕМ FREE_PBX НАПРЯМУЮ
if(!empty($_GET['get_free_pbx_config_load'])) {
    // $configLoad = $_GET['get_free_pbx_config_load'];
    require_once 'confFreePbx.php';
}


if($display) {

    $resultItem = array();

    switch ($display) {
        case 'cli' :
            $txtCommand = isGetParam('cli_command_text');
            $result = cliCommandRun($txtCommand);
            break;

        case 'cdr' :
            require_once 'functions/page.cdr.php';
            $result = $resultCdrTable;
            break;

        case 'queues' :
            // require_once 'functions/page.cdr.php';
            $extdisplay = isGetParam('extdisplay');
            $resultItem = queues_get($extdisplay);
            //lg($resultItem);
            $result = $resultItem;
            break;

        case 'extensions' :
            //$result = $currentcomponent;
            $extdisplay = isGetParam('extdisplay');

            if($extdisplay) {
                $extenInfo  = core_users_get($extdisplay);
                $deviceInfo = core_devices_get($extdisplay);
                // foreach ($deviceInfo as $fieldName => $values) {}
                // lg($extenInfo, $deviceInfo);
            }

            break;
    }

    die(json_encode($result));  // -- отдаем результат
}

// ---------------------------------
//**********************************


switch($action)  {

    //--- Получение данных

    case  'CdrDataController' :
        $params = array();
        $funcName = getParam('funcName');
        $dbCdr = new MySQLiClass($cdrDbConfig);
        $getter = new ComponentsDataController($db, $params);
        $cdr   = new CdrDataController($dbCdr, $params, $getter);
        if(method_exists($cdr, $funcName)) {
            $result = $cdr->$funcName();
        }
        else {
            lg('Такой метод- "' .$funcName. '" не существует');
        }
        break;


    case  'ComponentsDataController' :
        $params = array();
        $funcName = getParam('funcName');
        $getter = new ComponentsDataController($db, $params);
        if(method_exists($getter, $funcName)) {
            $result = $getter->$funcName();
        }
        else {
            lg('Такой метод- "' .$funcName. '" не существует');
        }
        break;

    case  'getCoreInfo' :
        $result = $coreAster->getResults();
        // lg($result['queues']);
        break;

//    case  'getExtMap' :
//        $result = $coreAster->getExtMap();
//        lg($result);
//        break;

    case  'getContextIncludesList' :
        $context = getParam('context');
        $result = $coreAster->getContextIncludesList($context);
        // lg($result);
        break;

    case  'getContextIncludesRoutes' :
        $context = getParam('context');
        $result = $coreAster->getContextIncludesRoutes($context);
        // lg($result);
        break;

    case  'getExtensionInfo' :
        $extension = getParam('extension');
        $result = $coreAster->getExtensionInfo($extension);
        // lg($result);
        break;

    case  'getInfoObjetsDetails' :
        $itemId = getParam('item_id');
        $type = getParam('type');
        $objInfo = new InfoObjectsDetails($db);
        $result = $objInfo->getItem($itemId, $type);
        // lg($result);
        break;

    case  'saveInfoObjetsDetails' :
        $itemId = getParam('item_id');
        $objInfo = new InfoObjectsDetails($db);
        $objInfo->getPostData();
        $result = $objInfo->saveInfo($itemId);
        break;

    case  'getContextItem' :
        // $context = '74952411279';
        $context = getParam('context');
        $routeName = getParam('route');
        // lg($context, $routeName);
        $contextItem = $coreAster->getContextItem($context);
        $contextIncludes = $coreAster->getContextIncludesList($context);
        $result = formContextEdit($contextItem[0], $contextIncludes, $routeName);

        // $result = $contextItem;
        // $result = $contextIncludes;
        // lg($result);
        break;

    //--- Сохранение данных
    case  'extensionContextSave' :
        $context   = getParam('context');
        $extension = getParam('extension');
        $result = $coreAster->extensionContextSave($extension, $context);
        // lg($result);
        break;

}

//https://192.168.3.15/admin-lte/api/index.php?action=getCoreInfo
//lg($coreAster->getTableFields('users'));

if(!empty($_GET['lg'])) lg($result['trunks']); //---прямой просмотр

die(json_encode($result));  // -- отдаем результат


function getParam($param = '') {
    $result = '';
    if(!empty($_GET[$param]))
        $result = $_GET[$param];
    return $result;
}

function isGetParam($param = '') {
    $result = '';
    if(!empty($_GET[$param]))
        $result = $_GET[$param];
    return $result;
}


function formContextEdit($item, $itemIncludes, $routeName = '') {
    // lg($itemIncludes);
    $includesArr = array();

    foreach($itemIncludes as $key => $values) {
        $name  = $values['include'];
        $sort  = $values['sort'];
        $context = $values['context'];
        $description = $values['description'];
        $allow = 'yes';

        switch ($name) {
            case 'parkedcalls' :
            case 'from-internal-custom' :
            case 'from-internal-additional' :
            case 'app-cf-busy-prompting-on' :
            case 'app-cf-prompting-on' :
            case 'app-cf-unavailable-prompt-on' :
            case 'park-hints' :
            case 'app-queue-caller-count' :
            case 'ext-local-confirm' :
            case 'findmefollow-ringallv2' :

            case 'outbound-allroutes' :
            case 'outrt-1' :
                $allow = 'no';
                break;
        }

        switch ($context) {
            case 'outbound-allroutes' :
                  $allow = 'no';
                  if($routeName == $description) {
                      $allow = 'yes';
                  }
                  break;
        }

        $includesArr[$name] = array('allow' => $allow, 'sort' =>  $sort,);
    }

    $contextEditModel = array(
        'display' => 'customcontexts',
        'type' => '',
        'extdisplay' => $item['context'],
        'action' => 'edit',
        'newcontext' => $item['context'],
        'description' => $item['description'],
        'dialpattern' => '',
        'setall' => '',
        'failpin' => '',
        'goto0' => '',
        'featurefailpin' => '',
        'goto1' => '',
        'dest0' => 'goto0',
        'dest1' => 'goto1',
        'Submit' => 'Сохранить',
        'includes' => $includesArr,
    );

    return $contextEditModel;
}


function lg() {

    $out = '';
    $get = false;
    $style = 'margin:10px; padding:10px; border:3px red solid;';
    $args = func_get_args();
    foreach ($args as $key => $value) {
        $itemArr = array();
        $itemStr = '';
        is_array($value) ? $itemArr = $value : $itemStr = $value;
        if ($itemStr == 'get')
            $get = true;

        $line = print_r($value, true);
        $out .= '<div style="' . $style . '" ><pre>' . $line . '</pre></div>';
    }

    if ($get)
        return $out;
    print $out;
    exit ;

}


function cliCommandRun($txtCommand) {
    global $astman;
    $result = array();
    if ($astman) {

        $response = $astman->send_request('Command',array('Command'=>"$txtCommand"));
        $responseArr = explode("\n", $response['data']);

//        foreach ($responseArr as $key => $values) {
//            $data = explode(":", $values);
//            if(!empty($data))
//               $result[] = array('name' => $data[0], 'value' => $data[1]);
//        }
//
//        lg($result);
//        // unset($response[0]); //remove the Priviledge Command line
//        // $response = implode("\n",$response);
//        $html_out = htmlspecialchars($response);
        $result = $responseArr;

        return $result;
    }
}


?>

<!--
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Тег FORM</title>
</head>
<body>

<form action="/admin/config.php" method="POST">
    <p><b>Как по вашему мнению расшифровывается аббревиатура &quot;ОС&quot;?</b></p>
    <p> <input type="text" name="name" value="test">Офицерский состав<Br>
        <input type="text" name="user" value="maikl">Операционная система<Br>
    <p><input type="submit"></p>
</form>

</body>
</html>
-->
