<?php
require_once 'vendor/autoload.php';
require_once 'db.php';
require_once 'config.php';

use Qiniu\Auth;

session_start();
$uid = $_SESSION['uid'];
if(!isset($uid))
{
	header('location: login.php');
	return;
}


$bucket = getenv('QINIU_BUCKET');
$accessKey = getenv('QINIU_ACCESS_KEY');
$secretKey = getenv('QINIU_SECRET_KEY');

$auth = new Auth($accessKey, $secretKey);

$policy = array(
	'callbackUrl' => 'http://172.30.251.210/callback.php',
	'callbackBody' => '{"fname":"$(fname)", "fkey":"$(key)", "desc":"$(x:desc)", "uid":' . $uid . '}'
	);

$upToken = $auth->uploadToken($bucket, null, 3600, $policy);

header('Access-Control-Allow-Origin:*');
echo $upToken;
