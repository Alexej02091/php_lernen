<?php
session_start();
include_once 'tabellen_login.php';

$test_array_logintabelle = new Logintabelle;
$daten = $test_array_logintabelle->getAlleDaten();

if (isset($_POST["logout"])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");
    exit;
}

?>

<!DOCTYPE html>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
    <body>
    <form method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
    </body>

    <p>Hallo: <?php echo $_SESSION["name"]; ?></p>

    <form method="post">
        <button type="submit" name="tabelle_user">User anzeigen</button>
    </form>
 <?php
    if (isset($_POST["tabelle_user"])) {
        $test_array_logintabelle->zeigeAlleUsers($daten); 
    }

    
?>
    
</html>