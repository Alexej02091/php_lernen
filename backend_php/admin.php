<?php
session_start();
include_once __DIR__ . '/../datenbank/db_zugriff.php';
$test_array_logintabelle = new Logintabelle;
$daten = $test_array_logintabelle->getAlleDaten();

class Logintabelle {
    private $db;
    private $sql;
    private $daten;

    public function __construct() {
        include_once __DIR__ . '/../datenbank/db_zugriff.php';

        $this->db = new dbzugriff();
        $this->db->connect();
        $this->sql="SELECT * FROM users";
        $this->daten=$this->db->query($this->sql);
    }

    public function zeigeAlleUsers($daten) {
        echo '<table>';
        echo '<tr>';
        echo '<th>ID</th>';
        echo '<th>Benutzername</th>';
        echo '<th>Passwort</th>';
        echo '<th>Rolle</th>';
        echo '<th>Löschen</th>';
        echo '<th>Bearbeiten</th>';
        echo '</tr>';

        for ($i = 0; $i < count($daten); $i++) {
            echo '<tr>';
            echo '<td>' . $daten[$i]['id'] . '</td>';
            echo '<td>' . $daten[$i]['name'] . '</td>';
            echo '<td>' . $daten[$i]['password'] . '</td>';
            echo '<td>' . $daten[$i]['rolle'] . '</td>';
            echo '<td>';
            echo '<form method="post">';
            echo    '<button type="submit" name="loesche" value="' . $daten[$i]['id'] . '">User löschen</button>';
            echo '</form>';
            echo '</td>';
            echo '<td>';
            echo '<form method="post">';
            echo    '<button type="submit" name="user_id" value="' . $daten[$i]['id'] . '">User bearbeiten</button>';
            echo '</form>';
            echo '</td>';

            echo '</tr>';
        }

        echo '</table>';
    }


    public function getAlleDaten() {
        return $this->daten;
    }
}


class UserVerwalten {
    private $db;

    function __construct() {
        include_once('db_zugriff.php');

        $this->db = new dbzugriff();
        $this->db->connect();
    }

    public function legeNeueUserAn($name, $password, $rolle){

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, password, rolle)
                VALUES ('$name', '$hash', '$rolle')";
        $this->db->query($sql);
    }

    public function loescheUser($id) {
        $sql = "DELETE FROM users WHERE id = $id";
        $this->db->query($sql);
    }

    public function bearbeiteUserAnzeigen($id) {
        $sql = "SELECT * FROM users WHERE id = $id";
        $daten = $this->db->query($sql);

        echo '<form method="post">';
        echo '<table>';
        echo '<tr>';
        echo '<th>Benutzername</th>';
        echo '<th>Neues Passwort</th>';
        echo '<th>Rolle</th>';
        echo '</tr>';
        echo '<tr>';
        echo '<input type="hidden" name="user_id" value="'. $id .'">';
        echo '<input type="text" name="name_aendern" value="'. $daten['name'] .'" autocomplete="off"> ';
        echo '<input type="text" name="password_aendern" autocomplete="new-password">';
        echo '<select name="rolle_aendern">';
        echo    '<option value="admin" ' . ($daten['rolle'] === "admin" ? "selected" : "") . '>Administrator</option>';
        echo    '<option value="user" '  . ($daten['rolle'] === "user"  ? "selected" : "") . '>Benutzer</option>';
        echo '</select>';
        
        echo '<button type="submit" name="speichern" value="2">Speichern</button>';
        echo '</table>';
        echo '</form>';

    }


    public function bearbeiteUser($id, $name, $password, $rolle) {
        echo "<p style='color: green;'>Funktion bearbeiteUser wurde angesprochen</p>";
        
        if (isset($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);      
            $sql = "UPDATE users
                SET name = '$name',
                    password = '$hash',
                    rolle = '$rolle'
                WHERE id = '$id'";

            $this->db->query($sql);
            echo "<p style='color: green;'>User mit Password wurde erfolgreich geändert.</p>";
        } else if (!isset($password)) {
            $sql = "UPDATE users
            SET name = '$name',
                rolle = '$rolle'
            WHERE id = '$id'";
            $this->db->query($sql);
            echo "<p style='color: green;'>User wurde erfolgreich geändert.</p>";
        }
    }

}

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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <title>Test</title>
</head>
    <body>
    <form method="post">
        <button type="submit" name="logout">Logout</button>
    </form>
    </body>

    <p>Hallo: <?php echo $_SESSION["name"]; ?></p>

    <form action="admin.php" method="post">
        <label>Name:</label>
            <input type="text" name="neue_name" autocomplete="off">    
        <label>Password:</label>
            <input type="text" name="neue_password" autocomplete="off">
        <label>Rolle:</label>
        <select name="neue_rolle">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        
        <button type="submit" name="login_button" value="1">Neu anlegen</button>
    </form>
    
    <?php
        if (isset($_POST["login_button"])) {
        
        $neue_user = new UserVerwalten();
        $neue_user->legeNeueUserAn($_POST["neue_name"], $_POST["neue_password"], $_POST["neue_rolle"]);

        echo "<p style='color: green;'>User wurde erfolgreich angelegt.</p>";
        }

    ?>
    
    <?php
    // echo '<p> tabelle_user = ';
    // print_r($_POST['tabelle_user']);
    // echo '</p>';

    // echo '<p> loesche = ';
    // print_r($_POST['loesche']);
    // echo '</p>';

    if (!isset($_POST['tabelle_user']) || $_POST['tabelle_user'] === "") {
        echo '<form method="post">';
        echo    '<button type="submit" name="tabelle_user" value = "1">User anzeigen</button>';
        echo '</form>';
    } else if ($_POST['tabelle_user'] === "1") {
        echo '<form method="post">';
        echo    '<button type="submit" name="tabelle_user" value = "">User ausblenden</button>';
        echo '</form>';
        $test_array_logintabelle->zeigeAlleUsers($daten); 
    }

    if (isset($_POST['loesche'])) {
        $user_loeschen = new UserVerwalten(); 
        $user_loeschen->loescheUser($_POST["loesche"]);
    }

    if (isset($_POST['user_id'])) {
        $user_bearbeiten = new UserVerwalten();
        $user_bearbeiten->bearbeiteUserAnzeigen($_POST["user_id"]);
    }

    if (isset($_POST['speichern'])) {
        $user_ändern = new UserVerwalten();
        $user_ändern->bearbeiteUser($_POST["user_id"], $_POST["name_aendern"], $_POST["password_aendern"], $_POST["rolle_aendern"]);
    }
    ?>
    
</html>