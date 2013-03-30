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
include(dirname(__FILE__) . "/../includes/requiredFunctions.php");

//Include Reward class
include($config['paths']['include'].'reward.php');
$reward = new Reward();

//Check that script is run locally
ScriptIsRunLocally();

lock("shares");

	//Include Block class
	include($config['paths']['include']."block.php");
	$block = new Block();
	
	//Get current block number
	$currentBlockNumber = $bitcoinController->getblocknumber();
	$lastBlockNumber = $currentBlockNumber - 1;
	
	//Get latest block in database
	$latestDbBlock = $block->getLatestDbBlockNumber();
	
	//Do block work if new block 
	if ($latestDbBlock < $lastBlockNumber) {		
		//Insert last block number into networkBlocks
		include($config['paths']['include']."stats.php");
		$stats = new Stats();
		$lastwinningid = $stats->lastWinningShareId();
		$block->InsertNetworkBlocks($lastBlockNumber, $lastwinningid);
		
		//Find new generations
		$block->FindNewGenerations($bitcoinController);
		
		//Update confirms on unrewarded winning blocks
		$block->UpdateConfirms($bitcoinController);		
	}
unlock("shares");
	
	//Check for unscored blocks() 
	if ($block->CheckUnscoredBlocks()) {
		lock("money");
		try {
			//Get Difficulty
			$difficulty = $bitcoinDifficulty;
			if(!$difficulty)
			{
			   echo "no difficulty! exiting\n";
			   exit;
			}
			
			//Reward by selected type;
			if ($settings->getsetting("siterewardtype") == 0) {
				//LastNShares
				$reward->LastNShares($difficulty, $config['bonusCoins']);
			//} else if ($settings->getsetting("siterewardtype") == 2) {
				////MaxPPS
				//MaxPPS();
			} else {
				//Proportional Scoring
				$reward->ProportionalScoring($config['bonusCoins']);
			}
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		unlock("money");
	}
		
	
	//Check for unrewarded blocks
	if ($block->CheckUnrewardedBlocks()) {			
		lock("money");	
		try {
			$reward->MoveUnrewardedToBalance();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
		unlock("money");
	}


?>
