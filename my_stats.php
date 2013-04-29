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


//    Improved Stats written by Tom Lightspeed (tomlightspeed@gmail.com + http://facebook.com/tomlightspeed)
//    Developed Socially for http://ozco.in
//    If you liked my work, want changes/etc please contact me or donate 16p56JHwLna29dFhTRcTAurj4Zc2eScxTD.
//    Special thanks to WAYNO, GRAET & YCROS from #ozcoin on freenode.net for their help :-)
//    May the force be with you.

$pageTitle = "- My Stats";
include ("includes/header.php");

//DEBUG
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

echo "<div id=\"stats_wrap\">";

if( !$cookieValid ){
	echo "<div id='new_user_message'><p>Welcome to <a href=''>".$config['site']['poolname']."</a>! Please login or <a href='register.php'>join us</a> to get detailed stats and graphs relating to your hashing!</p></div>";
}
else
{
	// SHOW USER TOTAL PAID  *************************************************************************************************************************

	echo "<table class=\"money_table server_width\">";
	echo "<tr><th scope=\"col\" colspan=\"2\">Total BTC Earned</th></tr><tr class=\"moneyheader\"><td class=\"bitcoin_image\"><img class=\"earned_coin\" src=\"images/bitcoin.png\" /></td><td class=\"bitcoins\">";

	$result = mysql_query_cache("SELECT paid + balance as amount_earned  FROM accountBalance WHERE userid = $userInfo->id");
	if ($resultrow = $result[0]) {
		echo $resultrow->amount_earned;
	}

	echo "</td></tr></table>";

	// USER HASHRATE LAST HOUR/TIME GRAPH *************************************************************************************************************************
	// http://www.filamentgroup.com/lab/update_to_jquery_visualize_accessible_charts_with_html5_from_designing_with/
	// table is hidden, graph follows

//	echo "<table id=\"user_hashrate_lasthour\" class=\"hide\">";
//	echo "<caption>" . $userInfo->username . "'s Hashrate over the Last Hour</caption>";
//	echo "<thead><tr><td></td>";
//
//	$query = "SELECT DISTINCT DATE_FORMAT(timestamp, '%h:%i') as time, hashrate FROM userHashrates WHERE timestamp > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 HOUR) AND userId = $userInfo->id";
//	$result = mysql_query($query);
//
//	while($resultrow = mysql_fetch_object($result)) {
//		echo "<th scope=\"col\">" . $resultrow->time . "</th>";
//	}
//
//	echo "</thead><tbody><tr><th scope=\"row\">" . $userInfo->username . "'s Hashrate</th>";
//
//	// re-iterate through results
//	if (mysql_num_rows($result) > 0)
//		mysql_data_seek($result, 0);
//
//	while($resultrow = mysql_fetch_object($result)) {
//		echo "<td>" . $resultrow->hashrate . "</td>";
//	}
//
//	echo "</tbody></table>";

	//echo "</div><div class=\"clear\"></div><div id=\"stats_wrap_3\" class=\"top_spacing\">";

	// USER HASHRATE LAST 24 HOURS/TIME GRAPH *************************************************************************************************************************
	// http://www.filamentgroup.com/lab/update_to_jquery_visualize_accessible_charts_with_html5_from_designing_with/
	// table is hidden, graph follows

	echo "\n<br /><table id=\"user_hashrate_last24\" class=\"hide\">";
	echo "<caption>" . $userInfo->username . "'s Hashrate over the Last 24 Hours</caption>";
	echo "<thead><tr><td></td>";

	$query = "SELECT DATE_FORMAT(timestamp, '%l:%i') as time, hashrate FROM userHashrates WHERE timestamp > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 24 HOUR) AND userId = $userInfo->id";
	$query .= " GROUP BY EXTRACT(DAY FROM timestamp), EXTRACT(HOUR FROM timestamp)";

	$result = mysql_query_cache($query);
	
	foreach ($result as $resultrow) {
		echo "<th scope=\"col\">" . $resultrow->time . "</th>";
	}

	echo "</thead><tbody><tr><th scope=\"row\">".$userInfo->username."'s Hashrate</th>";

	// re-iterate through results
	//if (mysql_num_rows($result) > 0)
	//	mysql_data_seek($result, 0);

	foreach ($result as $resultrow) {
		echo "<td>".$resultrow->hashrate."</td>";
	}

	echo "</tbody></table><br />\n";

	//echo "</div><div class=\"clear\"></div><div id=\"stats_wrap_4\" class=\"top_spacing\">";

	// USER HASHRATE OVER LAST MONTH GRAPH *************************************************************************************************************************
	// http://www.filamentgroup.com/lab/update_to_jquery_visualize_accessible_charts_with_html5_from_designing_with/
	// table is hidden, graph follows

	echo "<table id=\"user_hashrate_lastmonth\" class=\"hide\">";
	echo "<caption>" . $userInfo->username . "'s Hashrate over the Last Month</caption>";
	echo "<thead><tr><td></td>";

	$query = "SELECT DATE_FORMAT(timestamp, '%b %e') as day, hashrate FROM userHashrates WHERE timestamp > DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 MONTH) AND userId = " . $userInfo->id;
	$query .= " GROUP BY EXTRACT(MONTH FROM timestamp), EXTRACT(DAY FROM timestamp)";

	$result = mysql_query_cache($query);

	foreach ($result as $resultrow) {
		echo "<th scope=\"col\">" . $resultrow->day . "</th>";
	}

	echo "</thead><tbody><tr><th scope=\"row\">" . $userInfo->username . "'s Hashrate</th>";

	// re-iterate through results
	//if (mysql_num_rows($result) > 0)
	//	mysql_data_seek($result, 0);

	foreach ($result as $resultrow) {
		echo "<td>" . $resultrow->hashrate . "</td>";
	}

	echo "</tbody></table><br />\n";

	//echo "</div><div class=\"clear\"></div><div id=\"stats_wrap_5\" class=\"top_spacing\">";
}

echo "<div class=\'clear'></div></div><br />\n";

include("includes/footer.php");

?>
