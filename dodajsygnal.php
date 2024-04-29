<?php
require("naglowek.php");
require("menu.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signal = filter_input(INPUT_POST, 'signal', FILTER_SANITIZE_STRING);
    $nrdevice = filter_input(INPUT_POST, 'nrdevice', FILTER_VALIDATE_INT);
    $value = filter_input(INPUT_POST, 'value', FILTER_VALIDATE_INT);

    $conn = new PDO("sqlite:stus.db");

    $sql_max2 = 'SELECT MAX(id) AS max_id2 FROM signal';
    $st_max2 = $conn->prepare($sql_max2);
    $st_max2->execute();
    $wynik2 = $st_max2->fetch(PDO::FETCH_ASSOC);
    $max_id2 = $wynik2['max_id2'];
    $new_id2 = $max_id2 + 1;

    $sql = 'INSERT INTO signal (id, signal, nrdevice, value) VALUES (:id, :signal, :nrdevice, :value)';
    $st = $conn->prepare($sql);
    $st->bindValue(":id", $new_id2, PDO::PARAM_INT);
    $st->bindValue(":signal", $signal, PDO::PARAM_STR);
    $st->bindValue(":nrdevice", $nrdevice, PDO::PARAM_INT);
    $st->bindValue(":value", $value, PDO::PARAM_INT);
    $st->execute();
    $conn = null;

    header("Location: index.php");
    exit();
} else {
    echo '
        <form method="post" action="dodajsygnal.php">
        <label>Nazwa sygnału</label><br>
        <input type="text" name="signal"/><br>
        <label>Numer urządzenia</label><br>
        <input type="text" name="nrdevice"/><br>
        <label>Wartość</label><br>
        <input type="text" name="value"/><br>
        <input class="przycisk" type="submit" name="wyslij" value="Zapisz zmiany"/><br>
        </form>
    ';
}

require('stopka.php');
?>
