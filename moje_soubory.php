<!DOCTYPE html>
<html lang="cz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>studentske-dokumenty.cekuj.net</title>
    <!-- BOOTSTRAP  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>

        <script src="js/main.js"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php
//=================================================================================================
//oveří zda je uživatel přihlášen
session_start();
if (!isset($_SESSION['uzivatel_id'])) {
    header('Location: index.php');
    exit();
}
if (isset($_GET['odhlasit'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
//=================================================================================================
?>
   

    <nav class="navbar sticky-top  navbar-expand-lg navbar-dark bg-main-gradient">
      <a class="navbar-brand" href="">studentske-dokumenty.cekuj.net</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="soubory.php">Všechny soubory<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
              <a class="nav-link" href="moje_soubory.php">Moje soubory</a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="upload.php">Přidat soubor</a>
          </li>
          <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#myModal" href="">Odhlásit</a></li><!-- Bez atributu href nefungují bootsrap styly -->
          </li>
          <li class="nav-item">
              <a class="nav-link" id="nav_link_divider">|</a>
          </li>
          <span class="navbar-text"><?php echo $_SESSION['prezdivka'] ?></span>
          
        </ul>
      </div>
    </nav>

    <div class="container" style="overflow-x: auto">
      <!-- THE MODAL ZAČÁTEK -->
      <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Opravdu se chcete odhlásit?</h4>
                        <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>
                    
                    <!-- Modal body -->
                    <div class="modal-body mx-auto">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="location.href='soubory.php?odhlasit'">Ano</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Ne</button>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <!-- THE MODAL KONEC -->

    <div class="container" style="overflow-x: auto">
        <br>
          <input class="form-control" id="myInput" type="text" placeholder="Search..">
          <br>
      
    
        
    <?php
//=================================================================================================
include("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
// require('Db.php');
// Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam preklep)

// $result = Db::queryOne('
//     SELECT *
//     FROM soubor
//     WHERE od_uzivatele=?
//     ', $_SESSION['prezdivka']);
//musim vypnout fetch_assoc() protoze uz je v Db::

$con = mysqli_connect("localhost", $username, $password, $database);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$prezdivka = $_SESSION['prezdivka'];

$result = mysqli_query($con, "SELECT * FROM soubor WHERE od_uzivatele='$prezdivka'");



echo "<form method='post'><table class='table table-bordered'><thead><tr><th>Označit</th><th>Název</th><th>Předmět</th><th>Popis</th><th>Datum přidání</th></tr></thead><tbody id='myTable'>";
$i = 0;
while ($row = $result->fetch_assoc()) {
    $x = 0;
    if ($i == 0) {
        $i++;
        //echo "<tr>";
        //    foreach ($row as $key => $value) {
        //    echo "<th>" . $key . "</th>";
        //    }
        //echo "</tr>";
    }
    ;
    $y = 0;
    foreach ($row as $value) {
        if ($y == 0) {
            $y++;
            echo "<tr><td><input type='checkbox' name='del[]' value='" . $value . "'></td>";
        }
        ;
        if ($x == 0) {
            echo "<td><a data-toggle='tooltip' title='Stáhnout' data-placement='right'  href='soubory/" . $value . "'>" . $value . "</a></td>";
        } elseif ($x == 3) {
            $x++;
            continue;
        } else {
            echo "<td>" . $value . "</td>";
        }
        ;
        $x++;
    }
    echo "</tr>";
}
echo "</tbody></table><input type='submit' value='Odstranit' class='btn btn-danger' /></form>";

//vymaže soubor

if (isset($_POST['del'])) {
    foreach ($_POST['del'] as $soubor) {
        if (unlink('soubory/' . $soubor)) {
            mysqli_query($con, "DELETE FROM soubor WHERE nazev='$soubor'");
            echo ($soubor . ' smazáno');
            header('Location: moje_soubory.php');
        } else
            echo ("<br><div class='alert alert-success alert-dismissible fade show'><button type='button' class='close' data-dismiss='alert'>&times;</button>" . $soubor . " nepodařilo se smazat</div>");
    }
}

mysqli_close($con);
//=================================================================================================
?>
</div>


</body>
</html>