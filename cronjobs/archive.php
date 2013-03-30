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
 
//Set page starter variables//
//Include hashing functions
include(dirname(__FILE__) . "/../includes/requiredFunctions.php");

//Check that script is run locally
ScriptIsRunLocally();

//Include Block class
include($config['paths']['include']."block.php");
$block = new Block();

$siterewardtype = $settings->getsetting("siterewardtype");

if ($block->NeedsArchiving($siterewardtype, $bitcoinDifficulty))
	$block->Archive($siterewardtype, $bitcoinDifficulty);

?>
