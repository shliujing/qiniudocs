<?php

require_once 'vendor/autoload.php';
require_once '../config.php';

const SSO_HOST = Config::SSO_HOST;
const SECRET = Config::SECRET;
const CLIENT_ID = Config::CLIENT_ID;

function safeDecrypt($encrypted, $key)
{
    $cipher="aes-256-cfb";
    $encrypted = base64Padding($encrypted);
    $decodedMsg = base64url_decode($encrypted);
    $ivlen = openssl_cipher_iv_length($cipher);

    if (strlen($decodedMsg)%$ivlen != 0) {
        var_dump('blocksize must be multipe of decoded message length');
    }

    $iv = substr($decodedMsg, 0, $ivlen);
    $msg = substr($decodedMsg, $ivlen);

    $decrypted = openssl_decrypt($msg, $cipher, $key, OPENSSL_RAW_DATA, $iv);

    return unpad($decrypted);
}


function unpad($txt) {
    $str_len = strlen($txt);
    $lastChar = substr($txt, -1);

    $unpad = unpack("C*", $lastChar);
    $unpad_len = array_values($unpad)[0];

    if ($unpad_len > $str_len) {
        var_dump("unpad error. This could happen when incorrect encryption key is used");
        return "";
    }

    return substr($txt, 0, $str_len - $unpad_len);
}

function base64Padding($txt) {
    $m = strlen($txt)%4;
    if ($m != 0) {
        $txt .= str_repeat('=', $m);
    }
    return $txt;
}

function base64url_encode($plainText)
{
    $base64 = base64_encode($plainText);
    $base64url = strtr($base64, '+/', '-_');
    return ($base64url);
}

function base64url_decode($b64Text)
{
    $txt = strtr($b64Text, '-_', '+/');
    return base64_decode($txt);
}

$token = $_GET['token'];
if ($token == '') {
   echo 'invalid signin req';
   exit;
}
$realToken = safeDecrypt($token, SECRET);

$client = new GuzzleHttp\Client();
$resp = file_get_contents(SSO_HOST . '/api/userinfo?' . 'client_id=' . CLIENT_ID . "&token=$realToken");

$resp = $client->request('GET', SSO_HOST . '/api/userinfo?' . 'client_id=' . CLIENT_ID . "&token=$realToken");
//$resp = $client->request('GET', 'http://sso-internal.dev.qiniu.io/api/userinfo?client_id=5abdaf2843c8ce5f540008fd&token=mDZxDQX2sLNYTFUmHY7Y2aytmsRI8Fy7');

$code = $resp->getStatusCode();

if ($code != 200) {
    echo 'unexpected http code:' . $resp->response_code;
} else {
    echo $resp->getBody();
}
exit;




