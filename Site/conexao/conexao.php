<?php
$host = 'localhost';
$db   = 'u774820395_rgeats_bd'; //u774820395_rgeats_bd
$user = 'u774820395_rgeats'; //u774820395_rgeats
$pass = 'Rgeats2026!'; //Rgeats2026!

$conecta = mysqli_connect($host, $user, $pass, $db);

if (!$conecta) {
    die("Erro na conexão: " . mysqli_connect_error());
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\PDOException $e) {
    die(json_encode(["status" => "error", "message" => "Erro de conexão com o banco."]));
}
?>
