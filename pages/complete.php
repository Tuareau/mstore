<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Покупка</title>
</head>

<?php
session_start();
include "../services/connect.php";
?>

<body>

	<div id="page">

		<div id="header">
			<table id="menu">
				<tr>
					<td class="htd"><a id="headera" href="../index.php">Главная</a></td>
					<td class="htd"><a id="headera" href="catalog.php">Каталог</a></td>
					<td class="htd"><a id="headera" href="contacts.php">Контакты</a></td>
					<td class="htd"></td>
					<?php if (!isset($_SESSION['user_id'])) { ?>
						<td class="htd"><a id="headera" href="login.php">Вход</a></td>
					<?php } else { ?>
						<td class="htd"><a id="headera" href="cart.php">Корзина</a></td>
						<td class="htd"><a id="headera" href="account.php">Аккаунт</a></td>
					<?php } ?>
				</tr>
			</table>
			<br>
		</div>

		<div id="main">
			<br>
			<h3>Спасибо за покупку!</h3>

			<p><b>Ждем вас снова</b></p><br><br>

			<?php
			unset($_SESSION['products']);
			?>
			<div id="end">
			<p><a id="a-big-white" href=" catalog.php">Продолжить покупки</a></p><br>
			<br><br>
			<p><a id="a-big-black" href="../services/logout.php">Выйти из учетной записи</a></p>
			</div>
		</div>
	</div>

</body>

</html>