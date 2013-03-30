<?php
//Set page starter variables//
include(dirname(__FILE__) . "/../includes/requiredFunctions.php");

//Check that script is run locally
ScriptIsRunLocally();

$bitcoinController->backupwallet($config['paths']['backupwallet'] . ".".date("Ymd"));
?>
