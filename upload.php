<!DOCTYPE html>
<html lang="cs-cz">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
		<title>Soubory</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/soubory.css">	
		<script src="js/main.js"></script>
	</head>

	<body>
	<?php
	//=================================================================================================
		//oveří zda je uživatel přihlášen
		session_start();
		if (!isset($_SESSION['uzivatel_id']))
		{
		header('Location: index.php');
		exit();
		}
		if (isset($_GET['odhlasit']))
		{
		session_destroy();
		header('Location: index.php');
		exit();
		}
		//=================================================================================================
		?>


<h1>studentske-dokumenty.cekuj.net</h1>

	<ul class="nav">
		<li class="nav-item"><a href="soubory.php" class="nav-link">Všechny soubory</a></li>
		<li class="nav-item"><a href="upload.php" class="nav-link active">Přidat soubor</a></li>
		<li class="nav-item"><a href="moje_soubory.php" class="nav-link">Moje soubory</a></li>
		<li class="nav-item"><a href="" class="nav-link" data-toggle="modal" data-target="#myModal">Odhlásit</a></li><!-- Bez atributu href nefungují bootsrap styly -->
		<li class="nav-item ml-auto"><a href="moje_soubory.php" class="nav-link"><?php session_start(); echo $_SESSION['prezdivka'] ?></a></li>
	</ul>


<!-- THE MODAL ZAČÁTEK -->
		<div class="modal fade" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">Opravdu se chcete odhlásit?</h4>
						<button type="button" class="close" data-dismiss="modal">×</button>
					</div>
					
					<!-- Modal body -->
					<div class="modal-body">
						<button type="button" class="btn btn-success" data-dismiss="modal" onclick="location.href='soubory.php?odhlasit'">Ano</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">Ne</button>
					</div>
					
					
				</div>
			</div>
		</div>
		<!-- THE MODAL KONEC -->


<div class="main">

<div class="alert alert-warning">Před tím než soubor nahrajete, tak ho pojmenujte ve stylu: <strong>téma.přípona</strong><br>Např.: <strong>Balkánský poloostrov.pptx</strong></div>
<form method="post" name="file_upload" enctype="multipart/form-data">


	<span>
        <input type="file" id="file" multiple="" name="file[]" class="inputfile" data-multiple-caption="{count} files selected" multiple />
    </span>

        <br />
        <div class="form-group">
			<label for="usr">Popis:</label>
			<input type="text" class="form-control" id="usr" name="popis">
		</div>
        <div class="form-group">
	  		<label for="sel1">Předmět:</label>
	  		<select class="form-control" id="sel1" name="predmet">
	        	<option disabled selected value>Předmět...</option>
	        	<option value="Český jazyk">Český jazyk</option>
				<option value="Český jazyk (čtenářský deník)">Český jazyk (čtenářský deník)</option>
	        	<option value="Anglický jazyk">Anglický jazyk</option>
	        	<option value="Německý jazyk">Německý jazyk</option>
	        	<option value="Francouzský jazyk">Francouzský jazyk</option>
	        	<option value="Ruský jazyk">Ruský jazyk</option>
	        	<option value="Španělský jazyk">Španělský jazyk</option>
	        	<option value="Základy společenských věd a Občanská výchova">Základy společenských věd a Občanská výchova</option>
	        	<option value="Dějepis">Dějepis</option>
	        	<option value="Zeměpis">Zeměpis</option>
	        	<option value="Matematika">Matematika</option>
	        	<option value="Fyzika">Fyzika</option>
	        	<option value="Chemie">Chemie</option>
	        	<option value="Biologie">Biologie</option>
	        	<option value="Informatika a výpočetní technika">Informatika a výpočetní technika
</option>
	        	<option value="Hudební výchova">Hudební výchova</option>
	        	<option value="Výtvarná výchova">Výtvarná výchova</option>
			</select>
		</div>

        <input type="submit" name="upload_imgs" value="Nahrát" class="btn btn-primary" />
</form>

<?php
//=================================================================================================
include("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
require('Db.php');
Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam preklep)


header('Content-type: text/html; charset=utf8');
//nahraje soubor
if (isset($_FILES['file']))
{
        $imagesCount = count($_FILES['file']['name']);
        for ($i = 0; $i < $imagesCount; $i++)
        {
                if (move_uploaded_file($_FILES['file']['tmp_name'][$i], 'soubory/' . $_FILES['file']['name'][$i])){
                        echo('<br><div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>Soubor byl úspěšně nahrán</div>');
						Db::query('
								INSERT INTO soubor (nazev, predmet, popis, od_uzivatele, datum_uploadu)
								VALUES (?, ?, ?, ?, ?)
							', $_FILES['file']['name'][0], $_POST['predmet'], $_POST['popis'], $_SESSION['prezdivka'], date("d-m-Y"));
				}

                else
                        echo('chyba');
        }
}
//=================================================================================================
?>

</div>

</body>
</html>