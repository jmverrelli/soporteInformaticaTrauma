<?php
include_once 'dbLinker/informaticaDatabaseLinker.class.php';
$infDb = new informaticaDataBaseLinker();
/*if($infDb->tieneAcceso($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))
    {

      header('main.php');
    }
*/

    // Status flag:
$LoginSuccessful = false;
 
// Check username and password:
if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])){
 
    $_SERVER['PHP_AUTH_PW'] = md5($_SERVER['PHP_AUTH_PW']);

    if ($infDb->tieneAcceso($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW'])){
        $LoginSuccessful = true;
    }
}
 
// Login passed successful?
if (!$LoginSuccessful){
 
    /* 
    ** The user gets here if:
    ** 
    ** 1. The user entered incorrect login data (three times)
    **     --> User will see the error message from below
    **
    ** 2. Or the user requested the page for the first time
    **     --> Then the 401 headers apply and the "login box" will
    **         be shown
    */
 
    // The text inside the realm section will be visible for the 
    // user in the login box
    header('WWW-Authenticate: Basic realm="soporteInformaticaTrauma"');
    header('HTTP/1.0 401 Unauthorized');
 
    print "Error de Log In!\n"; //generar un 404
 
}
else {
   header("Location: main.php");
  die();
}