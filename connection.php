<?php

try {
    $conn = new PDO("mysql:host=localhost; dbname=tutor_php; charset=utf8", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Lỗi kết nối dữ liệu: " . $e->getMessage();
}
?>
