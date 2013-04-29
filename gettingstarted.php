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

$pageTitle = "- Getting Started";
include ("includes/config.php");
include ("includes/header.php");
	
?>

<b><u>Get a Bitcoin Address</u></b><br/>
Download the client to your PC from: <a href="http://www.bitcoin.org//" target="_blank"  style="color: blue">bitcoin.org</a><br/><br/>

<b><u>Setup a bitcoin miner</u></b><br/><br/>

<b><u>ATI/AMD Users</u></b><br/>
You will need to download and install the AMD Stream SDK from  <a href="http://developer.amd.com/SDKS/AMDAPPSDK/DOWNLOADS/Pages/default.aspx" target="_blank" style="color: blue">HERE</a> before you can begin mining<br/><br/> 

<b><u>Advanced Windows & Linux (for best mining results)</u></b><br/>
	Download cgminer <a href="https://bitcointalk.org/index.php?topic=28402.0" target="_blank">HERE</a><br/>
	Follow the directions for your operating system in the above link to install<br/>
	Run cgminer: cgminer -o http://<?php echo $config['site']['poolname'] ?>:<?php echo $config['site']['poolport']  ?> -u username.1 -p x<br/>
	Run cgminer for max performance: cgminer -o http://<?php echo $config['site']['poolname'] ?>:<?php echo $config['site']['poolport'] ?> -u username.1 -p x -I 8<br/><br/>

	<b><u>Easy Windows</u></b><br/>	
	Download GUIMiner: <a href="https://forum.bitcoin.org/index.php?topic=3878.0" target="_blank">HERE</a><br>
	<img src="images/guiminer.jpg"><br/>
	<u>GUIMiner options</u><br/>
	Server: Other<br />
	Host: <?php echo $config['site']['poolname'] ?><br />
	Port: <?php echo $config['site']['poolport'] ?><br />
	Username: &lt;your user name&gt;.&lt;miner name (default is 1)&gt;<br/>
	Password: &lt;your miner password (default is 'x')&gt;<br/>
	Device: Select the graphics card/cpu you would like to use<br/>
	Extra Flags: Can be blank, but I find "-v -w128 -f 60" to work well<br/><br/>
	
	<b><u>Easy Linux</u></b><br/>
	Download hashkill: <a href="https://forum.bitcoin.org/index.php?topic=6819.0" target="_blank">HERE</a><br/>
	Decompress (tar zxvf hashkill-0.2.4-x86.tar.gz)<br/>
	Change directory to hashkill<br/>
	Run: sudo ./install.sh<br/>
	Run hashkill: hashkill-gpu -p bitcoin minername:password:<?php echo $config['site']['poolname'] ?>:<?php echo $config['site']['poolport'] ?>
	
	
<?php include("includes/footer.php"); ?>

