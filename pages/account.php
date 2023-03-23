<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Аккаунт</title>
</head>

<?php
session_start();
include "../services/connect.php";
if (isset($_SESSION['user'])) {
	$consumer = $_SESSION['user'];
}
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
			<h3>Персональная информация</h3>
			<form action="" method="post">
				<table align=center>
					<tr>
						<td>Имя:</td>
						<td><input type="text" name="name" value="<?= isset($_SESSION['user']) ? $consumer['name'] : ''; ?>"></td>
					</tr>
					<tr>
						<td>Адрес:</td>
						<td><input type="text" name="address" value="<?= isset($_SESSION['user']) ? $consumer['address'] : ''; ?>"></td>
					</tr>
					<tr>
						<td>Телефон:</td>
						<td><input type="text" name="phone" value="<?= isset($_SESSION['user']) ? $consumer['phone'] : ''; ?>"></td>
					</tr>
					<tr>
						<td>Город:</td>
						<td><input type="text" name="city" value="<?= isset($_SESSION['user']) ? $consumer['city'] : ''; ?>"></td>
					</tr>
				</table>
				<br>
				<input id="submit" type="submit" name="save" value="Сохранить">
				<br>
			</form>

			<?php
			if (isset($_POST['save'])) {
				$username = trim($_POST['name']);
				$address = trim($_POST['address']);
				$phone = trim($_POST['phone']);
				$city = trim($_POST['city']);
				$query = mysqli_query(
					$link,
					"UPDATE consumers SET 
				name = '{$_POST['name']}',
				address = '{$_POST['address']}', 
				phone = '{$_POST['phone']}', 
				city = '{$_POST['city']}' 
				WHERE consumer_key = " . $_SESSION['user_id']
				);
				if (!$query) {
					echo '<p>Ошибка в обновлении некорректных данных</p>';
				} else {
					echo '<p>Данные успешно изменены</p>';
					$_SESSION['user']['name'] = trim($_POST['name']);
					$_SESSION['user']['address'] = trim($_POST['address']);
					$_SESSION['user']['phone'] = trim($_POST['phone']);
					$_SESSION['user']['city'] = trim($_POST['city']);
					$consumer = $_SESSION['user'];
				}
			}
			?>

			<h3>История заказов</h3>

			<?php
			$orders = mysqli_query($link, "SELECT * FROM orders 
			WHERE orders.consumer_key = {$_SESSION['user_id']}");
			$rowcount = mysqli_num_rows($orders);
			if ($rowcount <= 0) {
				echo '<p>Заказов пока нет</p>';
			} else {
				echo '<div id="orders-list">';
				$number = 1;
				while ($order = mysqli_fetch_array($orders)) {
					echo '<div id="order">';
					echo '<div id="number">' . $number . '</div>';
					$order_key = $order['order_key'];
					$sales = mysqli_query($link, "SELECT * FROM sales 
					WHERE order_key = " . $order_key);
					$sale = mysqli_fetch_array($sales);
					$date = date("d.m.Y", strtotime($sale['date']));
					echo '<div id="sale"><p>' . $date . '</p></div>';
					$number++;

					echo '<div id="units">';
					$units = mysqli_query($link, "SELECT * FROM units INNER JOIN
					products ON units.product_key = products.product_key
					WHERE units.order_key = " . $order_key);

					echo '
					<table align=center border-style="1px solid black" width="300">
					<tr>
						<th>Товар</th>
						<th>Производитель</th>
						<th>Цена</th>
					</tr>';
					$sum = 0;
					while ($unit = mysqli_fetch_array($units)) {
						$sum += $unit['price'];
						echo "
						<tr>
							<td>{$unit['name']}</td>
							<td>{$unit['producer']}</td>
							<td>{$unit['price']}</td>
						</tr>";
					}
					echo '</table>';
					echo '<p>' . $sum . ' Р</p>';
					echo '</div></div><br>';
				}
				echo '</div>';
			}
			?>

			<br>
			<a id="abuy" href="../services/logout.php">Выйти</a>
			<br>
			<br>
			<br>

		</div>

	</div>

</body>

</html>