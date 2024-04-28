<?php
require("naglowek.php");
require("menu.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $device = filter_input(INPUT_POST, 'device', FILTER_SANITIZE_STRING);

    $conn = new PDO("sqlite:stus.db");
    $sql = 'INSERT INTO device (device) VALUES (:device)';
    $st = $conn->prepare($sql);
    $st->bindValue(":device", $device, PDO::PARAM_STR);
    $st->execute();
    $conn = null;

    // Przekierowanie po dodaniu urządzenia
    header("Location: index.php");
    exit();
} else {
    // Wyświetlanie formularza dodawania urządzenia
    echo '
        <form method="post" action="dodajdevice.php">
        <label>Nazwa urządzenia</label><br>
        <input type="text" name="device"/><br>
        <input class="przycisk" type="submit" name="wyslij" value="Zapisz zmiany"/><br>
        </form>
    ';
}

require('stopka.php');
?>
