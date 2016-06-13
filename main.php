<?php

include_once 'dbLinker/informaticaDatabaseLinker.class.php';
include_once 'dbLinker/user.class.php';
$infDb = new informaticaDataBaseLinker();

session_start();

if(!isset($_SESSION['usuario']))
{
  header('Location: lgout.php');
  exit;
}
else
{
  $usuario = $_SESSION['usuario'];
  $permisos = $infDb->traerPermisos($usuario->getId());
  $agregarUsuario = false;
  $eliminarUsuario = false;
  for($i = 0; $i < count($permisos); $i++)
  {
    if($permisos[$i]['permiso'] == "AGREGAR_USUARIO")
    {
      $agregarUsuario = true;
    }
     if($permisos[$i]['permiso'] == "ELIMINAR_USUARIO")
    {
      $eliminarUsuario = true;
    }
  }
}

$reparaciones = $infDb->traerLista();

$centros = array('1'=>'Abete','2'=>'Pediatrico','3'=>'Materno','4'=>'Cormillot','5'=>'Polo','6'=>'Drozdowsky','7'=>'Otros');
$estados = array('1'=>'En espera','2'=>'En reparacion','3'=>'Reparado','4'=>'Entregado', '5'=> 'Baja');


?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--<title>( ͡° ͜ʖ ͡°)Desu~</title>-->
  <title>(ﾉ◕ヮ◕)ﾉ*Informatica·</title>

    <script src="js/jquery1-12.js" type="text/javascript"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script src="js/jquery.timepicker.min.js" type="text/javascript"></script>
    <script src="js/informatica.js" type="text/javascript"></script>
    <link rel="stylesheet" href="js/jquery-ui.min.css">
    <link rel="stylesheet" href="js/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="js/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="js/jquery.timepicker.css">
    <link rel="stylesheet" href="css/style.css">
<!--    <link rel="Stylesheet" type="text/css" href="/tools/jquery/jqGrid/css/ui.jqgrid.css" />
    <script type="text/javascript" src="/tools/jquery/jqGrid/js/i18n/grid.locale-es.js"></script>
    <script type="text/javascript" src="/tools/jquery/jqGrid/js/jquery.jqGrid.min.js"></script>-->

    <link rel="stylesheet" href="js/jqgrid/css/ui.jqgrid-bootstrap-ui.css">
    <link rel="stylesheet" href="js/jqgrid/css/ui.jqgrid-bootstrap.css">
    <link rel="stylesheet" href="js/jqgrid/css/ui.jqgrid.css">
    <link rel="stylesheet" href="js/jqgrid/plugins/searchFilter.css">
    <script src="js/jqgrid/js/i18n/grid.locale-es.js" type="text/javascript"></script>
    <script src="js/jqgrid/js/jquery.jqGrid.min.js" type="text/javascript"></script>
    <script src="js/jqgrid/plugins/grid.addons.js" type="text/javascript"></script>
    <script src="js/jqgrid/plugins/jquery.searchFilter.js" type="text/javascript"></script>



</head>

<body>
<h1>Soporte Informatica</h1><span id="userCred" class="loginLabel"><?php echo $usuario->getUsuario(); ?> &nbsp; <a href="lgout.php">Logout</a></span>
<hr />
<ul class="menu cf">
  
  <li>
    <a href="">usuarios</a>
    <ul class="submenu">
      <?php if($agregarUsuario){echo '<li><a name="altaUsuario" id="altaUsuario">Agregar usuario</a></li>';} ?>
      <?php if($eliminarUsuario){ echo '<li><a name="bajaUsuario" id="bajaUsuario">Eliminar usuario</a></li>';} ?>
      <li><a name="modiUsuario" id="modiUsuario">Cambiar password</a></li>
   </ul>
  </li>

  <li><a href="#">Lista Reparaciones</a></li>
  
  <li>
    <a href="#">Editar</a>
    <ul class="submenu">
      <li><a name="agregarInsumo" id="agregarInsumo">Agregar Insumo</a></li>
      <li><a name="listaPedidos" id="listaPedidos">Todos los ingresos</a></li>
   </ul>
  </li>
</ul>

<div id="listaReparaciones" name="listaReparaciones">
<form id="formReparaciones" name="formReparaciones">
<table class="tabla">
  <tr><th>Equipo</th><th>Estado</th><th>Fecha Ingreso</th><th>Hora Ingreso</th><th>Centro</th><th>Sector</th><th>Observaciones</th><th>Usuario</th></tr>

  <?php 
  for($i = 0; $i < count($reparaciones); $i++){
    $optionEstado = "<select class='select' id='Reparacion".$reparaciones[$i]['id']."' name='".$reparaciones[$i]['id']."'>";
    for($x = 1; $x <= count($estados) ; $x++ ){
        $selected = '';
        if($reparaciones[$i]['estado'] == $x){
          $selected = " selected='selected' ";
        }
        $optionEstado .= "<option value='".$x."' ".$selected.">".$estados[$x]."</option>";  
    }
    $optionEstado .= "</select>";    

    echo "<tr><td>".$reparaciones[$i]['equipo']."</td><td>".$optionEstado."</td><td>".$reparaciones[$i]['fecha_ingreso'].
        "</td><td>".$reparaciones[$i]['hora_ingreso']."</td><td>".$centros[$reparaciones[$i]['centro']]."</td><td>".$reparaciones[$i]['sector']."<td>".$reparaciones[$i]['observaciones']."
        </td><td>".$reparaciones[$i]['usuario']."
        </td></tr>";
  }
  ?>
</table>
<button class="btnGuardar" id="guardarCambiosEquipos" name="guardarCambiosEquipos">Guardar</button>
</form>
</div>

<div id="dialog-agregarReparacion" name="dialog-agregarReparacion"></div>

<div id="dialog-todasReparaciones" name="dialog-todasReparaciones">
</div>

<div id="dialog-Altausuario" name="dialog-Altausuario">
</div>

<div id="dialog-Bajausuario" name="dialog-Bajausuario">
</div>

<div id="dialog-ModiUsuario" name="dialog-ModiUsuario">
</div>

</body>
</html>