
<script src="js/jquery1-12.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
 
 $('#logueo').click(function(event){
    event.preventDefault();
    /*datastring = "&tipodoc="+tipoDoc+"&nrodoc="+nroDoc;*/
    dataForm = $('#login').serialize();
    $.ajax({
      data: dataForm,
      type: "POST",
      dataType: "json",
      url: "forms/validarUsuario.php",
      success: function(data)
      {
        if(data.ret)
        {
         window.location.href = 'main.php';
        }
        else
        {
          alert("Error de credenciales!");
          window.location.href = 'index.php';
        }
      }
    });
});

});


</script>
    <link rel="stylesheet" href="css/style.css">
<?php
include_once 'dbLinker/informaticaDatabaseLinker.class.php';
include_once 'dbLinker/user.class.php';

$infDb = new informaticaDataBaseLinker();

?>

<form name="login" id="login" class="login">
<div class="login"><label class="etiqueta loginLabel" for="username" >Usuario</label> <input type="text" name="username" id="username" /><br /></div>
<div class="login"><label class="etiqueta loginLabel" for="password" >Password</label> <input type="password" name="password" id="password" /><br /></div>
<div class="login"><button class="btnGuardar" name="logueo" id="logueo">Login</button></div>
</form>