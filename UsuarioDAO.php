<?php
class UsuarioDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserir($nome, $email, $telefone) {
        $sql = "INSERT INTO usuarios (nome, email, telefone) VALUES (?, ?, ?)";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$nome, $email, $telefone]);
        return $this->conexao->lastInsertId();
    }

    public function listar() {
        $sql = "SELECT * FROM usuarios ORDER BY id_usuario";
        $comando = $this->conexao->prepare($sql);
        $comando->execute();
        return $comando->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch();
    }

    public function atualizar($id, $nome, $email, $telefone) {
        $sql = "UPDATE usuarios SET nome = ?, email = ?, telefone = ? WHERE id_usuario = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$nome, $email, $telefone, $id]);
        return $comando->rowCount();
    }

    public function excluir($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->rowCount();
    }
}
