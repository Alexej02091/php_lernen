<?php
    session_start();
    include_once 'backend_php/db_zugriff.php';
    
    
    class Login {
        public function userTabellecheck($name, $password){
            $db = new dbzugriff();
            $db->connect();

            $sql = "SELECT ID, password, rolle FROM users WHERE name = '$name' LIMIT 1";
            $user=$db->query($sql);

            if (empty($user)) {
            $_POST = [];;
            }

            // Password aus DB holen
            $hash = $user["password"];

            // Password prüfen
            if(password_verify($password, $hash)){
                $_POST = [];
                $_SESSION["name"] = $name;
                $_SESSION["user_id"] = $user["ID"];
                $_SESSION["rolle"] = $user["rolle"];

                if($_SESSION["rolle"] == "admin"){
                    header("Location: backend_php/admin.php");
                    exit;
                }
                elseif ($_SESSION["rolle"] == "user"){
                    header("Location: backend_php/user.php");
                    exit;
                } else {
                    header("Location: index.php");
                    exit;
                }
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
    <title>Test</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
     <style>
        #box {
        width: 200px;
        height: 100px;
        background: lightblue;
        padding: 20px;
        margin-top: 20px;
        border-radius: 8px;
        font-size: 18px;
        }
    </style>
</head>
<body>
<button id="btn">Klick mich!</button>

  <div id="box">Ich bin eine Box</div>
<script>
    // jQuery Code
    $("#btn").click(function() {
      $("#box").css("background", "lightgreen");
      $("#box").text("Du hast geklickt!");
    });
  </script>

    <form action="index.php" method="post">    
        <label>Name:</label>
            <input type="text" name="name" autocomplete="off">
        <label>Passwort:</label>
            <input type="password" name="password" autocomplete="off">
        <button type="submit">Login</button>
    </form>

<?php
    if (!empty($_POST["name"]) && !empty($_POST["password"])) {
        $login = new Login;
        $login->userTabellecheck($_POST["name"], $_POST["password"]);
    }
?>
    </body>
</html>