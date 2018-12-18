<?php
require_once  'vendor/autoload.php';
header('Access-Control-Allow-Origin:*');

use Qiniu\Auth;

$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');
$bucket = "test-pub";
$auth = new Auth($accessKey, $secretKey);

//$upToken = $auth->uploadToken($bucket);

$policy = array(
    'returnUrl' => 'http://127.0.0.1/demo/simpleuploader/fileinfo.php',
    'returnBody' => '{"fname": $(fname)}',
);
$upToken = $auth->uploadToken($bucket, null, 3600, $policy);

echo $upToken;
