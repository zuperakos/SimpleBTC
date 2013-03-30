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

include ("includes/header.php");
?>

<h1>Welcome to SimpleCoin.us</h1> <br/>

If you are a new user, please create an account. Then click "Getting Started", and follow the instructions on that page.<br/><br/>

<?php echo $config['site']['poolname'] ?> is run completely by opensource software. Even this website is opensource!<br/><br/>

We currently have a fee of <?php echo antiXss($settings->getsetting("sitepercent"))?>%, 
a transaction fee of <?php echo antiXss($settings->getsetting("sitetxfee"))?> BTC per transaction and use 
<?php 
if ($settings->getsetting("siterewardtype") == 0) echo "Last N Shares (1/2 Difficulty)";
else if ($settings->getsetting("siterewardtype") == 2) echo "Max Pay per share";
else echo "proportional"; 
?>
 round scoring to ensure payout of your hard work.<br/><br/>

If you have any issues, please note them in the forum.<br/><br/>

Thank you!<br/>


<?php include ("includes/footer.php"); ?>


