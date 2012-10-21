<?php

session_start();


header("Content-Type: text/css");
require_once '../../../arg.php';

$config = new FreiChat();
$config->init_vars();
if (isset($_GET['do']) && $_GET['do'] == 'theme') {
    if (isset($_SESSION[$uid . 'curr_theme'])) {
        $config->freichat_theme = $_SESSION[$uid . 'curr_theme'];
    }
}

if (isset($_SESSION[$uid . 'rtl']) == true) {
    if ($_SESSION[$uid . 'rtl'] == true) {

        require $config->freichat_theme . '/css_rtl.php';
    } else {
        require $config->freichat_theme . '/css.php';
    }
} else {
    require $config->freichat_theme . '/css.php';
}