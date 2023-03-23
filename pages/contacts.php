<html>

<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Контакты</title>
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
			<h3>Наши сотрудники</h3>
			<div id="contacts">
			<?php
			$posts = mysqli_query($link, "SELECT * FROM posts");
			while ($post = mysqli_fetch_array($posts)) {
				echo "<h4>{$post['name']}</h4>";
				$photo = "../images/post" . $post['post_key'];
				echo '<img width="240" height="160" src="' . $photo . '.jpg"></img>';
				$employees = mysqli_query($link, "SELECT * FROM employees WHERE employees.post_key = " . $post['post_key']);
				if ($employees) {
					echo '
					<p height=20></p>
					<table align=center>
					<tr>
						<td align=center width=150><b>Имя</b></td>
						<td align=center width=150><b>Телефон</b></td>
					</tr>';					
				}
				while ($employee = mysqli_fetch_array($employees)) {
					echo '
					<tr>
						<td align=center width=150>' . $employee['name'] . '</td>
						<td align=center width=150>' . $employee['phone'] . '</td>
					</tr>';
									
				}
				echo '</table>';	
			}
			?>
			</div>
		</div>
	</div>

</body>

</html>