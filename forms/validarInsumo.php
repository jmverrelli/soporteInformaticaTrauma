<?php 
session_start();
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();

$response = $infDb->agregarInsumo($_POST);

echo json_encode($response);
