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
//include ("includes/requiredFunctions.php");
	
$goodMessage = "";
$returnError = "";
$action = "";

//Scince this is the Admin panel we'll make sure the user is logged in and "isAdmin" enabled boolean; If this is not a logged in user that is enabled as admin, redirect to a 404 error page

if(!$cookieValid || $isAdmin != 1) {
	header('Location: /');
	exit;
}

if ( isset( $_POST["action"] ) ) $action = $_POST["action"];

if($action == "news") {
	$title = $_POST["title"];
	$title = sqlesc($title);
	$news = $_POST["news"];
	$news = sqlesc($news);
	$currentTime = time();

	$query="INSERT INTO news (title,message) VALUES ($title,$news)";
	//echo $query;
	mysql_query($query) or sqlerr(__FILE__, __LINE__);
}

$res = mysql_query("SELECT title, message  FROM news WHERE id = 1");
$row = mysql_fetch_array($res);

echo "<h2>Edit news</h2><br/>";
echo "<form action=news.php method=post>";
echo "<input type=hidden name=action value=news>";
echo "Title<br>";
echo "<textarea name=title rows=1 cols=80>" . htmlspecialchars($row["title"]) . "</textarea><br>";
echo "News<br>";
echo "<textarea name=news rows=10 cols=80>" . htmlspecialchars($row["message"]) . "</textarea>";
echo "<br><input type=submit value=Submit>";
echo "</form>";
?>
