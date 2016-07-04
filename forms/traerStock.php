<?php
include_once '../dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();

$arr= array();

if(isset($_REQUEST["_search"])){

if($_REQUEST["_search"] == "true")
{
	$arr = json_decode($_REQUEST['filters'], true);
}
}

$ret = $infDb->getStockJson($_REQUEST['page'], $_REQUEST['rows'], $arr, $_REQUEST['sidx'], $_REQUEST['sord']);
	

echo $ret;
