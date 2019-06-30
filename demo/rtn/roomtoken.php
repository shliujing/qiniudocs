<?php
/**
 * Created by PhpStorm.
 * User: jingliu
 * Date: 2019/6/30
 * Time: 1:01 PM
 */

require_once("php-sdk-7.2.7/autoload.php");

use \Qiniu\Auth;

$ak = '_PhMT0UWyjOZT-ettpOy-MlZ9sjMwCYXPRI5iCDB';
$sk = 'IziIqO5B41WZxfQSC4Q47gW2nTrapC71aqQO0fPr';

$auth = new Auth($ak, $sk);
$client = new Qiniu\Rtc\AppClient($auth);
$appId = $_GET["app"]; #  'ead903g53';
$roomName= $_GET["room"];
$userId = $_GET["user"];
$hub = 'ddt-pili';
$title = 'ddt';
$maxUsers = '100';
try {
    //创建app
    $resp = $client->createApp($hub, $title, $maxUsers);
//    print_r($resp);
    // 获取app状态
//    $resp = $client->getApp($appId);
//    print_r('状态：'.$resp);
    //修改app状态
//    $mergePublishRtmp = null;
//    $mergePublishRtmp['enable'] = true;
//    $resp = $client->updateApp($appId, $hub, $title, $maxUsers, $mergePublishRtmp);
//    print_r($resp);
//    //删除app
//    $resp = $client->deleteApp($appId);
//    print_r($resp);
    //获取房间连麦的成员
//    $resp=$client->listUser($appId, $roomName);
//    print_r('在线：'.$resp);
//    //剔除房间的连麦成员
//    $resp=$client->kickUser($appId, $roomName, $userId);
//    print_r($resp);
//    // 列举房间
//    $resp=$client->listActiveRooms($appId, $roomName, null, null);
//    print_r($resp);
    //鉴权的有效时间: 1个小时.
    $resp = $client->appToken($appId, $roomName, $userId, (time()+3600), 'user');
//    print_r($resp);
    echo $resp;
} catch (\Exception $e) {
    echo "Error:", $e, "\n";
}
