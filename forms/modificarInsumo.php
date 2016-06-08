<?php

include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();

$response = $infDb->modificarInsumo($_POST);

echo json_encode($response);
