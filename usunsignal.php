<?php
function usun_wiersz1($sql, $params) {
    $conn = new PDO("sqlite:stus.db");
    $st = $conn->prepare($sql);
    $st->execute($params);
    $conn = null;
}

if(isset($_GET['id'])) {
    usun_wiersz1('DELETE FROM signal WHERE id=:id', array(':id'=>$_GET['id']));
    header('Location: index.php');
    exit();
}
?>
