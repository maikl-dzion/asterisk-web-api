<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$url = 'https://192.168.3.15/admin/config.php?display=did';

$result = curlInit($url);
print_r($result);

//$result = curlRun($url);
//print_r($result['content']);

// $url = 'https://www.sravni.ru/';

//if($curl = curl_init()) {
//    curl_setopt($curl,CURLOPT_URL, $url);
//    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, false);
//    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
//    curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
//    curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,30);
//    curl_setopt($curl,CURLOPT_USERAGENT,'Bot 1.0');
//    $html = curl_exec($curl);
//    curl_close($curl);
//}
//echo $html;

function curlGet($url)
{

    $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

    $ch = curl_init( $url );

    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);


    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // возвращает веб-страницу
    curl_setopt($ch, CURLOPT_HEADER, 0);           // не возвращает заголовки
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // переходит по редиректам
    curl_setopt($ch, CURLOPT_ENCODING, "");        // обрабатывает все кодировки
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // таймаут соединения
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // таймаут ответа
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // останавливаться после 10-ого редиректа

    $content = curl_exec($ch);
    $err     = curl_errno($ch);
    $errmsg  = curl_error($ch);
    $header  = curl_getinfo($ch);
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}


function curlInit($url = '') {
    // $url = 'https://192.168.3.15/admin/config.php';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
    curl_setopt($ch, CURLOPT_USERPWD, "username:password");
    curl_setopt($ch, CURLOPT_SSLVERSION,3);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//    curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'ecdhe_rsa_aes_128_gcm_sha_256');
//    // curl_setopt($ch, CURLOPT_VERBOSE,true);

    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=admin&password=123456Aa");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

    $result = curl_exec($ch);
    $info['err']        = curl_errno($ch);
    $info['errMessage'] = curl_error($ch);
    $info['header']     = curl_getinfo($ch);

    curl_close($ch);

    if(!empty($info['err'])) {
        print_r($info);
        echo '<br><br>';
        die('---- CURL REQUEST ERROR------');
    }

    return $result;
}


?>