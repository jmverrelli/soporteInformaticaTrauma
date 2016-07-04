<?php
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();
$ret = new stdClass();
$ret->ret = false;
$ret->message = "Hubo un error al actualizar el registro.";

if($_POST['oper'] == 'edit'){

$ret = $infDb->actualizarRegistroStock($_POST);

}

echo $ret->message;
