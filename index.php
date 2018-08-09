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
<body id="login_body">
  


<div class="row mt-5 pt-5">
    <div class="mx-auto col-lg-4 col-md-5 col-sm-6 col-11" id="form_col">
        <h1 class="text-center mb-3">Přihlášení</h1> 




        <form method="POST">
            <div class="form-group">
                    <input type="email" class="form-control mb-2" placeholder="Email" name="email">
                    <input type="password" class="form-control mb-2" placeholder="Heslo" name="heslo">
                <button type="submit" class="btn bg-black btn-block" id="login_form_button">Přihlásit</button>
            </div>
        </form>
        <p class="text-center"><a id="bottom_form_link" href="registrace.php">Zaregistrovat</a></p>
        
    <?php
//=================================================================================================
session_start();
require("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
require('Db.php');
Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam překlep)

//oveří zda je uživatel přihlášen
if (isset($_SESSION['uzivatel_id'])) {
    header('Location: soubory.php');
    exit();
}
if ($_POST) {
    $uzivatel = Db::queryOne('
        SELECT uzivatel_id, heslo, prezdivka
        FROM uzivatel
        WHERE email=?
        ', $_POST['email']);
    if (!$uzivatel || !password_verify($_POST['heslo'], $uzivatel['heslo'])) {
        echo "<div class='alert alert-success alert-dismissible'>
        <button type='button' class='close' data-dismiss='alert'>&times;</button>
        Neplatný email nebo heslo
      </div>";
    } else {
        $_SESSION['uzivatel_id'] = $uzivatel['uzivatel_id'];
        $_SESSION['prezdivka'] = $uzivatel['prezdivka']; 
        header('Location: soubory.php');
        exit();
    }
}
//=================================================================================================
?>
    </div>

</div>




   
</body>
</html>