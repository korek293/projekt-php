<?php
require("naglowek.php");
require("menu.php");

if(isset($_GET['akcja'])) {
    $akcja = $_GET['akcja'];
} else {
    $akcja = "";
}

switch($akcja) {
    case 'edycjadevice':
        require("edycjadevice.php");
        break;

    case 'usundevice':
        require("usundevice.php");
        break;

    default:
        glowna();
}

function glowna()
{
    $conn = new PDO("sqlite:stus.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * FROM device';
    $st = $conn->prepare($sql);
    $st->execute();
    $dane = $st->fetchAll(PDO::FETCH_ASSOC);

    echo '<table class="tablicaindex">';
    echo '<tr>
                    <th>Id</th>
                    <th>Nazwa urządzenia</th>
                    <th>Edycja</th>
                    <th>Usunięcie</th>
              </tr>';

    foreach ($dane as $device) {
        echo '<tr>';
        echo '<td>' . $device['id'] . '</td>';
        echo '<td>' . $device['device'] . '</td>';
        echo '<td><button class="przycisk"><a class="linkprzycisk" href="index.php?akcja=edycjadevice&id=' . $device['id'] . '">Edytuj</a></button></td>';
        echo '<td><button class="przycisk"><a class="linkprzycisk" href="index.php?akcja=usundevice&id=' . $device['id'] . '">Usuń</a></button></td>';
        echo '</tr>';
    }
    echo '</table>';

    echo '<div style="margin-top: 15px;"><button style="min-width: 200px;" class="przycisk"><a class="linkprzycisk" href="dodajdevice.php">Dodaj urządzenie</a></button></div>';

    $conn = null;
}

require('stopka.php');
?>
