<?php
	$host = 'localhost';
	$database = 'mstore';
	$username = 'root';
	$password = '';
	$link = mysqli_connect($host, $username, $password, $database);
	if (!$link) {
		die ('Ошибка соединения c MySQL:' . mysql_error());
	}
?>