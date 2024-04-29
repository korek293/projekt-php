<?php
require("naglowek.php");
require("menu.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    try {
        if(strlen($login) < 3) {
            throw new Exception("Login ma mieć co najmniej 3 znaki.");
        }

        if(ctype_upper($login)) {
            throw new Exception("Login nie może zawierać wielkich liter.");
        }

        if(strlen($password) < 3) {
            throw new Exception("Hasło ma mieć co najmniej 3 znaki.");
        }

        if(!ctype_alnum($password)) {
            throw new Exception("Nie wszystkie znaki hasła są znakami alfanumerycznymi.");
        }

        $conn = new PDO("sqlite:stus.db");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT * FROM user WHERE login=:login;';
        $st = $conn->prepare($sql);
        $st->bindValue(":login", $login, PDO::PARAM_STR);
        $st->execute();

        $dane4 = $st->fetch();

        if($dane4 == false) {
            throw new Exception("Podany login nie istnieje.");
        } else {
            if (!password_verify($password, $dane4['password'])) {
                throw new Exception("Nieprawidłowe hasło.");
            } else {
                $_SESSION['czy_zalogowany'] = 1;
                header("Location: index.php");
                exit();
            }
        }
    } catch(Exception $e) {
        echo "Błąd: " . $e->getMessage();
    }

} else {
    echo '<form method="post" action="login.php">
            <label>Nazwa użytkownika:</label>
            <input type="text" name="login"/>
            <label>Hasło:</label>
            <input type="password" name="password"/>
            <button class="przycisk" type="submit" name="wyslij" value="logowanie">Zaloguj</button>
      </form>';
}
require('stopka.php');
?>

