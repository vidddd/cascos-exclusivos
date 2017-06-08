<?php
session_start();
opcache_reset();
//error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates/');
$twig = new Twig_Environment($loader, array());
require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.class.php';
$db = new Database();
require_once 'inc/mail.class.php';
$mail = new Mails;
$locations = $db->getLocations();

    echo $twig->render('home.html', array("URLHOME" => URL_HOME));
