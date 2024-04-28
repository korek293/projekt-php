<?php
function usun_wiersz($sql, $params) {
    $conn = new PDO("sqlite:stus.db");
    $st = $conn->prepare($sql);
    $st->execute($params);
    $conn = null;
}

if(isset($_GET['id'])) {
    usun_wiersz('DELETE FROM device WHERE id=:id', array(':id'=>$_GET['id']));
    header('Location: index.php');
    exit();
}
?>
