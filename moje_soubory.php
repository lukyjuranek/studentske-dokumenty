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


<h1>studentske-dokumenty.cekuj.net</h1>

	<ul class="nav">
		<li class="nav-item"><a href="soubory.php" class="nav-link">Všechny soubory</a></li>
		<li class="nav-item"><a href="upload.php" class="nav-link">Přidat soubor</a></li>
		<li class="nav-item"><a href="moje_soubory.php" class="nav-link active">Moje soubory</a></li>
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
<!--Vyhledávání-->	
<input class="form-control" id="myInput" type="text" placeholder="Hledat..">
 <br>



<?php

include("sql_info.php");
			$database = DATABASE;
			$password = PASSWORD;
			$username = USERNAME;
			$con=mysqli_connect("localhost",$username,$password,$database);
		// Check connection
		if (mysqli_connect_errno())
		{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$prezdivka=$_SESSION['prezdivka'];
	
		$result = mysqli_query($con,"SELECT * FROM soubor WHERE od_uzivatele='$prezdivka'");
		
					echo "<form method='post'><table class='table table-bordered'><thead><tr><th>Označit</th><th>Název</th><th>Předmět</th><th>Popis</th><th>Datum přidání</th></tr></thead><tbody id='myTable'>";
						$i = 0;
						while($row = $result->fetch_assoc()){
							$x=0;
							if ($i == 0) {
								$i++;
								//echo "<tr>";
								//	foreach ($row as $key => $value) {
								//	echo "<th>" . $key . "</th>";
								//	}
								//echo "</tr>";
								};
								$y=0;
								foreach ($row as $value) {
									if ($y == 0) {
										$y++;
										echo "<tr><td><input type='checkbox' name='del[]' value='" . $value . "'></td>";
									};
									if($x==0){
										echo "<td><a data-toggle='tooltip' title='Stáhnout' data-placement='right'  href='soubory/".$value."'>". $value. "</a></td>";
									}
									elseif ($x==3) {
										$x++;
										continue;
									}
									else{
										echo "<td>". $value. "</td>";
									};
									$x++;
								}
							echo "</tr>";
						}
					echo "</tbody></table><input type='submit' value='Odstranit' class='btn btn-danger' /></form>";

					//vymaže soubor

					if (isset($_POST['del']))
					{
					        foreach ($_POST['del'] as $soubor)
					        {
					                if (unlink('soubory/' . $soubor)){
										mysqli_query($con,"DELETE FROM soubor WHERE nazev='$soubor'");
					                    echo($soubor . ' smazáno');
					                    header('Location: moje_soubory.php');
					                }
					                else
					                        echo("<br><div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$soubor." nepodařilo se smazat</div>");
 	
					        }
					}




		mysqli_close($con);





?>













  
</div>













</body>

</html>