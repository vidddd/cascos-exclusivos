<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
session_start();
opcache_reset();
error_reporting(E_ALL);
require_once __DIR__ . '/vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('templates/');
$twig = new Twig_Environment($loader, array());
require_once __DIR__ . '/inc/db.class.php';
$db = new Database();

if($_POST['nombre']) {
   $nombre = $_POST['nombre']; $apellidos = $_POST['apellidos']; $email = $_POST['email']; $foto = $_POST['cropOutput'];$fbid = $_POST['fbid'];
   if ($db->existeEmail($email) || $db->existeFbid($fbid) || $fbid == '') {
       echo $twig->render('home.html', array("mensaje" => 2));
   } else {
       $db->insertaParticipacion($nombre, $apellidos, $email, $foto, $fbid);
       echo $twig->render('home.html', array("mensaje" => 1));
   }

} else {
  if ($_GET['galeria'] == 1) {
    if($_POST['textob']) {
      $fotos = $db->getBuscarParticipaciones($_POST['textob']);

      echo $twig->render('galeria.html', array("fotos" => $fotos, "anterior" => 0, "mostrarsig" => $mostrarsig, "siguiente" => 1,  "texto" => $_POST['textob']));
    } else {
      if($_GET['pagina']) { $pag = $_GET['pagina'];
      } else {
        $pag = 1;
      }
      $anterior = $pag - 1;
      $siguiente = $pag + 1;
      $fotos = $db->getParticipaciones($pag);

      echo $twig->render('galeria.html', array("fotos" => $fotos, "anterior" => $anterior, "siguiente" => $siguiente, "texto" => ''));
   }

 } else if ($_GET['participa'] == 1){

    echo $twig->render('home.html', array());
 }  else {

    echo $twig->render('nologin.html', array());
  }
}
