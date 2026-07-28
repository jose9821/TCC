<?php
 $host = 'localhost';
 $db   = ''; //MUDAR PARA O NOME DO BANCO!!!
 $user = 'root'; 
 $pass = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (\PDOException $e) {

    die(json_encode(["status" => "error", "message" => "Erro de conexão com o banco."]));
}
?>