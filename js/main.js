function validate() {
  if($('#nombre').val() == '') {
        $(".error").show(); $(".error").html("Por favor introduce tu nombre");
  } else if($('#apellidos').val() == '') {
      $(".error").show(); $(".error").html("Por favor introduce tu apellido");
    } else if($('#email').val() == '') {
    $(".error").show(); $(".error").html("Por favor introduce tu email");
    } else if(!validateEmail($("#email").val())) {
      $(".error").show(); $(".error").html("Por favor introduce una direccion de email valida");
    } else if ($('#micheck:checked').length  === 0) {
      $(".error").show(); $(".error").html("Debes aceptar las condiciones");
    } else {
      cropContainer.reset();
      $("#subidor").show();
      $(".error").hide(); mostarVentana(); $("#yaparticipado").hide();$("#gracias").hide(); $("#subir2").click();

    }
}

$("document").ready(function() {
      $("#submit4").click(function(){
        if($('#cropOutput').val() == '') {
          alert('Por favor sube una foto'); return false;
        }
      });
});

function mostarVentana(){
	$("#ventana").css("display","block");
	$("#resalto").css("display","block");
}
function cerrarVentana(){
	$("#ventana").css("display","none");
	$("#resalto").css("display","none");
}
function cerrarVentana2(){
	$("#ventana").css("display","none");
	$("#resalto").css("display","none");
  $("#subir").show();
  $("#gracias").hide();
    cropContainer.reset();
    	$("#submit4").hide();
}
function Siguiente(){
	$("#pagina1").css("display","none");
	$("#pagina2").css("display","block");
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
