<?php
/**
 * Created by PhpStorm.
 * User: jingliu
 * Date: 2018/11/29
 * Time: 3:20 PM
 */

$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
$URI_PATH = '/demo/qiniu';

$reset_content = '<meta http-equiv="Content-Type" Content="text/html;charset=utf8"/>';
$fp = file_put_contents($DOCUMENT_ROOT . $URI_PATH . "/log.php", $reset_content, FILE_TEXT);

if ($fp) {// 这个函数支持版本(PHP 5)
    $resp = array('ret' => 'success');
} else {
    $resp = array('ret' => 'failed');
}
echo json_encode($resp);
fclose($fp);
