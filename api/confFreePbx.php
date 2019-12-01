<?php

// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Headers: *');

$pathArr = explode('/', dirname(__DIR__));
$FREEPBX_ADMIN_ROOT_FOLDER = end($pathArr);
// lg(dirname(__DIR__));

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('REMOTE_REST_API_NAME' , 'remote_request_rest_api_service');
define('REMOTE_REST_API_FLAG' , 'remote_request_rest_api_service');
define('FREEPBX_ROOT_FOLDER_NAME', $FREEPBX_ADMIN_ROOT_FOLDER);
define('FREEPBX_WEB_ROOT_DIR'    , dirname(__DIR__));

//$amp_conf['AMPDBUSER']	= 'asteriskuser';
//$amp_conf['AMPDBPASS']  = '123456Aa';
//$amp_conf['AMPDBHOST']	= 'localhost';
//$amp_conf['AMPDBNAME']	= 'asterisk';
//$amp_conf['AMPDBENGINE'] = 'mysql';
//$amp_conf['datasource']	= ''; //for sqlite3

$directoryName = dirname(__DIR__) . '/admin';

require $directoryName . '/allianceApiFunctions.php';
allianceApiPostProcessing();
setPostData();


$vars = array(
    'action' => null,
    'confirm_email' => '',
    'confirm_password' => '',
    'display' => '',
    'extdisplay' => null,
    'email_address' => '',
    'fw_popover' => '',
    'fw_popover_process' => '',
    'logout' => false,
    'password' => '',
    'quietmode' => '',
    'restrictmods' => false,
    'skip' => 0,
    'skip_astman' => false,
    'type' => '',
    'username' => '',
);


foreach ($vars as $k => $v) {
    //were use config_vars instead of, say, vars, so as not to polute
    // page.<some_module>.php (which usually uses $var or $vars)
    $config_vars[$k] = $$k = isset($_REQUEST[$k]) ? $_REQUEST[$k] : $v;

    //special handeling
    switch ($k) {
        case 'extdisplay':
            $extdisplay = (isset($extdisplay) && $extdisplay !== false)
                ? htmlspecialchars($extdisplay, ENT_QUOTES)
                : false;
            $_REQUEST['extdisplay'] = $extdisplay;
            break;

        case 'restrictmods':
            $restrict_mods = $restrictmods
                ? array_flip(explode('/', $restrictmods))
                : false;
            break;

        case 'skip_astman':
            $bootstrap_settings['skip_astman'] = $skip_astman;
            break;
    }
}

//header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
//header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
//header('Cache-Control: post-check=0, pre-check=0', false);
//header('Pragma: no-cache');
//header('Content-Type: text/html; charset=utf-8');

// This needs to be included BEFORE the session_start or we fail so
// we can't do it in bootstrap and thus we have to depend on the
// __FILE__ path here.

require_once($directoryName . '/libraries/ampuser.class.php');

session_set_cookie_params(60 * 60 * 24 * 30);//(re)set session cookie to 30 days
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);//(re)set session to 30 days
if (!isset($_SESSION)) session_start();  //start a session if we need one

//unset the ampuser if the user logged out
if ($logout == 'true') {
    unset($_SESSION['AMP_user']);
    exit();
}


//session_cache_limiter('public, no-store');
if (isset($_REQUEST['handler'])) {
    if ($restrict_mods === false)
        $restrict_mods = true;

    // I think reload is the only handler that requires astman, so skip it
    //for others
    switch ($_REQUEST['handler']) {
        case 'api'   : break;
        case 'reload': break;
        default:
            // If we didn't provide skip_astman in the $_REQUEST[] array it will be boolean false and for handlers, this should default
            // to true, if we did provide it, it will NOT be a boolean (it could be 0) so we will honor the setting
            //
            $bootstrap_settings['skip_astman'] = $bootstrap_settings['skip_astman'] === false ? true : $bootstrap_settings['skip_astman'];
            break;
    }
}


// call bootstrap.php through freepbx.conf
// вызвать bootstrap.php через freepbx.conf
//if (!@include_once(getenv('FREEPBX_CONF') ? getenv('FREEPBX_CONF') : '/etc/freepbx.conf')) {
// include_once('/etc/asterisk/freepbx.conf');
// lg(dirname(__DIR__));

require_once(dirname(__DIR__) . '/admin/bootstrap.php');

// }


/* If there is an action request then some sort of update is usually being done.
   This may protect from cross site request forgeries unless disabled.
*/
if (!isset($no_auth) && $action != '' && $amp_conf['CHECKREFERER']) {
    if (isset($_SERVER['HTTP_REFERER'])) {
        $referer = parse_url($_SERVER['HTTP_REFERER']);
        $refererok = (trim($referer['host']) == trim($_SERVER['SERVER_NAME'])) ? true : false;
    } else {
        $refererok = false;
    }
    if (!$refererok) {
        $display = 'badrefer';
    }
}
if (isset($no_auth) && empty($display)) {
    $display = 'noauth';
}

// handle special requests
if (!in_array($display, array('noauth', 'badrefer')) && isset($_REQUEST['handler'])) {
    $module = isset($_REQUEST['module']) ? $_REQUEST['module'] : '';
    $file = isset($_REQUEST['file']) ? $_REQUEST['file'] : '';
    fileRequestHandler($_REQUEST['handler'], $module, $file);
    exit();
}


if (!$quietmode) {
    module_run_notification_checks();
}


//draw up freepbx menu
$fpbx_menu = array();

// pointer to current item in $fpbx_menu, if applicable
$cur_menuitem = null;

// add module sections to $fpbx_menu
if (is_array($active_modules)) {
    // lg($active_modules);
    foreach ($active_modules as $key => $module) {

        // создать массив разделов модулей для отображения
        // stored as [items][$type][$category][$name] = $displayvalue
        if (isset($module['items']) && is_array($module['items'])) {
            // перебирать типы
            foreach ($module['items'] as $itemKey => $item) {

                // check access, unless module.xml defines all have access
                //TODO: move this to bootstrap and make it work
                //module is restricted to admin with excplicit permission
                $needs_perms = !isset($item['access'])
                || strtolower($item['access']) != 'all'
                    ? true : false;

                //check if were logged in
                $admin_auth = isset($_SESSION["AMP_user"])
                    && is_object($_SESSION["AMP_user"]);

                //per admin access rules
                $has_perms = $admin_auth
                    && $_SESSION["AMP_user"]->checkSection($itemKey);

                //requies authentication
                $needs_auth = isset($item['requires_auth'])
                && strtolower($item['requires_auth']) == 'false'
                    ? false
                    : true;

                //skip this module if we dont have proper access
                //test: if we require authentication for this module
                //			and either the user isnt authenticated
                //			or the user is authenticated and dose require
                //				section specifc permissions but doesnt have them
                if ($needs_auth
                    && (!$admin_auth || ($needs_perms && !$has_perms))
                ) {
                    //clear display if they were trying to gain unautherized
                    //access to $itemKey. If there logged in, but dont have
                    //permissions to view this specicc page - show them a message
                    //otherwise, show them the login page
                    if ($display == $itemKey) {
                        if ($admin_auth) {
                            $display = 'noaccess';
                        } else {
                            $display = 'noauth';
                        }
                    }
                    continue;
                }

                if (!isset($item['display'])) {
                    $item['display'] = $itemKey;
                }

                // reference to the actual module
                $item['module'] =& $active_modules[$key];

                // item is an assoc array, with at least
                //array(module=> name=>, category=>, type=>, display=>)
                $fpbx_menu[$itemKey] = $item;

                // allow a module to replace our main index page
                if (($item['display'] == 'index') && ($display == '')) {
                    $display = 'index';
                }

                // check current item
                if ($display == $item['display']) {
                    // found current menuitem, make a reference to it
                    $cur_menuitem =& $fpbx_menu[$itemKey];
                }
            }
        }
    }
}

if ($cur_menuitem === null && !in_array($display, array('noauth', 'badrefer', 'noaccess', ''))) {
    $display = 'noaccess';
}


// новые gui-крючки
if (!$quietmode && is_array($active_modules)) {

    foreach ($active_modules as $key => $module) {
        modgettext::push_textdomain($module['rawname']);
        if (isset($module['items']) && is_array($module['items'])) {
            foreach ($module['items'] as $itemKey => $itemName) {
                // список потенциальных функций _configpageinit
                $initfuncname = $key . '_' . $itemKey . '_configpageinit';
                if (function_exists($initfuncname)) {
                    $configpageinits[] = $initfuncname;
                }
            }
        }
        //проверьте уровень модуля (а не на элемент, как указано выше) _configpageinit function
        $initfuncname = $key . '_configpageinit';
        if (function_exists($initfuncname)) {
            $configpageinits[] = $initfuncname;
        }
        modgettext::pop_textdomain();
    }

}


// расширений устройства / пользователей ... это плохой дизайн, но он работает
if (!$quietmode && isset($fpbx_menu["extensions"])) {
    if (isset($amp_conf["AMPEXTENSIONS"])
        && ($amp_conf["AMPEXTENSIONS"] == "deviceanduser")) {
        unset($fpbx_menu["extensions"]);
    } else {
        unset($fpbx_menu["devices"]);
        unset($fpbx_menu["users"]);
    }
}


// загрузить компонент из загруженных модулей
// Здесь происходит сохранение POST-запросов в том числе
$testFuncArr = array();

if (!in_array($display, array('', 'badrefer'))
    && isset($configpageinits) && is_array($configpageinits))  {

    // die('current-component');

    $CC = $currentcomponent = new component($display, $type);

    // вызывать все модули _configpageinit, которые должны просто
    // регистрируем функции gui и process для каждого модуля, если это необходимо
    // для этого display
    foreach ($configpageinits as $func) {
        $func($display);
        $testFuncArr[] = array($func, $display);
        // echo $func . '('. $display . ')<br>';
    }

    // теперь запускаем каждую функцию «process» и функцию «gui»
    $currentcomponent->processconfigpage();
    $currentcomponent->buildconfigpage();
}


// lg($currentcomponent);

// lg(core_destinations());
// lg(core_users_list());
// lg(core_check_extensions(33));


// $deviceInfo = core_devices_get($extdisplay);
// $extenInfo = core_users_get($extdisplay);
// $device_list = core_devices_list('all', 'full');
// $extensionDelUrl = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'] . '&action=del';
// $dids = core_did_list('extension');

// core_users_configpageload()
// core_devices_configpageload()