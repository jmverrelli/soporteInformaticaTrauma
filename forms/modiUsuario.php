<?php 
if(session_id() == '') {
    session_start();
}
if(!isset($_SESSION['usuarioSoporteInf']))
{
  header('Location: lgout.php');
  exit;
}

include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();
 $usuario = $infDb->devolverUsuario($_SESSION['usuarioSoporteInf']);
 $user = $usuario->getUsuario();

?>

<form id="formModiUsuario" name="formModiUsuario" class="formInsumo">

<div class="conLabel"><label class="etiqueta" for="usuario">Usuario</label><input type="text" name="usuario" value=<?php echo "'".$user."'"; ?> disabled="disabled"/></div>

<div class="conLabel"><label class="etiqueta" for="password">Password</label><input type="password" name="password" /></div>
<input type="password" name="usuario" style="display:none; visibility:hidden;" value=<?php echo "'".$usuario->getUsuario()."'"; ?> /></div>
<input type="password" name="id" style="display:none; visibility:hidden;" value=<?php echo "'".$usuario->getId()."'"; ?> /></div>
</form>