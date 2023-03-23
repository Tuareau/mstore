<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>mstore: Главная</title>
</head>

<?php
session_start();
include "services/connect.php";
include "services/visits.php";
?>

<body>

	<div id="page">

		<div id="header">
			<table id="menu">
				<tr>
					<td class="htd"><a id="headera" href="index.php">Главная</a></td>
					<td class="htd"><a id="headera" href="pages/catalog.php">Каталог</a></td>
					<td class="htd"><a id="headera" href="pages/contacts.php">Контакты</a></td>
					<td class="htd"></td>
					<?php if (!isset($_SESSION['user_id'])) { ?>
						<td class="htd"><a id="headera" href="pages/login.php">Вход</a></td>
					<?php } else { ?>
						<td class="htd"><a id="headera" href="pages/cart.php">Корзина</a></td>
						<td class="htd"><a id="headera" href="pages/account.php">Аккаунт</a></td>
					<?php } ?>
				</tr>
			</table>
			<br>
		</div>

		<h1 id="title"><i>mstore</i></h1>

		<div id="main">
			<table>
				<tr>
					<td class="maintd">
						<img width="435" height="250" src="images/index.png">
					</td>
					<td class="maintd">
						<p><i>mstore</i> — широкий выбор музыкальных инструментов известных брендов</p>
						<p>доставляем оригинальные товары в любую точку страны в кратчайшие сроки, <br>гарантируя наилучший сервис и постоянную поддержку</p>
					</td>
				</tr>
			</table>
		</div>

		<div id="footer">
			<br>
			<table id="footer-table">
				<tr>
					<td colspan="4">Посещаемость</td>
				</tr>
				<tr>
					<td width="15">Всего:</td>
					<td width="15"><?php echo $_SESSION['total_visits'] ?></td>
				</tr>
				<tr>
					<td width="15">Сегодня:</td>
					<td width="15"><?php echo $_SESSION['today_visits'] ?></td>
				</tr>
			</table>
		</div>

	</div>

</body>

</html>