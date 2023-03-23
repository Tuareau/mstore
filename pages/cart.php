<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Ваш заказ</title>
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

			<h3>Ваш заказ</h3>

			<p>Внимательно проверьте детали заказа</p>

			<?php
			if (isset($_GET['delete_id'])) {
				if (!isset($_SESSION['user_id'])) {
					echo '<p>Пожалуйста, <a href="login.php">войдите</a> или
				<a href="register.php">зарегистрируйтесь</a>, чтобы совершать покупки</p>';
				} else {
					echo '<br><p>Единица товара убрана из корзины</p>';
					$_SESSION['products'][$_GET['delete_id']] -= 1;
					if ($_SESSION['products'][$_GET['delete_id']] == 0) {
						unset($_SESSION['products'][$_GET['delete_id']]);
					}
				}
			}
			?>

			<?php
			if (!isset($_SESSION['user_id'])) {
				echo '<p>Пожалуйста, <a href="login.php">войдите</a> или
				<a href="register.php">зарегистрируйтесь</a>, чтобы совершать покупки</p>';
			}
			?>

			<?php
			if (!empty($_SESSION['products'])) {
				echo '<div id="catalog">';
				foreach ($_SESSION['products'] as $product_key => $number) {
					echo '<div id="product">';
					$query = mysqli_query($link, "SELECT * FROM products WHERE product_key = " . $product_key);
					while ($result = mysqli_fetch_array($query)) {
						$date = date("Y", strtotime($result['date']));
						$photo = "../images/" . $result['photo'];
						echo '<img src="' . $photo . '" width="320" height="180"></img>';
						echo '<p><b>' . $result['name'] . " " . $result['producer'] . ' (' . $date . ')</b></p>';
						echo '<p>' . $result['price'] . ' Р</p>';
						echo '<p>Количество: '.$number. '</p>';
						echo '<a id="adel"'." href='?delete_id={$result['product_key']}'>Убрать</a>";
					}
					echo '</div>';
				}
				echo '</div>';
				echo '<br><p><a id="a-big-black" href="purchase.php">Оформить заказ</a></p><br><br><br>';
			} else {
				echo '<p><i>Ваша корзина пока пуста</i></p>';
			}
			?>

		</div>
	
	</div>

</body>

</html>