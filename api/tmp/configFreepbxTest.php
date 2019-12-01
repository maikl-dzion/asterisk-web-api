<?php

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

// lg('567', $_SESSION);

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

header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');


// This needs to be included BEFORE the session_start or we fail so
// we can't do it in bootstrap and thus we have to depend on the
// __FILE__ path here.
require_once(dirname(__FILE__) . '/libraries/ampuser.class.php');

session_set_cookie_params(60 * 60 * 24 * 30);//(re)set session cookie to 30 days
ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 30);//(re)set session to 30 days
if (!isset($_SESSION)) session_start();  //start a session if we need one

//unset the ampuser if the user logged out
if ($logout == 'true') {
    unset($_SESSION['AMP_user']);
    exit();
}


// lg($_SESSION);

//session_cache_limiter('public, no-store');
if (isset($_REQUEST['handler'])) {
    // lg($_REQUEST);
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

// lg($amp_conf);

// call bootstrap.php through freepbx.conf
// вызвать bootstrap.php через freepbx.conf
if (!@include_once(getenv('FREEPBX_CONF') ? getenv('FREEPBX_CONF') : '/etc/freepbx.conf')) {
    include_once('/etc/asterisk/freepbx.conf');
}


die('-stop-');

