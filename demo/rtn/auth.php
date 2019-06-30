<?php
/**
 * Created by PhpStorm.
 * User: jingliu
 * Date: 2019/6/24
 * Time: 6:13 PM
 */

require_once __DIR__ . '/../nropexample/vendor/autoload.php';

echo test();
function test()
{
//    $appid = getenv("WX_APP_ID");
//    $secret = getenv("WX_SCRET_ID");
    $appid = "wx7e1d296a29721ce3";
    $secret = "d38dc311f66c945bf28e93c8268f2067";
    $room = array("ddt1","ddt2","ddt3");

    $params = array();
    $params['code'] = $_GET["code"];
    $params['nickName'] = $_GET["nickName"];
    $params['city'] = $_GET["city"];
    $params['province'] = $_GET["province"];
    $params['avatarUrl'] = $_GET["avatarUrl"];

    $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $secret . "&js_code=" . $params['code'] . "&grant_type=authorization_code";
    $data = doCurl($url);

    $info['openid'] = $data->openid;//获取到用户的openid
    $info['avatar'] = $params['avatarUrl'];
    $info['province'] = $params['province'];
    $info['city'] = $params['city'];
    $info['nickName'] = $params['nickName'];
    $info['room'] = $room;
//    return json(['status' => 1]);
//    return $info;
    return json_encode($info);
}


function doCurl($url)
{
    $curl = curl_init();
    // 使用curl_setopt()设置要获取的URL地址
    curl_setopt($curl, CURLOPT_URL, $url);
    // 设置是否输出header
    curl_setopt($curl, CURLOPT_HEADER, false);
    // 设置是否输出结果
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 设置是否检查服务器端的证书
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // 使用curl_exec()将CURL返回的结果转换成正常数据并保存到一个变量
    $data = curl_exec($curl);
    // 使用 curl_close() 关闭CURL会话
    curl_close($curl);
    return json_decode($data);
}
