<!DOCTYPE html>
<html lang="cs-cz">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Přihlášení</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>

		
		<?php
		require("sql_info.php");
		$database = DATABASE;
		$password = PASSWORD;
		$username = USERNAME;
		require('Db.php');
		Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam preklep)
		
		if (isset($_SESSION['uzivatel_id']))
		{
		header('Location: soubory.php');
		exit();
		}
		if ($_POST)
		{
		$uzivatel = Db::queryOne('
		SELECT uzivatel_id, heslo
		FROM uzivatel
		WHERE prezdivka=?
		', $_POST['prezdivka']);
		if (!$uzivatel || !password_verify($_POST['heslo'], $uzivatel['heslo'])){
		$zprava = 'Neplatné uživatelské jméno nebo heslo';
		echo $zprava;
		}
		else
		{
		$_SESSION['uzivatel_id'] = $uzivatel['uzivatel_id'];
		$_SESSION['prezdivka'] = $_POST['prezdivka'];
		header('Location: soubory.php');
		exit();
		}
		}
		?>
		
		<h1>studentske-dokumenty.cekuj.net</h1>
		<br>
		<div class="container-fluid form">

			<form method="post">
				<div class="form-group">
					<label>Uživatelské jméno:</label>
					<input type="text" class="form-control" name="prezdivka" autofocus>
				</div>
				<div class="form-group">
					<label>Heslo:</label>
					<input type="password" class="form-control" name="heslo">
				</div>
				<button type="submit" class="btn btn-primary">Přihlásit</button>
			</form>
			<br>
			Nemáte účet? <a href="registrace.php">Zaregistrovat</a>
		</div>
	</body>
</html>