<?php
/**
 * Created by PhpStorm.
 * User: jingliu
 * Date: 2018/11/29
 * Time: 3:20 PM
 */

$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
$URI_PATH = '/demo/qiniu';

$headers = array();
$str_header = "";
foreach ($_SERVER as $key => $value) {
    $header = substr($key, 0, 5);
    if ('HTTP_' == $header ) {
        if ($key == "HTTP_HOST") {
            continue;
        }
        $headers[strtolower(str_replace('_', '-', substr($key, 5)))] = $value;
        $str_header .= strtolower(str_replace('_', '-', substr($key, 5))) . ": " . $value . "<br/>";
    } else if ($key == "REQUEST_METHOD" || $key == "REQUEST_TIME" || $key == "SERVER_PROTOCOL") {
        $headers[strtolower($key)] = $value;
        $str_header .= strtolower($key) . ": " . $value . "<br/>";
    }
}

$body = array();
$str_body = "";
$_get_contents = file_get_contents('php://input');
$_get_contents_json = json_decode($_get_contents, true);

if ($_POST) {
    foreach ($_POST as $key => $value) {
        $body[$key] = $value;
        $str_body .= $key . ": " . $value . "<br/>";
    }
} elseif ($_get_contents_json) {
    $str_body .= $_get_contents;
//    foreach ($_get_contents_json as $key => $value) {
//        $body[$key] = $value;
//        $str_body .= $key . ": " . $value . "<br/>";
//    }
} else {
    $str_body .= $_get_contents;
    foreach ($_REQUEST as $key => $value) {
        $body[$key] = $value;
        $str_body .= $key . ": " . $value . "<br/>";
    }
}

#  date(‘Y-m-d H:i:s’)
$now = date('Y-m-d h:i:s', time());   // 2016-12-31 05:07:05

$str = "回调请求时间：<br/>" . $now . "<br/>" .
    "<br/>回调请求头:<br/>" . $str_header .
    "<br/>回调请求内容体:<br/>" . $str_body .
    "<hr/>";

$fp = file_put_contents($DOCUMENT_ROOT . $URI_PATH . "/log.php", $str, FILE_APPEND);

if ($fp) {// 这个函数支持版本(PHP 5)
    $resp = array('ret' => 'success');
} else {
    $resp = array('ret' => 'failed');
}
echo json_encode($resp);
fclose($fp);
