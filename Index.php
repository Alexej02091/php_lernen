<?php
    session_start();
    include_once 'datenbank/db_zugriff.php';
    include_once 'datenbank/db_check.php';
    
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $login = new Login();
        $result = $login->userTabellecheck($_POST["name"], $_POST["password"]);

        if ($result !== true) {
            // Fehlertext in Session speichern
            $_SESSION["login_error"] = $result;

            // Redirect → PRG Pattern
            header("Location: index.php");
            exit;
        }
    }



    class Login {
        public function userTabellecheck($name, $password){
            $db = new dbzugriff();
            $db->connect();
            $sql = "SELECT id, password, rolle FROM users WHERE name = '$name' LIMIT 1";
            $user=$db->query($sql);

            if (!$user || !is_array($user)) {
            return "Login fehlgeschlagen.";
            }

            // Password aus DB holen
            $hash = $user["password"];

            // Password prüfen
            if(password_verify($password, $hash)){
                //$_POST = [];
                $_SESSION["name"] = $name;
                $_SESSION["user_id"] = $user["id"];
                $_SESSION["rolle"] = $user["rolle"];

                // Weiterleitung
                $base = dirname($_SERVER['PHP_SELF']);

                if($user["rolle"] === "admin"){
                    header("Location: $base/backend_php/admin.php");
                    exit;
                }
                
                if ($user["rolle"] === "user"){
                    header("Location: $base/backend_php/user.php");
                    exit;
                }

                header("Location: $base/index.php");
                exit;
                
            }
        }
    }

?>

<!DOCTYPE html>

<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP lernen</title>
    <link rel="stylesheet" href="<?= dirname($_SERVER['PHP_SELF']); ?>/assets/css/main.css">
    <script src="<?= dirname($_SERVER['PHP_SELF']); ?>/assets/js/jquery-3.7.1.min.js"></script>
</head>
    <body>
        <div class="wrapper">
            <?php
            $db_check = new dbzugriff();
            DBCheck::check($db_check);

            $statusClass = "";
            $message = "";

            $statusFallback = "";
            $messageFallback = "";

            // Wenn DBCheck etwas gesetzt hat
            if (isset($_SESSION["db_status"])) {
                $message = $_SESSION["db_status"]["message"];

                if ($_SESSION["db_status"]["ok"] === true) {
                    $statusClass = "db-ok";
                }
                
                if ($_SESSION["db_status"]["ok"] === false) {
                    $statusClass = "db-error";
                }
            } else {
                // Falls gar kein Status existiert → neutrale Info
                $statusClass = "db-error";
                $message = "Unbekannter Datenbankstatus.";
            }

            if (isset($_SESSION["fallback_status"])) {
                $messageFallback = $_SESSION["fallback_status"]["message"];

                if ($_SESSION["fallback_status"]["ok"] === true) {
                    $statusFallback = "db-ok";
                }
                    if ($_SESSION["fallback_status"]["ok"] === false) {
                    $statusFallback = "db-error";
                }

            } else {
                $statusFallback = "db-error";
                $messageFallback = "Unbekanter Fallbackstatus";
            }
            ?>

            <div class="db-status <?= $statusClass ?>">
                <?= $message ?>
            </div>

            <div class="db-status <?= $statusFallback ?>">
                <?= $messageFallback ?>
            </div>

            <?php// var_dump($_SESSION["db_status"]);?>
            <form action="index.php" method="post">    
                <label>Name:</label>
                    <input type="text" name="name" autocomplete="off">
                <label>Passwort:</label>
                    <input type="password" name="password" autocomplete="off">
                <button type="submit">Login</button>
            </form>

            <?php if (isset($_SESSION["login_error"])): ?>
            <div class="error-box">
                <?= htmlspecialchars($_SESSION["login_error"]) ?>
            </div>
            <?php unset($_SESSION["login_error"]); ?>
            <?php endif; ?>
        </div>
    </body>
</html>