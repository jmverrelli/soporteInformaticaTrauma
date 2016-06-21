<!-- esto ya hace y manda el formulario serializado a validarInsumo.php -->
<?php

if(session_id() == '') {
    session_start();
}

if(!isset($_SESSION['usuarioSoporteInf']))
{
  header('Location: lgout.php');
  exit;
}

include_once '../dbLinker/user.class.php';

include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();



 $usuario = $infDb->devolverUsuario($_SESSION['usuarioSoporteInf']);

?>
<script type="text/javascript">

 
 $('#fechaRecibido').datepicker({ dateFormat: 'yy-mm-dd' });

 $('#horaRecibido').timepicker({ 'scrollDefault': 'now' });

</script>

<form class="formInsumo" id="formInsumo" name="formInsumo">

<div class="conLabel">
<label for="insumo" class="etiqueta">Equipo</label><input class="etiqueta" id="insumo" name="insumo" />
</div>

<div class="conLabel">
<label class="etiqueta" for="centro">Centro</label>
<select class=" select etiqueta" id="centro" name="centro">}
<option value="1">Abete</option>
<option value="2">Pediatrico</option>
<option value="3">Materno</option>
<option value="4">Cormillot</option>
<option value="5">Polo</option>
<option value="6">Drozdowski</option>
<option value="7">Otros? Wat?</option>
</select>
</div>


<div class="conLabel">
<label for="sector" class="etiqueta">Sector</label><input class="etiqueta" id="sector" name="sector" />
</div>


<div class="conLabel">
<label class="etiqueta" for="estado">Estado</label>
<select class=" select etiqueta" id="estado" name="estado">}
<option value="1">En espera</option>
<option value="2">En reparacion</option>
<option value="3">Reparado</option>
<option value="4">Entregado</option>
<option value="5">Baja</option>
</select>
</div>

<div class="conLabel">
<label class="etiqueta" for="fechaRecibido">Fecha Recibido</label>
<input class="etiqueta" name="fechaRecibido" id="fechaRecibido">
</div>

<div class="conLabel">
<label class="etiqueta" for="horaRecibido">Hora Recibido</label>
<input class="etiqueta" name="horaRecibido" id="horaRecibido">
</div>

<div class="conLabel">
<label class="etiqueta" for="observaciones">Observaciones</label>
<textarea class="etiqueta" name="observaciones" id="observaciones"></textarea>
</div>

<input type="text" name="user" style="visibility:hidden; display:none;" value=<?php echo "'".$usuario->getUsuario()."'"; ?> >

</form>