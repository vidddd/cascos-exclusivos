<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('include_path', '..');
//set_include_path('.:');
session_start();

require "lib/utils.php";

//Comprobacion de session
if (!isset($_SESSION['USUARIO']) && !$_SESSION['USUARIO'] == md5(get_IP())){ header("location: login/login.php");  }


?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/admin.css" type="text/css">
</head>
<body>
<div class="menu">
  <div class="large-12 medium-12 small-12 columns" id="buttoms">
    <ul class="menu_secundario">
      <li class="active btn-state pendiente" state="1"><a>Pendientes</a></li>
      <li class="btn-state rechazadas" state="3"><a>Rechazadas</a></li>
      <li class="btn-state aceptadas" state="2"><a>Aceptadas</a></li>
    </ul>
  </div>
</div>
<div class="row">
  <div id="socialhub" class="socialhub">
    <div id="items" class="items"> </div>
  </div>
</div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
	 $(document).ready(function(){
		llenar(0,1);

		$(".btn-state").click(function(){
			$('.btn-state').removeClass('active');
			$(this).addClass('active');
			state = $(this).attr("state");
			llenar(0,state);
		});
	 });

	 function change(statein,objectin){
		id = $(objectin).parent().parent().parent().attr("id").replace("item_","");
		changestate(statein,id);
	 }

	 function changestate(state,id)
	 {
	  $.ajax({

			  url: "back/changestate.php",
			  type: 'POST',
			  data: {
				state: state,
				id:id
			  },
			  success: function(data) {
				if (data == 0)
				{
					$("#item_"+id).hide();
				}

			  }
		});


	 }

	 function llenar(inicio,state)
	 {
	 $( "#container" ).html("");
		$.ajax({
			  url: "back/getphotos.php",
			  type: 'POST',
			  data: {
				state: state,
				inicio: inicio,
				items: 30 //Items por pagina
			  },
			  success: function(data) {
				$("#items").html(data);
			  }
		});
	 }
 </script>
</body>
</html>
