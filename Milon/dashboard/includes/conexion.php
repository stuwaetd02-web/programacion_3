<?php
$host = "localhost";
$dbname = "milon_2025";
$user = "milon_admin";
$pass = "asucena1945.";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // No hacer echo aqui
} catch (PDOException $e) {
    die("Conexion fallida: " . $e->getMessage());
}
?>