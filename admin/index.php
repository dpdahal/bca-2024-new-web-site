<?php

require_once '../config/config.php';

if(!isset($_SESSION['user'])){
    header('Location: ../login.php');
    exit();
}

$uri =$_GET['uri'] ?? 'dashboard';
$uri =str_replace('.php','',$uri);
$title=$uri;
$uri = $uri.'.php';

$pagePath="pages/".$uri;


require_once 'header.php';
require_once 'aside.php';


if(file_exists($pagePath) && is_file($pagePath)){
    include $pagePath;
}else{
    include 'pages/404.php';
}

require_once 'footer.php';