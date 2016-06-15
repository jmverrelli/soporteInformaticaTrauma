<?php 
include_once '../dbLinker/user.class.php';
session_start();
?>

<form id="formModiUsuario" name="formModiUsuario" class="formInsumo">

<div class="conLabel"><label class="etiqueta" for="usuario">Usuario</label><input type="text" name="usuario" value=<?php echo "'".$_SESSION['usuarioSoporteInf']->getUsuario()."'"; ?> disabled="disabled"/></div>

<div class="conLabel"><label class="etiqueta" for="password">Password</label><input type="password" name="password" /></div>
<input type="password" name="usuario" style="display:none; visibility:hidden;" value=<?php echo "'".$_SESSION['usuarioSoporteInf']->getUsuario()."'"; ?> /></div>
<input type="password" name="id" style="display:none; visibility:hidden;" value=<?php echo "'".$_SESSION['usuarioSoporteInf']->getId()."'"; ?> /></div>
</form>