<?php

if(session_id() == '') {
    session_start();
}

unset($_SESSION['usuarioSoporteInf']);

?>

<script src="js/jquery1-12.js" type="text/javascript"></script>
<script src="js/jquery-ui.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="css/style.css">
<div class="login"><label class="etiqueta loginLabel">Se ha deslogueado del sistema.</label></div>
<div class="login"><a href="index.php" class="etiqueta loginLabel" name="relog" id="relog">Relog</a></div>
