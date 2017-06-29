function validate() {
  var val = true;
  if($('#nombre').val() == '') {
      $(".error1").show(); $(".error1").html("Por favor introduce tu nombre");
      val = false;
  } else { $(".error1").hide(); }
  if($('#apellidos').val() == '') {
      $(".error2").show(); $(".error2").html("Por favor introduce tu apellido");
      val = false;
  } else { $(".error2").hide();}

  if($('#email').val() == '') {
    $(".error3").show(); $(".error3").html("Por favor introduce tu email");
    val = false;
  } else { $(".error2").hide(); }
  if(!validateEmail($("#email").val())) {
      $(".error3").show(); $(".error3").html("Por favor introduce una direccion de email valida");
      val = false;
  } else { $(".error3").hide(); }

  if ($('#micheck:checked').length  === 0) {
      $(".error4").show(); $(".error4").html("Debes aceptar las condiciones");
      val = false;
  } else { $(".error4").hide(); }

  if (val){
      cropContainer.reset();
      mostarVentana2();  $("#subidor").show();
      $(".error").hide();  $("#yaparticipado").hide();$("#gracias").hide(); $("#subir2").click();
    }
}

$("document").ready(function() {
      $("#submit4").click(function(){
        if($('#cropOutput').val() == '') {
          alert('Por favor sube una foto'); return false;
        }
      });

      $(".aceptoa").on('click', function (e) {
          var marcado = $("#micheck").prop("checked") ? true : false;
          if(marcado) {
            $("#micheck").prop("checked", false);
          } else {
            $("#micheck").prop("checked", true);
          }
      });

        var visit=GetCookie("cookies_cascos");
        if (visit==1){
            $('#cookies').toggle();
        } else {
            var expire=new Date();
            expire=new Date(expire.getTime()+7776000000);
            document.cookie="cookies_cascos=aceptada; expires="+expire;
        }
});

function mostarVentana(){
	$("#ventana").css("display","block");
	$("#resalto").css("display","block");
}
function mostarVentana2(){
	$("#ventana2").show();
	$("#resalto").css("display","block");
}
function cerrarVentana(){
	$("#ventana").css("display","none");
	$("#resalto").css("display","none");
}
function cerrarVentana2(){
  $("#ventana").css("display","none");
      window.location = "index.php?galeria=1";
    }

function cerrarVentana3(){
	$("#ventana2").css("display","none");
	$("#resalto").css("display","none");
  $("#subir").show();
  $("#gracias").hide();
    cropContainer.reset();
    	$("#submit4").hide();
}

function GetCookie(name) {
    var arg=name+"=";
    var alen=arg.length;
    var clen=document.cookie.length;
    var i=0;
    while (i<clen) {
        var j=i+alen;

        if (document.cookie.substring(i,j)==arg)
            return "1";
        i=document.cookie.indexOf(" ",i)+1;
        if (i==0)
             break;
     }
    return null;
}

function aceptar_cookies(){
    var expire=new Date();
    expire=new Date(expire.getTime()+7776000000);
    document.cookie="cookies_cascos=aceptada; expires="+expire;

    var visit=GetCookie("cookies_cascos");
    if (visit==1){
        $('#cookies').toggle();
    }
}

function Siguiente(){
	$("#pagina1").css("display","none");
	$("#pagina2").css("display","block");
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
