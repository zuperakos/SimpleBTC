<?php 
//Set page starter variables//
//Include site functions
include(dirname(__FILE__) . "/include/requiredFunctions.php");

//Open a bitcoind connection
$transactions = $bitcoinController->query("listtransactions");
echo print_r($transactions);
?>
