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
        <script src="https://www.w3schools.com/lib/w3.js"></script>
        <!-- FONT AVESOME -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

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
          <li class="nav-item active">
            <a class="nav-link" href="soubory.php">Všechny soubory<span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
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
        

        <div class="container">
          <br>
            
            <input class="form-control" id="myInput" type="text" placeholder="Hledat..">
            <br>
            <?php
//=================================================================================================
include("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
$con = mysqli_connect("localhost", $username, $password, $database);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con, "SELECT * FROM soubor");
echo "<table id='myTable' class='table table-bordered'><thead><tr><th class='sortable' onclick='w3.sortHTML(\"#myTable\", \".item\", \"td:nth-child(1)\")'>Název <i class='fas fa-sort' style='font-size:15px'></i></th><th class='sortable' onclick='w3.sortHTML(\"#myTable\", \".item\", \"td:nth-child(2)\")'>Předmět <i class='fas fa-sort' style='font-size:15px'></i></th><th>Poznámky</th><th class='sortable' onclick='w3.sortHTML(\"#myTable\", \".item\", \"td:nth-child(3)\")'>Přidáno uživatelem <i class='fas fa-sort' style='font-size:15px'></i></th><th class='sortable' onclick='w3.sortHTML(\"#myTable\", \".item\", \"td:nth-child(4)\")'>Škola <i class='fas fa-sort' style='font-size:15px'></i></th><th onclick='w3.sortHTML(\"#myTable\", \".item\", \"td:nth-child(5)\")'>Datum přidání</th></tr></thead><tbody id='myTableBody'>";
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
    echo "<tr class='item'>";
    foreach ($row as $value) {
        
        if ($x == 0) {
            echo "<td><a data-toggle='tooltip' title='Stáhnout' data-placement='right'  href='soubory/" . $value . "'>" . $value . "</a></td>";
        } elseif ($x == 3) {
            $skola_uzivatele = mysqli_query($con, "SELECT skola FROM uzivatel WHERE prezdivka='$value'");
            $row             = mysqli_fetch_assoc($skola_uzivatele);
            echo "<td>" . $value . "</td><td>" . $row['skola'] . "</td>";
        } else {
            echo "<td>" . $value . "</td>";
        }
        ;
        $x++;
    }
    echo "</tr>";
}
echo "</tbody></table>";
mysqli_close($con);
//=================================================================================================
?>
    </div>
        









   
</body>
</html>