<?php
/*
Copyright (C) 2013 Jesse B. Crawford

This file is part of SimpleBTC.

    SimpleBTC is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    SimpleBTC is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

SimpleBTC (overhaul) Developer: 16LJ4z5BzZpDTzXBL2n34o8Me6WAM2RhLd
SimpleCoin (unmaintained original) Developer: 1Fc2ScswXAHPUgj3qzmbRmwWJSLL2yv8Q
*/


//This page will attempt to take informtion from the user and create an encrypted session inside of a cookie

//Include site functions
include("includes/requiredFunctions.php");
		
//Filter input results before querying them into database
$user = mysql_real_escape_string($_POST["username"]);
$pass = mysql_real_escape_string($_POST["password"]);

//Check the supplied username & password with the saved username & password
$checkPassQ = mysql_query("SELECT id, secret, pass, accountLocked, accountFailedAttempts FROM webUsers WHERE username = '".$user."' LIMIT 0,1");
$checkPass = mysql_fetch_object($checkPassQ);
if ( $checkPass ) $userExists = $checkPass->id;

if ( $checkPass ) if($checkPass->accountFailedAttempts >= 5){
	echo "Account has been banned";
	die();
}


//Check if user exists before checking login data
if ( isset( $userExists ) )
if($userExists > 0){
	//Check to see if this user has an `accountLocked`
	if($checkPass->accountLocked < time()){
		//Check to see if this user has attempted to login more then the maximum allowed failed attempts
		if($checkPass->accountFailedAttempts < 5){
			$dbHash = $checkPass->pass;
			$inputHash = hash("sha256", $pass.$config['salt']);
			//Do Check
			if($dbHash == $inputHash){
				//Give out the secrect SHHH!! be quite too!
				//Get ip address so we can hash with the cookie so no one can steal the password
				$ip = $_SERVER['REMOTE_ADDR'];
				$timeoutStamp = time()+60*60*24*7; //1 week session
				//Update logged in ip address so no one can steal this cookie hash unless
				mysql_query("UPDATE `webUsers` SET `sessionTimeoutStamp` = ".$timeoutStamp.", `loggedIp` = '".$ip."' WHERE `id` = ".$userExists);
			
				//Set cookie in browser for session
				$hash		= $checkPass->secret.$dbHash.$ip.$timeoutStamp;
				$cookieHash = hash("sha256", $hash.$config['salt']);
				setcookie($config['cookie']['Name'], $checkPass->id."-".$cookieHash, $timeoutStamp, $config['cookie']['Path'], $config['cookie']['Domain']);
				$cookieValid = true;
			
				//Display output message
				$outputMessage = "Welcome back, we'll be returning to the main page shortly";	
				mysql_query("UPDATE webUsers SET accountFailedAttempts = 0 WHERE id = $userExists");
			}else{
				$outputMessage =  "Wrong username or password.";
				$lock = $checkPass->accountFailedAttempts + 1;
				mysql_query("UPDATE webUsers SET accountFailedAttempts = $lock WHERE id = $userExists");
			}
		}
	}
}else{
	$outputMessage = "User name dosent exist!";
}
if ( !isset( $outputMessage ) ) $outputMessage = "User name dosent exist!";
?>
<html>
  <head>
	<title><?php echo antiXss(outputPageTitle());?> </title>
	<link rel="stylesheet" href="css/mainstyle.css" type="text/css" />
	<meta http-equiv="refresh" content="2;url=index.php">
  </head>
  <body>
	<div id="pagecontent">
		<h1><?php echo antiXss($outputMessage); ?><br/>
		<a href="index.php">Click here if you continue to see this message</a></h1>
	</div>
  </body>
</html>

