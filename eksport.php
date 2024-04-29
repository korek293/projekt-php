<?php
require("naglowek.php");
require("menu.php");

echo '<div>';
echo '<p style="font-weight: bold; font-size: 18px; margin-bottom: 20px;">Proszę wybrać okres eksportowania danych:</p>';
echo '<form method="post">';
echo '<button style="min-width: 200px; margin-right: 20px;" class="przycisk" name="period" value="last_day">Eksportuj ostatni dzień</button>';
echo '<button style="min-width: 200px; margin-right: 20px;" class="przycisk" name="period" value="last_week">Eksportuj ostatni tydzień</button>';
echo '<button style="min-width: 200px;" class="przycisk" name="period" value="all">Eksportuj wszystko</button>';
echo '</form>';
echo '</div>';

function pobierz_dane($conn, $period) {
    $sql = '';
    switch ($period) {
        case 'last_day':
            $sql = 'SELECT * FROM register WHERE time >= DATE("now", "-1 day")';
            break;
        case 'last_week':
            $sql = 'SELECT * FROM register WHERE time >= DATE("now", "-7 day")';
            break;
        case 'all':
        default:
            $sql = 'SELECT * FROM register';
            break;
    }

    $st = $conn->prepare($sql);
    $st->execute();
    return $st->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['period'])) {
    $period = $_POST['period'];
    $conn = new PDO("sqlite:stus.db");
    $data = pobierz_dane($conn, $period);
    $file_name = 'rejestr_' . $period . '.txt';
    $file_path = 'eksport/' . $file_name;
    $file = fopen($file_path, 'w');

    foreach ($data as $row) {
        $row_text = implode(', ', $row) . "\n";
        fwrite($file, $row_text);
    }

    fclose($file);

    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename=' . $file_name);
    readfile($file_path);
    exit();
}
?>
