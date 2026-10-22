<?php
// Configurações do banco de dados (XAMPP: root e senha vazia).
$servidor = "localhost";
$banco = "oficina";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    die("Não foi possível conectar ao banco. Confira o MySQL e o arquivo conexao.php.");
}
