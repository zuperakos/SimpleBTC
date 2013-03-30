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

$pageTitle = "Password Recovery";
include ("includes/header.php");

$returnError = "";
$goodMessage = "";

if (isset($_POST["act"])) {
	$act = $_POST["act"];
	//Send reset mail	
	if ($act == "reset") {
		$resetUsername = mysql_real_escape_string($_POST["pwrUsername"]);					
		$result = mysql_query("SELECT email, emailAuthPin FROM webUsers WHERE username='$resetUsername'");
		if ($row = mysql_fetch_row($result)) {
			$email = $row[0];
			mail("$email", $config['site']['poolname']." Password Reset Notification","Hello,\n\nTo complete your password reset, please click the following link or copy and paste it into your browser url location:\nhttps://".$config['site']['poolname']."/lostpassword.php?username=".$resetUsername."&auth=".$row[1]."\n\nIf you have received this message in error or did not request a reset, please ignore this message and your account will remain unchanged.", "From: ".$config['site']['poolname']." Notifications <".$config['site']['mailfrom'].">");
			$goodMessage = "Your password reset information has been sent to ".$email;
		} else {
			$returnError = "We were unable to locate your records, please contact the site admin for further assistance.";
		}
	} else if ($act == "resetpass") {
		$validRegister = true;
		$resetUsername = mysql_real_escape_string($_POST["pwrUsername"]);	
		$resetAuth = mysql_real_escape_string($_POST["auth"]);
		$pass = mysql_real_escape_string($_POST["pass"]);
		$rPass = mysql_real_escape_string($_POST["pass2"]);
		if($pass != $rPass) {
			if (strlen($pass) < 5) {
				$validRegister = false;
				$returnError .= " | Password is too short";
			} else {
				$validRegister = false;
				$returnError .= " | Passwords do not match";
			}
		}
		if ($validRegister = 1) {
			$result = mysql_query("UPDATE webUsers SET pass='".hash("sha256", $pass)."', accountFailedAttempts = 0 WHERE  username='$resetUsername' AND emailAuthPin='$resetAuth' ");
			if ($result) {
				$goodMessage ="Password reset Successful. Please login using your new credentials.";
			} else {
				$returnError .= "We were unable to locate your records, please contact the site admin for further assistance.";
			}
		}
		
			
	}
}

//Handle incoming auth request
$returningAuth = false;
$resetUsername = "";
if (isset($_GET["auth"]) && isset($_GET["username"])) {	
	$resetUsername = mysql_real_escape_string($_GET["username"]);
	$resetAuth = mysql_real_escape_string($_GET["auth"]);
	$result = mysql_query("SELECT id FROM webUsers WHERE username='$resetUsername' AND emailAuthPin='$resetAuth'");
	if ($row = mysql_fetch_object($result) && mysql_numrows($result) > 0) {
		$returningAuth = true;			
	} else {
		$returnError = "We were unable to locate your records, please contact the site admin for further assistance.";
	}
}

//Display Error and Good Messages(If Any)
echo "<span class=\"goodMessage\">".$goodMessage."</span><br/>";
echo "<span class=\"returnMessage\">".$returnError."</span>";

if (!$returningAuth ) {
?>

<h1>Password Recovery</h1> <br/>
<form action="/lostpassword.php" method="post" name="resetForm">
<input type="hidden" name="act" value="reset"/>
Username: <input type="text" name="pwrUsername"><br/>
<input type="submit" name="pwrSubmit" value="Send Recovery Email" >
</form>

<?php } else { ?>
	<h1>Password Recovery</h1> <br/>
	<form action="/lostpassword.php" method="post" name="resetForm">
	<input type="hidden" name="act" value="resetpass"/>
	<input type="hidden" name="auth" value="<?php echo antiXss($_GET["auth"]); ?>"/>
	<input type="hidden" name="pwrUsername" value="<?php echo antiXss($_GET["username"]); ?>"/>
	New Password: <input type="password" name="pass" value="" size="15" maxlength="20"><br/>
	Repeat Password: <input type="password" name="pass2" value="" size="15" maxlength="20"><br/>

	<input type="submit" name="pwrSubmit" value="Reset Password" >
</form>
<?php } ?>
<?php include ("includes/footer.php"); ?>
