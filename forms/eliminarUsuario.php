<?php
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();
session_start(); 

$response = $infDb->eliminarUsuario($_POST);

echo json_encode($response);
