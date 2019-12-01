<?php

function allianceApiPostProcessing() {

    if(empty($_POST['request_api_alliance'])) return false;

    if(!empty($_REQUEST['action'])) {
        $display = $action = '';
        $action = $_REQUEST['action'];
        if(!empty($_REQUEST['display']))
            $display = $_REQUEST['display'];

        switch ($action) {
            case 'addroute' :
                $_REQUEST['trunkpriority'] = explode(',', $_REQUEST['trunkpriority']);
                break;

            case 'edit' :

                switch ($display) {
                    case 'customcontexts' :
                        $includesArr = array();
                        $incTmpArr = explode(',', $_REQUEST['includes']);
                        $ch = 0;
                        $tmp = array();
                        foreach ($incTmpArr as $key => $value) {
                            if($ch == 0) {
                                $tmp['name'] = $value;
                            }
                            elseif($ch == 1) {
                                $tmp['allow'] = $value;
                            }
                            elseif($ch == 2) {
                                $tmp['sort'] = $value;
                                $includesArr[$tmp['name']] = array('allow' => $tmp['allow'], 'sort' => $tmp['sort']);
                                $tmp = array();
                                $ch = -1;
                            }
                            $ch++;
                        }

                        $_REQUEST['includes'] = $includesArr;

                    break;
                }

                break;
        }
    }
}


function allianceApiHandler($vars, $res, $action) {
    // switch ($action) {}
    if(!empty($vars['request_api_alliance'])) {
        die(json_encode($res));
    }

}


//$responseData = array( 'saveStatus' => $saveResult, 'data' => $_REQUEST, 'errMessage' => false);
//allianceApiGetResponse($_REQUEST, $responseData, 'add-context');

function allianceApiReturnPostResponse($params = array(), $cancelResponse = false) {
    if(!empty($_POST['request_api_alliance']) && !$cancelResponse) {
        $params['post'] = $_POST;
        $result = $params;
        die(json_encode($result));
    }
}


function allianceApiGetResponse($vars, $res, $action) {
    //   switch ($action) {}
//    array(
//        'saveStatus' => true,
//        'data'       => array(),
//        'errMessage' => text
//    )
    if(!empty($vars['request_api_alliance'])) {
        die(json_encode($res));
    }

}


function allianceApiExtensionContextSave() {

    if(empty($_POST['request_api_alliance']) && empty($_POST['extension_context_save'])) return false;

    $extension = $_POST['extension'];
    $name      = $_POST['name'];
    $secret    = $_POST['secret'];
    $context   = $_POST['context'];

    $_POST = array();

    $extensionEdit  = array (
        'display' => 'extensions',
        'type'    => '',
        'action'  => 'edit',
        'extdisplay' => $extension,
        'extension'  => $extension,
        'name'       => $name,

        'devinfo_secret_origional' => $secret,
        'devinfo_secret'  => $secret,
        'devinfo_context' => $context,
        'request_api_alliance' => 1,
    );

    $_POST = $extensionEdit;
    $_REQUEST = $_POST;

}


function allianceApiSetSessionVars() {
    if(!empty($_POST['request_api_alliance'])) {
        $session = array('post' => $_POST, 'status' => true);
        $_SESSION['request_api_alliance'] = $session;
    }
}


function allianceApiGetSessionVars() {

    if(!empty($_SESSION['request_api_alliance']['status'])) {
        $post = $_SESSION['request_api_alliance']['post'];
        unset($_SESSION['request_api_alliance']);
        die(json_encode($post));
    }

}

//########################################################
//########################################################
//########################################################
//________________________________________________________
//                   НОВЫЕ ФУНКЦИИ
//________________________________________________________


function setPostData() {

    $method = $_SERVER['REQUEST_METHOD'];
    $postData = array();

    switch($method) {
        case 'POST' :
            $postData = (array)json_decode(file_get_contents('php://input'));
            if(!empty($postData) && !empty($postData[REMOTE_REST_API_FLAG])) {
                $postData = typeOffCastObjToArr($postData);
                $_POST = $postData;
                $_REQUEST = $postData;
                // lg($postData, $_POST, $_SERVER);
            }
            break;
    }
}

function typeOffCastObjToArr($data) {
    $result = array();
    foreach($data as $key => $values) {
        $type = is_object($values);
        if($type) {
            $result[$key] = typeOffCastObjToArr($values);
        }
        else {
            $result[$key] = $values;
        }
    }
    return $result;
}


function returnApiPostError($objError = array(), $errorName = '') {

    if(!empty($_POST[REMOTE_REST_API_FLAG])) {
        $errResult = array('name' => $errorName, 'data' =>$objError);
        die(json_encode(array('error' => $errResult)));
    }
}

function returnApiPostResult($args = array(), $url = '') {

    if(!empty($_POST[REMOTE_REST_API_FLAG])) {

        if(isset($_POST['display']) && $_POST['display'] == 'extensions') {
            if($url) $url = $url . '&' . REMOTE_REST_API_FLAG .'=1';
            return $url;
        }

        $getResult = array($args, $url, $_POST);
        die(json_encode(array('result' => $getResult)));
    }

    return $url;
}

function returnApiGetResult($args = array(), $url = '') {

    if(!empty($_GET[REMOTE_REST_API_FLAG])) {
        $getResult = array($args, $url, $_GET);
        die(json_encode(array('result' => $getResult)));
    }

    return $url;
}


function isHasEmpty($arr = array(), $fieldName = '') {
    $result = '';
    if(!empty($arr[$fieldName])) {
        $result = $arr[$fieldName];
    }
    return $result;
}

// -- ПРОВЕРЯЕМ АВТОРИЗАЦИЮ
function remoteCheckAuth() {

    $authStatus = false;
    $ampUser    = array();
    $sessionVars   = $_SESSION;
    if(!empty($_SESSION["AMP_user"])) {
        $authStatus = true;
        $ampUser    = $_SESSION["AMP_user"];
    }

    $info = array(
        'auth_status' => $authStatus,
        'amp_user'    => $ampUser,
        'session'     => $sessionVars,
    );

    die(json_encode($info));

}

function getRestApiResponse($data = array()) {
    die(json_encode($data));
}


?>