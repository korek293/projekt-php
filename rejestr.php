<?php
require("naglowek.php");
require("menu.php");

$conn = new PDO("sqlite:stus.db");
$sql = 'SELECT * FROM register';
$st = $conn->prepare($sql);
$st->execute();
$dane = $st->fetchAll(PDO::FETCH_ASSOC);


echo '<div>';
echo '<p style="font-weight: bold; font-size: 20px; margin-bottom: 20px;">Rejestr zdarzeń</p>';
if(isset($_SESSION['czy_zalogowany'])) {
    echo '<button style="min-width: 200px; margin-right: 20px;" class="przycisk"><a class="linkprzycisk" href="usunrejestr.php">Oczyść rejestr</a></button>';
}
echo '<button style="min-width: 200px;" class="przycisk"><a class="linkprzycisk" href="eksport.php">Eksportuj</a></button>';
echo '</div>';

echo '<table style="margin-top: 15px;">';
echo '<tr>
            <th>Id</th>
            <th>Nazwa sygnału</th>
            <th>Nazwa urządzenia</th>
            <th>Wartość</th>
            <th>Czas zmiany</th>
      </tr>';

foreach ($dane as $row) {
    echo '<tr>';
    echo '<td>' . $row['id'] . '</td>';
    echo '<td>' . $row['sygnal_name'] . '</td>';
    echo '<td>' . $row['device_name'] . '</td>';
    echo '<td>' . ($row['value'] == 1 ? 'Załączony' : 'Wyłączony') . '</td>';
    echo '<td>' . $row['time'] . '</td>';
    echo '</tr>';
}

echo '</table>';

require('stopka.php');
?>
