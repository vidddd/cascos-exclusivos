<?php
session_start();
opcache_reset();
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates/');
$twig = new Twig_Environment($loader, array());
require_once __DIR__ . '/inc/db.class.php';
$db = new Database();
//require_once 'inc/mail.class.php';
//$mail = new Mails;

if($_POST) {
   $nombre = $_POST['nombre']; $apellidos = $_POST['apellidos']; $email = $_POST['email']; $foto = $_POST['cropOutput'];
   if ($db->existeEmail($email)) {
        echo "existe email"; die;
   } else {
       $db->insertaParticipacion($nombre, $apellidos, $email, $foto);
       echo $twig->render('home.html', array("URLHOME" => ''));
   }
} else {
  echo $twig->render('home.html', array("URLHOME" => ''));
}
