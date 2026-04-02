<?php
class Logintabelle {
    private $db;
    private $sql;
    private $daten;

    public function __construct() {
        include_once('db_zugriff.php');

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
            echo '</tr>';
        }

        echo '</table>';
    }


    public function getAlleDaten() {
        return $this->daten;
    }
}


