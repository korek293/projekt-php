<?php
if (isset($_SERVER['REQUEST_METHOD'])) {
    $formularz = $_SERVER['REQUEST_METHOD'];
} else {
    $formularz = "";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $device = filter_input(INPUT_POST, 'device', FILTER_SANITIZE_STRING);

    $conn = new PDO("sqlite:stus.db");
    $sql = 'UPDATE device SET device=:device WHERE id=:id;';
    $st = $conn->prepare($sql);

    $st->bindValue(":id", $id, PDO::PARAM_INT);
    $st->bindValue(":device", $device, PDO::PARAM_STR);

    $st->execute();
    $conn = null;

    echo "Urządzenie zostało zmienione pomyślnie.";

    header('Location: index.php');

} else {
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    $conn = new PDO("sqlite:stus.db");
    $sql = 'SELECT * FROM device WHERE id=:id;';
    $st = $conn->prepare($sql);

    $st->bindValue(":id", $id, PDO::PARAM_INT);

    $st->execute();

    $dane = $st->fetchAll(PDO::FETCH_ASSOC);

    echo
        '<form method="post" action="index.php?akcja=edycjadevice">
        <input type="hidden" name="id" value="' . $dane[0]['id'] . '">
        <label>Nazwa urządzenia</label><br>
        <input type="text" name="device" value="' . $dane[0]['device'] . '"/><br>
        <input class="przycisk" type="submit" name="wyslij" value="Zapisz zmiany"/><br>
        </form>
        ';
}
?>
