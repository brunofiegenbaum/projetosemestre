<?php
class VeiculoDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserir($id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao) {
        $sql = "INSERT INTO veiculos
                (id_usuario, marca, modelo, ano, preco, quilometragem, cidade, uf, descricao)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao]);
        return $this->conexao->lastInsertId();
    }

    public function listar($busca = "") {
        $sql = "SELECT veiculos.*, usuarios.nome AS nome_usuario
                FROM veiculos
                INNER JOIN usuarios ON veiculos.id_usuario = usuarios.id_usuario
                WHERE veiculos.status = 'disponivel'";

        if ($busca != "") {
            $sql .= " AND (veiculos.marca LIKE ? OR veiculos.modelo LIKE ?)";
        }

        $sql .= " ORDER BY veiculos.id_veiculo DESC";

        $comando = $this->conexao->prepare($sql);

        if ($busca != "") {
            $pesquisa = "%" . $busca . "%";
            $comando->execute([$pesquisa, $pesquisa]);
        } else {
            $comando->execute();
        }

        return $comando->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT veiculos.*, usuarios.nome AS nome_usuario
                FROM veiculos
                INNER JOIN usuarios ON veiculos.id_usuario = usuarios.id_usuario
                WHERE veiculos.id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch();
    }

    public function atualizar($id, $id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao) {
        $sql = "UPDATE veiculos
                SET id_usuario = ?, marca = ?, modelo = ?, ano = ?, preco = ?, quilometragem = ?,
                    cidade = ?, uf = ?, descricao = ?
                WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $id]);
        return $comando->rowCount();
    }

    public function excluir($id) {
        $sql = "DELETE FROM veiculos WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->rowCount();
    }
}
