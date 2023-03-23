<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Оформление покупки</title>
</head>

<?php
session_start();
include "../services/connect.php";
if (!isset($_SESSION['user_id'])) {
	echo '<p>Пожалуйста, <a href="login.php">войдите</a> или
					<a href="register.php">зарегистрируйтесь</a>, чтобы совершать покупки</p>';
} else if (empty($_SESSION['products'])) {
	echo '<p><i>Заказ пуст</i></p>';
	header("location: catalog.php");
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

			<h3>Оформление покупки</h3>

			<p><b>Укажите дату и способ получения покупки</b></p>

			<?php
			$records = mysqli_query($link, "SELECT * FROM employees 
				INNER JOIN posts 
				ON employees.post_key = posts.post_key 
				WHERE posts.name = 'Продавец' OR posts.name = 'Курьер'");
			while ($record = mysqli_fetch_array($records)) {
				$arr[$record['employee_key']] = $record['employee_key'];
			}
			$employee_id = array_rand($arr);
			$ids = mysqli_query($link, "SELECT * FROM employees WHERE employee_key = " . $employee_id);
			$employee = mysqli_fetch_array($ids);
			?>

			<?php
			$user = $_SESSION['user_id'];
			$records = mysqli_query($link, "SELECT * FROM consumers WHERE consumer_key = " . $user);
			$consumer = mysqli_fetch_array($records);
			$sum = 0;
			?>

			<div id="info">
				<br>
				<div align="left">
					<form method="post">
						<fieldset>
							<legend>Дополнительная информация о заказе</legend>
							<b>Способ получения:</b><br>
							<input type="radio" name="type" value="1">Доставка<br>
							<input type="radio" name="type" value="2">Самовывоз<br>
							<p><b>Дата получения:</b></p>
							<input type="date" name="date">
							<p><b>Комментарий:</b></p>
							<p><textarea name="comments" rows="7" cols="50"></textarea></p>
						</fieldset><br>

						<fieldset>
							<legend>Информация о заказчике</legend>
							<table>
								<tr>
									<td>Имя:</td>
									<td><?php echo $consumer['name'] ?></td>
								</tr>
								<tr>
									<td>Телефон:</td>
									<td><?php echo $consumer['phone'] ?></td>
								</tr>
								<tr>
									<td>Город:</td>
									<td><?php echo $consumer['city'] ?></td>
								</tr>
								<tr>
									<td>Адрес:</td>
									<td><?php echo $consumer['address'] ?></td>
								</tr>
							</table>
						</fieldset><br>

						<fieldset>
							<legend>Приобретаемые товары</legend>
							<?php
							if (!empty($_SESSION['products'])) {
								echo '<table>';
								foreach ($_SESSION['products'] as $product_key => $number) {
									$query = mysqli_query($link, "SELECT * FROM products WHERE product_key = " . $product_key);
									while ($result = mysqli_fetch_array($query)) {
										$sum += $result['price'] * $number;
										echo '<tr><td colspan="3"><b><br>' . $result['name'] . " " . $result['producer'] . '</b></td></tr>';
										echo '<tr><td rowspan="4"><img src="../images/nota.jpg" width="80"></td>';
										echo
										"<tr><td>Дата производства:</td><td>".date("d.m.Y", strtotime($result['date']))."</td></tr>" .
											"<tr><td>Цена:</td><td>".$result['price']." Р</td></tr>" .
											"<tr><td>Количество:</td><td>{$number}</td></tr>";
									}
								}
								echo '</table>';
							}
							?>
						</fieldset><br>

						<fieldset>
							<legend>Сумма</legend>
							<table>
								<tr>
									<td>Сумма покупки:</td>
									<td><?php echo $sum ?>Р</td>
								</tr>
							</table>
						</fieldset><br>

						<input id="submit" type="submit" value="Оформить" name="button">
						<br><br>

					</form>
				</div>
			</div>

		</div>
	</div>

	<?php
		if (isset($_POST["button"])) {
			$orders = mysqli_query($link, "SELECT * FROM orders ORDER BY order_key DESC LIMIT 1");
			$order = mysqli_fetch_array($orders);
			$key = $order['order_key'] + 1;

			if (empty($_POST['type']) || empty($_POST['date'])) {
				echo '<p><b>Пожалуйста, заполните все поля</b></p>';
			}
			else {
				$order_query = mysqli_query(
					$link,
					"INSERT INTO orders (order_key, comments, consumer_key, order_type_key)
					VALUES (".$key.", '{$_POST['comments']}', '{$_SESSION['user_id']}', '{$_POST['type']}')"
				) or die(mysqli_error($link) . "insert failed");

				$emp_id = $employee['employee_key'];
				$sales_query = mysqli_query(
					$link,
					"INSERT INTO sales (sum, date, order_key, employee_key)
					VALUES (" . $sum . ", '{$_POST['date']}', " . $key . ", " . $emp_id . ")")
					or die(mysqli_error($link) . "insert failed");

				foreach ($_SESSION['products'] as $product_key => $number) {
					for ($i = 0; $i < $number; $i++) {
						$units_query = mysqli_query($link, 
						"INSERT INTO units (product_key, order_key) 
						VALUES (" . $product_key . ", " . $key .
						")"
						) or die(mysqli_error($link) . "insert failed");
					}
				}

				header("Location: complete.php");	
			}
		}
	?>

</body>

</html>