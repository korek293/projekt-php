<?php
require("naglowek.php");
require("menu.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $signal = filter_input(INPUT_POST, 'signal', FILTER_SANITIZE_STRING);
    $nrdevice = filter_input(INPUT_POST, 'nrdevice', FILTER_VALIDATE_INT);
    $value = filter_input(INPUT_POST, 'value', FILTER_VALIDATE_INT);

    if ($id !== false && $signal !== null && $nrdevice !== false && $value !== false) {
        $conn = new PDO("sqlite:stus.db");
        $sql = 'UPDATE signal SET signal=:signal, nrdevice=:nrdevice, value=:value WHERE id=:id;';
        $st = $conn->prepare($sql);

        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->bindValue(":signal", $signal, PDO::PARAM_STR);
        $st->bindValue(":nrdevice", $nrdevice, PDO::PARAM_INT);
        $st->bindValue(":value", $value, PDO::PARAM_INT);

        $st->execute();
        $conn = null;

        header('Location: index.php');
        exit();
    }
} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $conn = new PDO("sqlite:stus.db");
    $sql = 'SELECT * FROM signal WHERE id=:id;';
    $st = $conn->prepare($sql);

    $st->bindValue(":id", $id, PDO::PARAM_INT);

    $st->execute();

    $dane = $st->fetchAll(PDO::FETCH_ASSOC);

    echo '<form method="post" action="edycjasignal.php">
        <input type="hidden" name="id" value="' . $dane[0]['id'] . '">
        <label>Nazwa sygnału</label><br>
        <input type="text" name="signal" value="' . $dane[0]['signal'] . '"/><br>
        <label>Numer urządzenia</label><br>
        <input type="text" name="nrdevice" value="' . $dane[0]['nrdevice'] . '"/><br>
        <label>Wartość</label><br>
        <input type="text" name="value" value="' . $dane[0]['value'] . '"/><br>
        <input class="przycisk" type="submit" name="wyslij" value="Zapisz zmiany"/><br>
        </form>';
}

require('stopka.php');
?>
