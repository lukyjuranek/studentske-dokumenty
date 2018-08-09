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
          <li class="nav-item">
              <a class="nav-link" href="moje_soubory.php">Moje soubory</a>
            </li>
          <li class="nav-item active">
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
            <div class="alert alert-dark">Před tím než soubor nahrajete, tak se ujistěte, že je pojmenován ve stylu: <strong>téma.přípona</strong><br>Např.: <strong>Balkánský poloostrov.pptx</strong></div>
    <form method="post" name="file_upload" enctype="multipart/form-data">
    
    
        <span>
            <input type="file" id="file" multiple="" name="file[]" class="inputfile" data-multiple-caption="{count} files selected" multiple />
        </span>
    
            <br />
            <br />
            <div class="form-group">
                <label for="usr">Poznámky:</label>
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
    
            <input type="submit" name="upload_imgs" value="Nahrát" class="btn btn-warning" />
    </form>
    <?php
//=================================================================================================
include("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
require('Db.php');
Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam preklep)


//header('Content-type: text/html; charset=utf8');
//nahraje soubor
if (isset($_FILES['file'])) {
    $imagesCount = count($_FILES['file']['name']);
    for ($i = 0; $i < $imagesCount; $i++) {
        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], 'soubory/' . $_FILES['file']['name'][$i])) {
            echo ('<br><div class="alert alert-success alert-dismissible fade show"><button type="button" class="close" data-dismiss="alert">&times;</button>Soubor byl úspěšně nahrán</div>');
            Db::query('
                                INSERT INTO soubor (nazev, predmet, popis, od_uzivatele, datum_uploadu)
                                VALUES (?, ?, ?, ?, ?)
                            ', $_FILES['file']['name'][0], $_POST['predmet'], $_POST['popis'], $_SESSION['prezdivka'], date("d-m-Y"));
        }
        
        else
            echo ('chyba');
    }
}
//=================================================================================================
?>
    
    </div>
    
       

</body>
</html>