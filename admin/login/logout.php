<?php
/*
 * Desarrollador: Sergio Sánchez
 * Fecha Creacion: Mayo de 2016
 * Ultima Modificacion: 20/05/2016
 * Empresa: TBWA\ESPAÑA
 * Email: sergio.sanchez@tbwa-i.com
 */
 
ini_set('include_path', '..');

session_start();
session_unset(); //Vaciamos la variables de session 
session_destroy(); //Eliminamos la session

header("location: ../index.php"); //Devolvemos al usuario a la home/login

exit();

?>