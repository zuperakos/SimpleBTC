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

include(dirname(__FILE__) . "/../includes/requiredFunctions.php");
	
//Check that script is run locally
ScriptIsRunLocally();
////Update share counts

//Update past shares
$sql = "UPDATE webUsers u, ".
	   	"	(SELECT DISTINCT userId, sum(count) AS valid, sum(invalid) AS invalid, id FROM shares_counted GROUP BY userId) s ".
		"SET u.share_count = s.valid, u.stale_share_count = s.invalid WHERE u.id = s.userId";
mysql_query ($sql);

//
////Update current round shares
$sql = "UPDATE webUsers u, ".
	   "	(SELECT IFNULL(count(s.id),0) AS id, p.associatedUserId FROM pool_worker p ".
	   "	LEFT JOIN shares s ON p.username=s.username ".
	   "	WHERE s.our_result='Y' GROUP BY p.associatedUserId) a ". 
	   "SET shares_this_round = a.id WHERE u.id = a.associatedUserId ";
mysql_query($sql);

?>
