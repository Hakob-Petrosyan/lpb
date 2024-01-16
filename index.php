<?php
/*
 * This file is part of MODX Revolution.
 *
 * Copyright (c) MODX, LLC. All Rights Reserved.
 *
 * For complete copyright and license information, see the COPYRIGHT and LICENSE
 * files found in the top-level directory of this distribution.
 */



//редиректы из файла
$protocol = (!empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS'])) ? 'https' : 'http';
$host = $protocol.'://'.$_SERVER['HTTP_HOST'];
$path = parse_url($_SERVER['REQUEST_URI'])['path'];
$path = iconv(mb_detect_encoding($path),'ASCII//TRANSLIT', $path);
/*if ($protocol!='https'){
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
    exit;
}*/
$redirectsMapFilePath = $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'redirects.csv';
$redirectsMapFileContent = file_get_contents($redirectsMapFilePath);
$redirectsMapRows = explode("\r\n", $redirectsMapFileContent);
$redirectsMap = [];
foreach ($redirectsMapRows as $row){
    list($from, $to) = explode(';', $row);
    $_from = iconv(mb_detect_encoding($from), 'ASCII//TRANSLIT', $from);
    $_to = iconv(mb_detect_encoding($to), 'ASCII//TRANSLIT', $to);
    if($_from){
        $redirectsMap[$_from] = $_to;
    }
}
if(array_key_exists($path, $redirectsMap)){
    $toPath = $redirectsMap[$path];
    if($toPath !== $path){
        $toUrl = $host . $redirectsMap[$path];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $toUrl);
        exit;
    }
}

$tstart= microtime(true);

/* define this as true in another entry file, then include this file to simply access the API
 * without executing the MODX request handler */
if (!defined('MODX_API_MODE')) {
    define('MODX_API_MODE', false);
}

/* include custom core config and define core path */
/*var_dump(MODX_CORE_PATH);
exit();*/
@include(dirname(__FILE__) . '/config.core.php');



if (!defined('MODX_CORE_PATH')) define('MODX_CORE_PATH', dirname(__FILE__) . '/core/');



/* include the modX class */
if (!@include_once (MODX_CORE_PATH . "model/modx/modx.class.php")) {

    $errorMessage = 'Site temporarily unavailable';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');

    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* start output buffering */
ob_start();

/* Create an instance of the modX class */
$modx= new modX();
if (!is_object($modx) || !($modx instanceof modX)) {
    ob_get_level() && @ob_end_flush();
    $errorMessage = '<a href="setup/">MODX not installed. Install now?</a>';
    @include(MODX_CORE_PATH . 'error/unavailable.include.php');
    header($_SERVER['SERVER_PROTOCOL'] . ' 503 Service Unavailable');
    echo "<html><title>Error 503: Site temporarily unavailable</title><body><h1>Error 503</h1><p>{$errorMessage}</p></body></html>";
    exit();
}

/* Set the actual start time */
$modx->startTime= $tstart;

/* Initialize the default 'web' context */
$modx->initialize('web');

/* execute the request handler */
if (!MODX_API_MODE) {
    $modx->handleRequest();
}
