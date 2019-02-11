<?php

session_start();
require_once './../Captcha.php';

$captcha = new Captcha();
$_SESSION['code'] = $captcha->getCode();
$captcha->render();