<?php
require("naglowek.php");
require("menu.php");

$conn = new PDO("sqlite:stus.db");
$sql = 'SELECT * FROM device';
$st = $conn->prepare($sql);
$st->execute();
$dane = $st->fetchAll(PDO::FETCH_ASSOC);
$conn = null;

echo '<table >';
echo '<form method="post" action="login.php">
            <label>Nazwa użytkownika:</label>
            <input type="text" name="username"/>
            <label>Hasło:</label>
            <input type="password" name="password"/>
            <button class="przycisk" type="submit" name="wyslij" value="logowanie">Zaloguj</button>
      </form>';

require('stopka.php');
?>