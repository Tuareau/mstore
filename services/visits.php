<?php
	session_start();
	$date = date("d.m.Y");
	$file = "visits.txt";
	if (!file_exists($file)) {
		$total_visits = 1;
		$today_visits = 1;
	} 
	else {
		$record = file($file);
		foreach ($record as $str) {
			$arr[] = $str;
		}
		$file_date = (float)$arr[0];
		$today_visits = (int)$arr[1];
		$total_visits = (int)$arr[2];
		$total_visits += 1;
		if ($file_date != $date) {
			$today_visits = 1;
		}
		else {
			$today_visits += 1;
		}
	}	
	$record = $date . "\n" . $today_visits . "\n" . $total_visits;
	$fd = fopen($file, "w+");
	flock($fd, LOCK_EX);
	fwrite($fd, $record);
	flock($fd, LOCK_UN);
	fclose($fd);
	$_SESSION['today_visits'] = $today_visits;
	$_SESSION['total_visits'] = $total_visits;
?>