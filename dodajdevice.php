<?php
require("naglowek.php");
require("menu.php");
session_start();

if(isset($_SESSION['czy_zalogowany'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $device = filter_input(INPUT_POST, 'device', FILTER_SANITIZE_STRING);

        $conn = new PDO("sqlite:stus.db");

        $sql_max = 'SELECT MAX(id) AS max_id FROM device';
        $st_max = $conn->prepare($sql_max);
        $st_max->execute();
        $wynik = $st_max->fetch(PDO::FETCH_ASSOC);
        $max_id = $wynik['max_id'];
        $new_id = $max_id + 1;

        $sql = 'INSERT INTO device (id, device) VALUES (:id, :device)';
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $new_id, PDO::PARAM_STR);
        $st->bindValue(":device", $device, PDO::PARAM_STR);
        $st->execute();
        $conn = null;

        header("Location: index.php");
        exit();
    } else {
        echo '
        <form method="post" action="dodajdevice.php">
        <label>Nazwa urządzenia</label><br>
        <input type="text" name="device"/><br>
        <input class="przycisk" type="submit" name="wyslij" value="Zapisz zmiany"/><br>
        </form>
    ';
    }
} else {
    echo "Brak uprawnien";
}
require('stopka.php');
?>
