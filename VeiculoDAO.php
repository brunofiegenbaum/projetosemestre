<?php
class VeiculoDAO {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function inserir($id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $categoria = "Carros", $foto_url = "") {
        $sql = "INSERT INTO veiculos
                (id_usuario, marca, modelo, ano, preco, quilometragem, cidade, uf, descricao, categoria, foto_url)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $categoria, $foto_url]);
        return $this->conexao->lastInsertId();
    }

    public function listar($busca = "", $precoMin = null, $precoMax = null, $categoria = "", $ordem = "recentes", $cidade = "") {
        $sql = "SELECT veiculos.*, usuarios.nome AS nome_usuario
                FROM veiculos INNER JOIN usuarios ON veiculos.id_usuario = usuarios.id_usuario
                WHERE veiculos.status = 'disponivel'";
        $dados = [];

        if ($busca != "") {
            $sql .= " AND (veiculos.marca LIKE ? OR veiculos.modelo LIKE ?)";
            $dados[] = "%" . $busca . "%";
            $dados[] = "%" . $busca . "%";
        }
        if ($precoMin !== null && $precoMin !== "") {
            $sql .= " AND veiculos.preco >= ?";
            $dados[] = $precoMin;
        }
        if ($precoMax !== null && $precoMax !== "") {
            $sql .= " AND veiculos.preco <= ?";
            $dados[] = $precoMax;
        }
        if ($categoria != "") {
            $sql .= " AND veiculos.categoria = ?";
            $dados[] = $categoria;
        }
        if ($cidade != "") {
            $sql .= " AND veiculos.cidade LIKE ?";
            $dados[] = "%" . $cidade . "%";
        }

        switch ($ordem) {
            case "menor_preco":
                $sql .= " ORDER BY veiculos.preco ASC";
                break;
            case "maior_preco":
                $sql .= " ORDER BY veiculos.preco DESC";
                break;
            case "mais_novos":
                $sql .= " ORDER BY veiculos.ano DESC";
                break;
            case "mais_antigos":
                $sql .= " ORDER BY veiculos.ano ASC";
                break;
            default:
                $sql .= " ORDER BY veiculos.id_veiculo DESC";
        }

        $comando = $this->conexao->prepare($sql);
        $comando->execute($dados);
        return $comando->fetchAll();
    }

    public function buscarPorId($id) {
        $sql = "SELECT veiculos.*, usuarios.nome AS nome_usuario
                FROM veiculos INNER JOIN usuarios ON veiculos.id_usuario = usuarios.id_usuario
                WHERE veiculos.id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->fetch();
    }

    public function atualizar($id, $id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $categoria = "Carros", $foto_url = "") {
        $sql = "UPDATE veiculos SET id_usuario = ?, marca = ?, modelo = ?, ano = ?, preco = ?,
                quilometragem = ?, cidade = ?, uf = ?, descricao = ?, categoria = ?, foto_url = ?
                WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $categoria, $foto_url, $id]);
        return $comando->rowCount();
    }

    public function excluir($id) {
        $sql = "DELETE FROM veiculos WHERE id_veiculo = ?";
        $comando = $this->conexao->prepare($sql);
        $comando->execute([$id]);
        return $comando->rowCount();
    }
}
