<?php
require_once "conexao.php";
require_once "VeiculoDAO.php";
$dao = new VeiculoDAO($conexao);
$veiculos = $dao->listar();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Bruno e Jean - Projeto Semestre</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<h2>Bruno e Jean - Projeto Semestre</h2>
<nav><a href="index.php">Início</a> | <a href="anunciar.php">Cadastrar veículo</a> | <a href="usuarios.php">Usuários</a></nav>
</header>
<main>
<h1>Veículos à venda</h1>
<p>Projeto de aula - anúncios de exemplo</p>
<?php if (count($veiculos) == 0) { echo "<p>Nenhum veículo cadastrado ainda.</p>"; } ?>
<div class="lista">
<?php foreach ($veiculos as $veiculo) { ?>
<div class="card">
<div class="foto">🚗</div>
<h3><?php echo htmlspecialchars($veiculo["marca"] . " " . $veiculo["modelo"]); ?></h3>
<p>Ano: <?php echo $veiculo["ano"]; ?></p>
<p>Vendedor: <?php echo htmlspecialchars($veiculo["nome"]); ?></p>
<h2>R$ <?php echo number_format($veiculo["preco"], 2, ",", "."); ?></h2>
<a href="anuncio.php?id=<?php echo $veiculo["id_veiculo"]; ?>">Ver detalhes</a>
</div>
<?php } ?>
</div>
</main>
</body>
</html>
