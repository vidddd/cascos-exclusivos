<?php
ini_set('include_path', '..');

require '../lib/settings.php';
require '../lib/conexion.php';
require '../lib/utils.php';

$error = '';

/* Este fichero nos permite iniciar session en nuestra aplicacion */
if(isset($_POST['name']) && isset($_POST['pass'])) {
	if(!empty($_POST['name']) && !empty($_POST['pass'])) {

			$name = trunca(quitar($_POST['name']),50); //Limpiamos la variables de entrada
			$pass = trunca(quitar($_POST['pass']),50);

			$query_user_exist = sprintf("SELECT * FROM personal WHERE name = '%s';", $name);

			if($result = $mysqli->query($query_user_exist))	{  //Comprobamos que el usuario existe en nuestros registro de base de datos
			$contador = $result->num_rows;
				if($contador > 0) 	{
						//Ya confirmado que el mail es correcto y existe, realizamos una query que nos devolvera una fila si todo es correcto
						$query_pass_verify = sprintf("SELECT id, email FROM personal WHERE name = '%s' AND pass = '%s';",$name,md5($config->keymd5.$pass));
						if($result2 = $mysqli->query($query_pass_verify)) {
									$contador2 = $result2->num_rows;

									if($contador2 > 0) {


											$fila = $result2->fetch_row();
											$id = $fila[0];
											$email = $fila[1];

											session_start(); //Iniciamos la session
											$_SESSION['USUARIO'] = md5(get_IP());	//Si todo es correcto rellenamos las variables de sesion para luego usarlas en nuestra aplicacion
											$_SESSION['USUARIO_ID'] = $id;
											$_SESSION['USUARIO_EMAIL'] = $email;

											header('Location: ../index.php');
								}
								else {
											$error =  "La contraseña no es correcta";
								}
						}
				}
				else
				{
					$error =  "El usuario no existe o no es correcto";
				}
			}
			}
	}

require '../lib/close.php';


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="../css/admin.css" type="text/css">
</head>
<body>
<div class="cabecera_cms">
  <h1>&nbsp;</h1>
</div>
<div class="container_admin">
	<div class="centrador">
  <form action="" method="POST">

      <label for="name">Usuario</label><br />
      <input class="campos" type="text" value="" name="name"/><br />


      <label for="pass">Contraseña</label><br />
      <input class="campos" type="password" value="" name="pass"/><br />
<br />
    <input class="btn btn-rojo" type="submit" value="ENVIAR" />


    <div class="clear"></div>
  </form>
  <p class="error"><?php echo $error; ?></p>
  </div>
</div>

<div class="clear"></div>
</body>
</html>
