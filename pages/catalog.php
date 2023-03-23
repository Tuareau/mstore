<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Каталог</title>
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
		</div>

		<div id="main">

			<h3>Каталог музыкальных инструментов</h3>

			<p>Используйте фильтр для просмотра товаров разных видов</p>

			<?php
			if (isset($_GET['buy_id'])) {
				if (!isset($_SESSION['user_id'])) {
					echo '<p>Пожалуйста, <a href="login.php">войдите</a> или
				<a href="register.php">зарегистрируйтесь</a>, чтобы совершать покупки</p>';
				} else {
					echo '<p>Товар добавлен в корзину</p>';
					$_SESSION['products'][$_GET['buy_id']] += 1;
				}
			}
			?>

			<select name="filter" size="1" onchange="window.location='catalog.php?filter='+this.value">

				<?php
				$key = isset($_GET['filter']) ? intval($_GET['filter']) : NULL;
				$query = mysqli_query($link, "SELECT * FROM product_types");
				while ($result = mysqli_fetch_array($query)) {
					if ($key && ($key == $result['product_type_key'])) {
						echo "<option value=" . $result['product_type_key'] . " selected>" . $result['type'] . "</option>";
					} else {
						echo "<option value=" . $result['product_type_key'] . ">" . $result['type'] . "</option>";
					}
				}
				?>

			</select>

			<?php
			if (!empty($_GET['filter'])) {
				$query = mysqli_query($link, "SELECT * FROM products WHERE product_type_key = $_GET[filter]");
			} else {
				$query = mysqli_query($link, "SELECT * FROM products");
			}
			echo '<div id="catalog">';
			while ($result = mysqli_fetch_array($query)) {
				echo '<div id="product">';
				$date = date("Y", strtotime($result['date']));
				$photo = "../images/" . $result['photo'];
				echo '<img src="' . $photo . '" width="320" height="180"></img>';
				echo '<p><b>' . $result['name'] . " " . $result['producer'] . ' (' . $date . ')</b></p>';
				echo '<p>' . $result['price'] . ' Р</p>';
				echo '<a id="abuy"'." href='?buy_id={$result['product_key']}'>В корзину</a><br>";
				echo '</div>';
			}
			echo '</div>';
			?>

		</div>

	</div>

</body>

</html>