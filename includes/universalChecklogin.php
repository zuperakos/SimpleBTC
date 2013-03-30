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

$donatePercent = 0;

//Check if the cookie is set, if so check if the cookie is valid
if(isSet($_COOKIE[$config['cookie']['Name']])){
	$cookieValid = false;
	$ip = $_SERVER['REMOTE_ADDR']; //Get Ip address for cookie validation
	$validateCookie	= new checkLogin();
	$cookieValid = $validateCookie->checkCookie(mysql_real_escape_string($_COOKIE[$config['cookie']['Name']]), $ip);
	$userId	= $validateCookie->returnUserId($_COOKIE[$config['cookie']['Name']]);	
	
	//ensure userId is numeric to prevent sql injection attack
	if (!is_numeric($userId)) {
		$userId = 0;	
		exit;
	}	

	//Get user information
	$query="SELECT id, username, email, pin, pass, admin, api_key, IFNULL(donate_percent, '0') as donate_percent, btc_lock FROM webUsers WHERE id = $userId LIMIT 0,1";
	//echo $query;
	$userInfoQ = mysql_query($query); 	
	if ($userInfo = mysql_fetch_object($userInfoQ)) {
		$authPin = $userInfo->pin;
		$hashedPass = $userInfo->pass;
		$isAdmin = $userInfo->admin;						
		$currentUserHashrate = $stats->userhashrate($userInfo->username);
		$userApiKey = $userInfo->api_key;
		$donatePercent = $userInfo->donate_percent;		
		$userEmail = $userInfo->email;
		$userBtcLock = $userInfo->btc_lock;

		$totalUserShares = $stats->usersharecount($userId);		
		
		//Get current round share information, estimated total earnings
		$totalOverallShares = $stats->currentshares();	
			
		//Calculate Estimate
		$userRoundEstimate = 0;
		if($totalUserShares > 0 && $totalOverallShares > 0) {
			//Get site percentage
			$sitePercent = 0;
			if (is_numeric($settings->getsetting("sitepercent")))
				$sitePercent = $settings->getsetting("sitepercent")/100;
			
			if ($totalOverallShares > $bitcoinDifficulty)
				$estimatedTotalEarnings = $totalUserShares/$totalOverallShares;
			else
				$estimatedTotalEarnings = $totalUserShares/$bitcoinDifficulty;
			$estimatedTotalEarnings *= $config['bonusCoins']*(1-$sitePercent); //The expected BTC to be givin out
			$userRoundEstimate = round($estimatedTotalEarnings, 8);
		} 				
				
		//Get Current balance				    
		$currentBalanceQ = mysql_query("SELECT balance, IFNULL(sendAddress,'') as sendAddress, threshold FROM accountBalance WHERE userId = '$userId' LIMIT 0,1");
		if ($currentBalanceObj = mysql_fetch_object($currentBalanceQ)) {
			$currentBalance = $currentBalanceObj->balance;
			//Get payment address that is associated wit this user
			$paymentAddress = $currentBalanceObj->sendAddress;		
			$payoutThreshold = $currentBalanceObj->threshold;	
		} else {
			$currentBalance = 0;
			$paymentAddress = "";
			$payoutThreshold = 0;
		}
	}

}
?>
