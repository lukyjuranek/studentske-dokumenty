<!DOCTYPE html>
<html lang="cs-cz">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Registrace uživatele</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="css/login.css">
    </head>
    <body>
        <?php
//=================================================================================================
include("sql_info.php");
$database = DATABASE;
$password = PASSWORD;
$username = USERNAME;
require('Db.php');
Db::connect('localhost', $database, $username, $password); //nazev je firstdatbase(je tam preklep)

if ($_POST) {
    
    $existuje_prezdivka = Db::querySingle('
        SELECT COUNT(*)
        FROM uzivatel
        WHERE prezdivka=?
        LIMIT 1
        ', $_POST['prezdivka']);
    
    $existuje_email = Db::querySingle('
        SELECT COUNT(*)
        FROM uzivatel
        WHERE email=?
        LIMIT 1
        ', $_POST['email']);
    
    
    
    
    if ($existuje_prezdivka)
        echo "<p>Uživatel s tímto jménem již existuje</p>";
    elseif ($existuje_email)
        echo 'Uživatel s tímto emaiilem již existuje.';
    elseif ($_POST['heslo'] != $_POST['heslo_znovu']) {
        echo "<p>Hesla se neshodují</p>";
    } else {
        $heslo = password_hash($_POST['heslo'], PASSWORD_DEFAULT); //Zahashuje heslo
        Db::query('
                    INSERT INTO uzivatel (prezdivka, email, skola, heslo)
                    VALUES (?, ?, ?, ?)
                ', $_POST['prezdivka'], $_POST['email'], $_POST['skola'], $heslo);
        echo ('<p>Byl jste úspěšně zaregistrován. <a href="index.php" style="color:white;">Přihlásit</a>');
    }
}
//=================================================================================================
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
                    <label>Email:</label>
                    <input type="email" class="form-control" name="email">
                </div>
                <div class="form-group">
                    <label>Škola:</label>
                    <input type="text" class="form-control" name="skola">
                </div>
                <div class="form-group">
                    <label>Heslo:</label>
                    <input type="password" class="form-control" name="heslo">
                </div>
                <div class="form-group">
                    <label>Heslo znovu:</label>
                    <input type="password" class="form-control" name="heslo_znovu">
                </div>
                
                
                <button type="submit" class="btn btn-primary">Zaregistrovat</button>
            </form>
            <br>
            <a href="index.php">Přihlásit</a>
        </div>
        
    </body>
</html>