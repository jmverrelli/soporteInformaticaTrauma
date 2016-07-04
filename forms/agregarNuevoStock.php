<?php
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();

$response = $infDb->agregarNuevoStock($_POST);

echo json_encode($response);
