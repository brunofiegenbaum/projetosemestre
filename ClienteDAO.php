<?php
class ClienteDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserir($nome, $telefone) {
        $sql = "INSERT INTO clientes (nome, telefone) VALUES (?, ?)";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$nome, $telefone]);
        return $this->conexao->lastInsertId();
    }

    public function listar() {
        $sql = "SELECT * FROM clientes ORDER BY id_cliente";
        $comando = $this->conexao->prepare($sql);
        $comando->execute();
        return $comando->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id_cliente = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch();
    }

    public function atualizar($id, $nome, $telefone) {
        $sql = "UPDATE clientes SET nome = ?, telefone = ? WHERE id_cliente = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$nome, $telefone, $id]);
        return $comando->rowCount();
    }

    public function excluir($id) {
        $sql = "DELETE FROM clientes WHERE id_cliente = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->rowCount();
    }
}
