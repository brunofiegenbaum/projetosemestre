<?php
require_once "conexao.php";
require_once "ClienteDAO.php";
require_once "VeiculoDAO.php";

header("Content-Type: text/plain; charset=utf-8");

$clienteDAO = new ClienteDAO($conexao);
$veiculoDAO = new VeiculoDAO($conexao);

echo "PROJETO DO SEMESTRE - OFICINA MECÂNICA\n";
echo "Teste da Sprint 1 (Banco + DAO)\n\n";

try {
    echo "1 - LISTAR CLIENTES\n";
    print_r($clienteDAO->listar());

    echo "\n2 - LISTAR VEÍCULOS (COM O NOME DO CLIENTE)\n";
    print_r($veiculoDAO->listar());

    // Os registros criados aqui são apenas para demonstrar os métodos.
    // No final, rollback desfaz tudo e mantém o banco com os 5 registros iniciais.
    $conexao->beginTransaction();

    echo "\n3 - INSERIR CLIENTE E VEÍCULO\n";
    $id_cliente = $clienteDAO->inserir("Cliente Teste", "(51) 99999-9999");
    $id_veiculo = $veiculoDAO->inserir($id_cliente, "Fiat", "Uno", 2002, "TST1E23");
    echo "Cliente criado: $id_cliente\n";
    echo "Veículo criado: $id_veiculo\n";

    echo "\n4 - BUSCAR POR ID\n";
    print_r($clienteDAO->buscarPorId($id_cliente));
    print_r($veiculoDAO->buscarPorId($id_veiculo));

    echo "\n5 - ATUALIZAR CLIENTE E VEÍCULO\n";
    $clienteDAO->atualizar($id_cliente, "Cliente Atualizado", "(51) 98888-8888");
    $veiculoDAO->atualizar($id_veiculo, $id_cliente, "Fiat", "Palio", 2003, "TST1E23");
    print_r($clienteDAO->buscarPorId($id_cliente));
    print_r($veiculoDAO->buscarPorId($id_veiculo));

    echo "\n6 - EXCLUIR VEÍCULO E CLIENTE\n";
    echo "Veículos excluídos: " . $veiculoDAO->excluir($id_veiculo) . "\n";
    echo "Clientes excluídos: " . $clienteDAO->excluir($id_cliente) . "\n";

    $conexao->rollBack();
    echo "\nTESTE CONCLUÍDO! As alterações do teste foram desfeitas.\n";
} catch (Exception $erro) {
    if ($conexao->inTransaction()) {
        $conexao->rollBack();
    }

    echo "\nErro ao executar teste: " . $erro->getMessage() . "\n";
}
