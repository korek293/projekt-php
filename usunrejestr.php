<?php
try {
    $conn = new PDO("sqlite:stus.db");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql_clear = "DELETE FROM register";
    $stmt_clear = $conn->prepare($sql_clear);
    $stmt_clear->execute();

    header("Location: rejestr.php");
    exit();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
