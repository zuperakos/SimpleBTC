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

//Include site functions
include("includes/requiredFunctions.php");

setcookie($config['cookie']['Name'], 0, $timeoutStamp, $config['cookie']['Path'], $config['cookie']['Domain']);
?>
<html>
  <head>
	<title><?php echo antiXss(outputPageTitle());?> </title>
	<link rel="stylesheet" href="/css/mainstyle.css" type="text/css" />
	<meta http-equiv="refresh" content="2;url=/">
  </head>
  <body>
	<div id="pagecontent">
		<h1>You have been logged out<br/>
		<a href="/">Click here if you continue to see this message</a></h1>
	</div>
  </body>
</html>
