<?php
// Configurações de acesso ao MySQL. Ajustar aqui se o XAMPP usar outra senha/porta.
$servidor = "localhost";
$banco = "rua_veiculos";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8mb4", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $erro) {
    // Não mostrar os dados de acesso em uma mensagem pública de erro.
    http_response_code(500);
    die("Erro ao conectar ao banco. Inicie o MySQL e confira o conexao.php.");
}
