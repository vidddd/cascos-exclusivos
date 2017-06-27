<?php
		$state = (string)$_POST['state'];
		$id = (string)$_POST['id'];

		ini_set('include_path', '..');

		require '../lib/settings.php';
		require '../lib/conexion.php';

		$sql = "update participaciones set estado = ".$state." where id = '".$id."';";


		if($mysqli->query($sql))
		{
		 echo 0;
		}
		else
		{
		 echo 1;
		}

		require '../lib/close.php';


?>
