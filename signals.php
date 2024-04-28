<?php
require("naglowek.php");
require("menu.php");

$conn = new PDO("sqlite:stus.db");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_GET['akcja']) && $_GET['akcja'] == 'zal') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE signal SET value = 1 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

if (isset($_GET['akcja']) && $_GET['akcja'] == 'wyl') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "UPDATE signal SET value = 0 WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}

$sql = 'SELECT * FROM signal';
$st = $conn->prepare($sql);
$st->execute();
$dane1 = $st->fetchAll(PDO::FETCH_ASSOC);

echo '<table>';
echo '<tr>
                <th>Id</th>
                <th>Nazwa sygnału</th>
                <th>Nr urządzenia</th>
                <th>Wartość</th>
                <th>Załączenie</th>
                <th>Wyłączenie</th>
                <th>Edycja</th>
                <th>Usunięcie</th>
          </tr>';

foreach ($dane1 as $signal) {
    echo '<tr>';
    echo '<td>' . $signal['id'] . '</td>';
    echo '<td>' . $signal['signal'] . '</td>';
    echo '<td>' . $signal['nrdevice'] . '</td>';
    echo '<td>' . $signal['value'] . '</td>';
    echo '<td><a href="index.php?akcja=zal&id=' . $signal['id'] . '">Zał.</a></td>';
    echo '<td><a href="index.php?akcja=wyl&id=' . $signal['id'] . '">Wył.</a></td>';
    echo '<td><a href="index.php?akcja=edycjasignal&id=' . $signal['id'] . '">Edytuj</a></td>';
    echo '<td><a href="index.php?akcja=usunsignal&id=' . $signal['id'] . '">Usuń</a></td>';
    echo '</tr>';
}
echo '</table>';

$conn = null;

require('stopka.php');
?>
