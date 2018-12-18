<?php
require_once '../config.php';

const SSO_HOST = Config::SSO_HOST;
const CLIENT_ID = Config::CLIENT_ID;

function loginUrl() {
    return SSO_HOST . '?client_id=' . CLIENT_ID . '&redirect=' . 'http://practice.dandantuan.com/demo/sso/sso.php';
}

function checkLogin()  {
    return false;
}

if (!checkLogin()) {
    header('Location: ' . loginUrl(), true, 302);
    exit;
}
