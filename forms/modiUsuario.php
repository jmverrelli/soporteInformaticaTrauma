<?php 
if(session_id() == '') {
    session_start();
}
include_once '../dbLinker/user.class.php';
 $usuario = $infDb->devolverUsuario($_SESSION['usuarioSoporteInf']);

?>

<form id="formModiUsuario" name="formModiUsuario" class="formInsumo">

<div class="conLabel"><label class="etiqueta" for="usuario">Usuario</label><input type="text" name="usuario" value=<?php echo "'".unserialize($usuario->getUsuario()."'"; ?> disabled="disabled"/></div>

<div class="conLabel"><label class="etiqueta" for="password">Password</label><input type="password" name="password" /></div>
<input type="password" name="usuario" style="display:none; visibility:hidden;" value=<?php echo "'".$usuario->getUsuario()."'"; ?> /></div>
<input type="password" name="id" style="display:none; visibility:hidden;" value=<?php echo "'".$usuario->getId()."'"; ?> /></div>
</form>