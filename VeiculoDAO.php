<?php
class VeiculoDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserir($id_cliente, $marca, $modelo, $ano, $placa) {
        $sql = "INSERT INTO veiculos (id_cliente, marca, modelo, ano, placa) VALUES (?, ?, ?, ?, ?)";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_cliente, $marca, $modelo, $ano, $placa]);
        return $this->conexao->lastInsertId();
    }

    public function listar() {
        $sql = "SELECT veiculos.*, clientes.nome AS nome_cliente
                FROM veiculos
                INNER JOIN clientes ON veiculos.id_cliente = clientes.id_cliente
                ORDER BY veiculos.id_veiculo";
        $comando = $this->conexao->prepare($sql);
        $comando->execute();
        return $comando->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM veiculos WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch();
    }

    public function atualizar($id, $id_cliente, $marca, $modelo, $ano, $placa) {
        $sql = "UPDATE veiculos SET id_cliente = ?, marca = ?, modelo = ?, ano = ?, placa = ?
                WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_cliente, $marca, $modelo, $ano, $placa, $id]);
        return $comando->rowCount();
    }

    public function excluir($id) {
        $sql = "DELETE FROM veiculos WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->rowCount();
    }
}
