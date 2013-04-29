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

$pageTitle = "- Register";
include ("includes/header.php");

/*
Copyright (C)  41a240b48fb7c10c68ae4820ac54c0f32a214056bfcfe1c2e7ab4d3fb53187a0 Name Year (sha256)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Website Reference:http://www.gnu.org/licenses/gpl-2.0.html

Note From Author: Please donate at the following address: 1Fc2ScswXAHPUgj3qzmbRmwWJSLL2yv8Q
*/

//Test registration information
$returnError = "";
$goodMessage = "";
if (isset($_POST["act"]))
	{
	$act = $_POST["act"];
	if($act == "attemptRegister"){
		//Valid date all fields
		$username	= mysql_real_escape_string($_POST["user"]);
		$pass		= mysql_real_escape_string($_POST["pass"]);
		$rPass		= mysql_real_escape_string($_POST["pass2"]);
		$email		= mysql_real_escape_string($_POST["email"]);
		$email2		= mysql_real_escape_string($_POST["email2"]);
		$authPin	= mysql_real_escape_string($_POST["authPin"]);
	
		$validRegister = 1;
			//Validate username
			if (!preg_match('/^[a-z\d_]{4,20}$/i', $username)) {
				$validRegister = 0;
			   	$returnError .= "Wrong username format.";
			}
			
			//Validate passwords
			if($pass != $rPass){
				if(strlen($pass) < 5){
					$validRegister = 0;
					$returnError .= " | Password is too short";
				}else{
					$validRegister = 0;
					$returnError .= " | Passwords do not match";
				}
			}
			
			//Email Validation
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$validRegister = 0;
			    	$returnError .= " | Wrong email address format.";
			}else{
				//Validate that emails match
				if($email != $email2){
					$validRegister = 0;
					$returnError .= " | Emails didn't match!";
				}
			}
			
			//validate authpin
			if(strlen($authPin) >= 4){
				if(!is_numeric($authPin)){
					$validRegister = 0;
					$returnError .= " | Not a valid authpin";
				}
			}else{
				$validRegister = 0;
				$returnError .= " | Authorization pin number is not valid";
			}
	
		if($validRegister){
			//Add user to webUsers
			$emailAuthPin = genRandomString(10);
			$secret = genRandomString(10);
			$apikey = hash("sha256",$username.$config['salt']);
			//Check to see if user exists already
			$testUserQ = mysql_query("SELECT id FROM webUsers WHERE username = '".$username."' LIMIT 1");
			//If not, create new user
			if (!$testUserQ || mysql_num_rows($testUserQ) == 0) {			
				$result = mysql_query("INSERT INTO webUsers (admin, username, pass, email, emailAuthPin, secret, loggedIp, sessionTimeoutStamp, accountLocked, accountFailedAttempts, pin, api_key) 
										VALUES (0, '$username', '".hash("sha256", $pass.$config['salt'])."', '$email', '$emailAuthPin', '$secret', '0', '0', '0', '0', '".hash("sha256", $authPin.$config['salt'])."','$apikey')");
				$returnId = mysql_insert_id();
				mysql_query("INSERT INTO accountBalance (userId, balance) VALUES ($returnId,'0')");
				mysql_query("INSERT INTO pool_worker (associatedUserId, username, password) VALUES ($returnId,'".$username.".1','x')");
				$goodMessage = "Your account has been successfully created. Please login to continue.";
			} else {
				$returnError = "Account already exists. Please choose a different username.";
			}
		}		
	}
}

//Display Error and Good Messages(If Any)
echo "<span class=\"goodMessage\">".antiXss($goodMessage)."</span><br/>";
echo "<span class=\"returnMessage\">".antiXss($returnError)."</span>";

?>
<form action="register.php" method="post">
	<h2>Join our pool</h2>						
	<input type="hidden" name="act" value="attemptRegister">
	<table border="0">
	<tr><td>Username:</td><td><input type="text" name="user" value="" size="15" maxlength="20"></td></tr>
	<tr><td>Password:</td><td><input type="password" name="pass" value="" size="15" maxlength="20"></td></tr>
	<tr><td>Repeat Password:</td><td><input type="password" name="pass2" value="" size="15" maxlength="20"></td></tr>
	<tr><td>Email:</td><td><input type="text" name="email" value="" size="15"></td></tr>
	<tr><td>Email Repeat:</td><td><input type="text" name="email2" value="" size="15"></td></tr>
	<tr><td>PIN:</td><td><input type="password" name="authPin" value="" size="4" maxlength="4"> (4 digit number "<b>Remember this pin</b>")</td></tr>
	</table>
	<input type="submit" value="Attempt Register">
</form>
<?php include("includes/footer.php"); ?>
