<?php
// Configurações do MySQL no XAMPP
$servidor = "localhost";
$banco = "projetosemestre";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $erro) {
    http_response_code(500);
    die("Erro ao conectar ao banco. Verifique MySQL, banco.sql e conexao.php.");
}
