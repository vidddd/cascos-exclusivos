<?php

 
//Funciones auxiliares


function hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function quitar($mensaje){ //Los password no pueden contener ninguno de estos caracteres
	$mensaje = str_replace("<","&lt;",$mensaje);
	$mensaje = str_replace(">","&gt;",$mensaje);
	$mensaje = str_replace("\'","'",$mensaje);
	$mensaje = str_replace('\"',"&quot;",$mensaje);
	$mensaje = str_replace("\\\\","\\",$mensaje);
	$mensaje = str_replace("\\","",$mensaje);
	$mensaje = str_replace("*","",$mensaje);
	$mensaje = str_replace("'","",$mensaje);
	$mensaje = str_replace("=","",$mensaje);
	$mensaje = str_replace("--","",$mensaje);
	$mensaje = str_replace(";","",$mensaje);
	$mensaje = str_replace("+","",$mensaje);
	$mensaje = str_replace("%","",$mensaje);
	$mensaje = str_replace("SCRIPT ","",$mensaje);
	$mensaje = str_replace("SELECT ","",$mensaje);
	$mensaje = str_replace(" OR ","",$mensaje);
	$mensaje = str_replace(" AND ","",$mensaje);
	$mensaje = str_replace(" XOR ","",$mensaje);
	$mensaje = str_replace("UPDATE ","",$mensaje);
	$mensaje = str_replace("DELETE ","",$mensaje);
	$mensaje = str_replace("TRUNCATE ","",$mensaje);
	$mensaje = str_replace("SHOW ","",$mensaje);
	$mensaje = str_replace("DROP ","",$mensaje);
	
	 return $mensaje;
}

function push_log($mensaje){
	include "settings.php";
	include "conexion.php";
	if(!empty($mensaje) && isset($mensaje) && $mensaje != '') {
			$query_log_insert = sprintf("INSERT INTO lsm_log (mensaje,date,ip,referer,agent) values ('%s',NOW(),'%s','%s','%s');", $mensaje, get_IP(), get_Referer(), get_Agent());			
			return $mysqli->query($query_log_insert);		
			}
			else{
			return false;
			}
	
}

//Obtiene la ip real del usuario
function get_IP(){
	if ($_SERVER) {
		  if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				   $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		   } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
				   $realip = $_SERVER["HTTP_CLIENT_IP"];
		   } else {
				   $realip = $_SERVER["REMOTE_ADDR"];
		   }
	} else {
		   if (getenv('HTTP_X_FORWARDED_FOR')) {
				   $realip = getenv('HTTP_X_FORWARDED_FOR');
		   } elseif (getenv('HTTP_CLIENT_IP')) {
				   $realip = getenv('HTTP_CLIENT_IP');
		   } else {
				   $realip = getenv('REMOTE_ADDR');
		   }
	}
	return $realip;
}

// Codificador mime
function _mb_mime_encode($string, $encoding)
{
    $pos = 0;
    // after 36 single bytes characters if then comes MB, it is broken
    // but I trimmed it down to 24, to stay 100% < 76 chars per line
    $split = 24;
    while ($pos < mb_strlen($string, $encoding))
    {
        $output = mb_strimwidth($string, $pos, $split, "", $encoding);
        $pos += mb_strlen($output, $encoding);
        $_string_encoded = "=?".$encoding."?B?".base64_encode($output)."?=";
        if ($_string)
            $_string .= "\r\n";
        $_string .= $_string_encoded;
    }
    $string = $_string;
    return $string;
}

//Obtiene la hora
function get_Date(){
	$tm= date ("Y-m-d H:i:s", time());
	return $tm;
}

//Obtiene el Referer
function get_Referer(){
	$ref=$_SERVER['HTTP_REFERER'];
	return $ref;
}

//Obtiene el User Agent
function get_Agent(){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	return $agent;
}

//Truncador de texto
function trunca($string, $limit) { 
	// return with no change if string is shorter than $limit 
	if(strlen($string) <= $limit){
		return $string;
	}
	$string = substr($string, 0, $limit);
	return $string;
}


function is_DNI($cif) {
 //Returns: 
 // 1 = NIF ok,
 // 2 = CIF ok,
 // 3 = NIE ok,
 //-1 = NIF bad,
 //-2 = CIF bad, 
 //-3 = NIE bad, 0 = ??? bad
 $cif = strtoupper($cif);
  
 for ($i = 0; $i < 9; $i ++){
       $num[$i] = substr($cif, $i, 1);
 }
 //si no tiene un formato valido devuelve error
 if (!ereg('((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^
[0-9]{8}[A-Z]{1}$)', $cif)){
       return 0;
 }
 //comprobacion de NIFs estandar
 
 if (ereg('(^[0-9]{8}[A-Z]{1}$)', $cif)){
  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', 
      substr($cif, 0, 8) % 23, 1)){
   return 1;
  }else {
   return -1;
  }
 }
 //algoritmo para comprobacion de codigos tipo CIF
 $suma = $num[2] + $num[4] + $num[6];
 for ($i = 1; $i < 8; $i += 2){
       $suma += substr((2 * $num[$i]),0,1) + 
                substr((2 * $num[$i]),1,1);
 }
 $n = 10 - substr($suma, strlen($suma) - 1, 1);
 //comprobacion de NIFs especiales (se calculan como CIFs)
 if (ereg('^[KLM]{1}', $cif)){
  if ($num[8] == chr(64 + $n)){
          return 1;
  }else{
          return -1;
  }
 }
 //comprobacion de CIFs
 if (ereg('^[ABCDEFGHJNPQRSUVW]{1}', $cif)){
  if ($num[8] == chr(64 + $n) || $num[8] == 
      substr($n, strlen($n) - 1, 1)){
   return 2;
  }else{
   return -2;
  }
 }
 //comprobacion de NIEs
 //T
 if (ereg('^[T]{1}', $cif)){
  if ($num[8] == ereg('^[T]{1}[A-Z0-9]{8}$', $cif)){
   return 3;
  }else{
   return -3;
  }
 }
 //XYZ
 if (ereg('^[XYZ]{1}', $cif)){
  if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', 
      substr(str_replace(array('X','Y','Z'), 
      array('0','1','2'), $cif), 0, 8) % 23, 1)){
   return 3;
  }else{
   return -3;
  }
 }
 //si todavia no se ha verificado devuelve error
 return 0;
} 
?>