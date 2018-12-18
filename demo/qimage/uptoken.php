<?php
require_once 'vendor/autoload.php';

use Qiniu\Auth;

$bucket = getenv('QINIU_BUCKET');
$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Auth($accessKey, $secretKey);
$upToken = $auth->uploadToken($bucket);

$ret = array('uptoken' => $upToken);

header('Access-Control-Allow-Origin:*');
echo json_encode($ret);
