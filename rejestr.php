<?php
require("naglowek.php");
require("menu.php");

$conn = new PDO("sqlite:stus.db");
$sql = 'SELECT * FROM device';
$st = $conn->prepare($sql);
$st->execute();
$dane = $st->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

echo '<table>';
echo '<tr>
            <th>Id</th>
            <th>Nazwa sygnału</th>
            <th>Nazwa urządzenia</th>
            <th>Wartość</th>
            <th>Czas zmiany</th>
      </tr>';
foreach ($dane as $pracownik) {
    echo '<tr>';

    foreach ($pracownik as $klucz => $wartosc) {
        if ($klucz === 'urlop') {
            $znak = ($wartosc == 1) ? '&#10004;' : '&#10006;';
            echo "<td>$znak</td>";
        } else {
            echo '<td><a href="index.php?akcja=edycjapracownika&id=' . $pracownik['id'] . '">' . $wartosc . '</a></td>';
        }
    }

    echo '<td><a href="usunpracownika.php?id=' . $pracownik['id'] . '">Usuń</a></td>';
    echo '</tr>';
}
require('stopka.php');
?>