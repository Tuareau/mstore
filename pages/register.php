<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>Регистрация</title>
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

		if (isset($_POST['register'])) {
			$username = trim($_POST['name']);
			$login = trim($_POST['login']);
			$password = trim($_POST['password']);
			$query = mysqli_query($link, "SELECT * FROM consumers WHERE login='{$_POST['login']}'");
			if ($query && $users = mysqli_fetch_array($query)) {
				echo '<p class="error">Пользователь с таким логином уже зарегестрирован</p>';
			} else {
				$query = mysqli_query(
					$link,
					"INSERT INTO consumers(name, login, password) 
					VALUES ('{$_POST['name']}', '{$_POST['login']}', '{$_POST['password']}')"
				);
				if ($query) {
					echo '<p class="success">Регистрация прошла успешно</p>';
				} else {
					echo '<p class="error">Ошибка в веденных данных</p>';
				}
			}
			mysqli_close($link);
		}
		?>

		<br>
		<div id="main">
			<h2>Регистрация</h2>
			<p>Пожалуйста, заполните все поля, чтобы создать учетную запись</p>
			<form action="" method="post">
				<table align=center>
					<tr>
						<td>Имя:</td>
						<td><input type="text" name="name" required></td>
					</tr>
					<tr>
						<td>Логин:</td>
						<td><input type="text" name="login" required /></td>
					</tr>
					<tr>
						<td>Пароль:</td>
						<td><input type="password" name="password" required></td>
					</tr>
				</table>
				<br>
				<input id="submit" type="submit" name="register" value="Зарегистрироваться">
				<p>Уже есть учетная запись? <a href="login.php">Войдите здесь</a></p>
			</form>
		</div>
	</div>


</body>

</html>