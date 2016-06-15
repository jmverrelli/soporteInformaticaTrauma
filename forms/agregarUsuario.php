<?php
session_start();
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();

$response = $infDb->agregarUsuario($_POST);

echo json_encode($response);
