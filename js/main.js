function validate() {
  if($('#nombre').val() == '') {
    alert('Por favor introduce un nombre');
  } else if($('#apellidos').val() == '') {
      alert('Introduce un apellido');
    } else if($('#email').val() == '') {
      alert('Introduce un email');
    } else if(!validateEmail($("#email").val())) {
      alert('Introduce un email válido');
    } else if ($('#micheck:checked').length  === 0) {
      alert('Debes aceptar las condiciones');
    } else {
      mostarVentana(); $("#yaparticipado").hide(); $("#subir2").click();
      //alert(cropContainer);
      //cropContainer.imgUploadControl.init();
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
}
function cerrarVentana(){
	$("#ventana").css("display","none");
}
function cerrarVentana2(){
	$("#ventana").css("display","none");
  	$("#subir").show();	$("#submit4").show();
}
function Siguiente(){
	$("#pagina1").css("display","none");
	$("#pagina2").css("display","block");
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
