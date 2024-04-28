<style>
    .MENU {
        text-align: center;
        margin-bottom: 30px;
        display: flex;
        justify-content: center;
        background-color: #000000;
        height: 40px;
        width: 100%;
    }

    .menu1 {
        text-decoration: none;
        display: inline-block;
        padding: 10px 20px;
        margin-right: 10px;
        background-color: #000000;
        color: #fff;
        border-radius: 5px;
    }

    .menu1:hover {
        background-color: #444444;
    }
</style>

<div class="MENU">
    <a class="menu1" href="index.php">Lista Urządzeń</a>
    <a class="menu1" href="rejestr.php">Rejestr zdarzeń</a>
    <a class="menu1" href="dodajdevice.php">Dodaj urządzenie</a>
    <a class="menu1" href="dodajsygnal.php">Dodaj sygnał</a>
    <a class="menu1" href="login.php">Zaloguj się</a>
    <a class="menu1" href="logout.php">Wyloguj się</a>
<!--    --><?php
//    if(isset($_SESSION['czy_zalogowany']))
//        echo '<a class="menu1" href="dodajpracownika.php">Dodaj pracownika</a>';
//        echo '<a class="menu1" href="wyloguj.php">Wyloguj</a>';
//    ?>
</div>
<div class="kontener">
    <div class="GLOWNY">
        <div class="kontent">
