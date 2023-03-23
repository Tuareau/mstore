<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>mstore: Вход</title>
</head>

<body>

	<div id="page">

		<div id="header">
			<table id="menu">
				<tr>
					<td class="htd"><a id="headera" href="../index.php">Главная</a></td>
					<td class="htd"><a id="headera" href="catalog.php">Каталог</a></td>
					<td class="htd"><a id="headera" href="contacts.php">Контакты</a></td>
					<td class="htd"></td>
					<td class="htd"><a id="headera" href="login.php">Вход</a></td>
				</tr>
			</table>
			<br>
		</div>

		<?php
		session_start();
		include "../services/connect.php";
		?>

		<?php
		if (isset($_POST['login'])) {
			$username = trim($_POST['username']);
			$password = trim($_POST['password']);
			$query = mysqli_query($link, "SELECT * FROM consumers WHERE consumers.login = '{$_POST['username']}'");
			if (!$query) {
				echo '<p>Неверные пароль или имя пользователя</p>';
			} else {
				$user = mysqli_fetch_array($query);
				if (!strcmp($password, trim($user['password']))) {
					$_SESSION['user_id'] = $user['consumer_key'];
					$_SESSION['user'] = $user;
					echo '<p>Вход выполнен успешно</p>';
					header("location: ../index.php");
				} else {
					echo '<p>Неверные пароль или имя пользователя</p>';
				}
			}
		}
		?>

		<br>
		<div id="main">
			<h2>Вход</h2>
			<p>Пожалуйста, введите свой логин и пароль</p>
			<form action="" method="post">
				<table align=center>
					<tr>
						<td>Логин:</td>
						<td><input type="text" name="username" required /></td>
					</tr>
					<tr>
						<td>Пароль:</td>
						<td><input type="password" name="password" required></td>
					</tr>
				</table>
				<br>
				<input id="submit" type="submit" name="login" value="Войти">
				<p>Еще нет учетной записи? <a href="register.php">Создайте здесь</a></p>
			</form>
		</div>
		
	</div>

</body>

</html>