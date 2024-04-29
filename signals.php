<?php
try {
    $conn = new PDO("sqlite:stus.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['akcja']) && ($_GET['akcja'] == 'zal' || $_GET['akcja'] == 'wyl')) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $akcja = $_GET['akcja'] == 'zal' ? 'Załączenie' : 'Wyłączenie';

            $sql_update = "UPDATE signal SET value = :value WHERE id = :id";
            $stmt_update = $conn->prepare($sql_update);
            $value = $_GET['akcja'] == 'zal' ? 1 : 0;
            $stmt_update->bindParam(':value', $value, PDO::PARAM_INT);
            $stmt_update->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_update->execute();

            $sql_signal = "SELECT * FROM signal WHERE id = :id";
            $stmt_signal = $conn->prepare($sql_signal);
            $stmt_signal->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt_signal->execute();
            $signal_info = $stmt_signal->fetch(PDO::FETCH_ASSOC);

            $sql_signal2 = "SELECT * FROM device WHERE id = :id";
            $stmt_signal2 = $conn->prepare($sql_signal2);
            $stmt_signal2->bindParam(':id', $signal_info['nrdevice'], PDO::PARAM_INT);
            $stmt_signal2->execute();
            $signal_info2 = $stmt_signal2->fetch(PDO::FETCH_ASSOC);

            $sql_max = 'SELECT MAX(id) AS max_id FROM register';
            $st_max = $conn->prepare($sql_max);
            $st_max->execute();
            $wynik = $st_max->fetch(PDO::FETCH_ASSOC);
            $max_id = $wynik['max_id'];
            $new_id = $max_id + 1;

            $sql_register = "INSERT INTO register (id, sygnal_name, device_name, value, time) VALUES (:id, :sygnal_name, :device_name, :value, DATETIME('now'))";
            $stmt_register = $conn->prepare($sql_register);
            $stmt_register->bindParam(':id', $new_id, PDO::PARAM_INT);
            $stmt_register->bindParam(':sygnal_name', $signal_info['signal'], PDO::PARAM_STR);
            $stmt_register->bindParam(':device_name', $signal_info2['device'], PDO::PARAM_STR);
            $stmt_register->bindParam(':value', $value, PDO::PARAM_INT);
            $stmt_register->execute();

            header("Location: index.php");
            exit();
        }
    }

    if (isset($_GET['id'])) {
        $id_urzadzenia = $_GET['id'];
        $sql = "SELECT * FROM signal WHERE nrdevice = :id_urzadzenia";
        $st = $conn->prepare($sql);
        $st->bindParam(':id_urzadzenia', $id_urzadzenia, PDO::PARAM_INT);
        $st->execute();
        $dane2 = $st->fetchAll(PDO::FETCH_ASSOC);

        echo '<table class="tablicaindex">';
        echo '<tr>
                        <th>Id</th>
                        <th>Nazwa sygnału</th>
                        <th>Nr urządzenia</th>
                        <th>Wartość</th>';
        if(isset($_SESSION['czy_zalogowany'])) {
            echo '
                        <th>Załączenie</th>
                        <th>Wyłączenie</th>
                        <th>Usunięcie</th>';
            }
        echo '</tr>';

        foreach ($dane2 as $signal) {
            echo '<tr>';
            echo '<td>' . $signal['id'] . '</td>';
            if(isset($_SESSION['czy_zalogowany'])) {
                echo '<td><a class="linkb" href="edycjasignal.php?id=' . $signal['id'] . '">' . $signal['signal'] . '</a></td>';
            }
            echo '<td>' . $signal['nrdevice'] . '</td>';
            echo '<td>' . $signal['value'] . '</td>';
            if(isset($_SESSION['czy_zalogowany'])) {
                echo '<td><button class="przycisk"><a class="linkprzycisk" href="signals.php?akcja=zal&id=' . $signal['id'] . '">Zał.</a></button></td>';
                echo '<td><button class="przycisk"><a class="linkprzycisk" href="signals.php?akcja=wyl&id=' . $signal['id'] . '">Wył.</a></button></td>';
                echo '<td><button class="przycisk"><a class="linkprzycisk" href="usunsignal.php?id=' . $signal['id'] . '">Usuń</a></button></td>';
            }
            echo '</tr>';
        }
        echo '</table>';
        if(isset($_SESSION['czy_zalogowany'])) {
            echo '<div style="margin-top: 15px;"><button style="min-width: 200px;" class="przycisk"><a class="linkprzycisk" href="dodajsygnal.php">Dodaj sygnał</a></button></div>';
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
