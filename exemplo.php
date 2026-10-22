<?php
require_once "conexao.php";
require_once "UsuarioDAO.php";
require_once "VeiculoDAO.php";

header("Content-Type: text/plain; charset=utf-8");

$usuarioDAO = new UsuarioDAO($conexao);
$veiculoDAO = new VeiculoDAO($conexao);

echo "BRUNO E JEAN - PROJETO SEMESTRE\n";
echo "SPRINT 1 - BANCO E DAO (MARKETPLACE DE VEÍCULOS)\n\n";

try {
    echo "1 - LISTAR USUÁRIOS\n";
    print_r($usuarioDAO->listar());

    echo "\n2 - LISTAR ANÚNCIOS COM O NOME DO USUÁRIO\n";
    print_r($veiculoDAO->listar());

    // Transação para não acumular anúncios de teste no banco.
    $conexao->beginTransaction();

    echo "\n3 - INSERIR USUÁRIO E VEÍCULO\n";
    $id_usuario = $usuarioDAO->inserir("Usuário Teste", "teste@exemplo.test", "(51) 90000-9999");
    $id_veiculo = $veiculoDAO->inserir($id_usuario, "Fiat", "Uno", 2012, 27000, 130000, "Lajeado", "RS", "Anúncio de teste");
    echo "ID usuário: $id_usuario\n";
    echo "ID veículo: $id_veiculo\n";

    echo "\n4 - BUSCAR POR ID\n";
    print_r($usuarioDAO->buscarPorId($id_usuario));
    print_r($veiculoDAO->buscarPorId($id_veiculo));

    echo "\n5 - ATUALIZAR OS DOIS REGISTROS\n";
    $usuarioDAO->atualizar($id_usuario, "Usuário Atualizado", "atualizado@exemplo.test", "(51) 90000-8888");
    $veiculoDAO->atualizar($id_veiculo, $id_usuario, "Fiat", "Palio", 2013, 29900, 120000, "Estrela", "RS", "Anúncio atualizado");
    print_r($usuarioDAO->buscarPorId($id_usuario));
    print_r($veiculoDAO->buscarPorId($id_veiculo));

    echo "\n6 - EXCLUIR VEÍCULO E DEPOIS O USUÁRIO\n";
    echo "Veículos excluídos: " . $veiculoDAO->excluir($id_veiculo) . "\n";
    echo "Usuários excluídos: " . $usuarioDAO->excluir($id_usuario) . "\n";

    $conexao->rollBack();
    echo "\nTUDO CERTO. As alterações do teste foram desfeitas.\n";
} catch (Exception $erro) {
    if ($conexao->inTransaction()) {
        $conexao->rollBack();
    }
    echo "\nErro no teste: " . $erro->getMessage() . "\n";
}
