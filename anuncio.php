<?php
require_once "conexao.php";
require_once "VeiculoDAO.php";

function esc($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}
function dinheiro($valor) {
    return "R$ " . number_format((float) $valor, 0, ",", ".");
}

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$dao = new VeiculoDAO($conexao);
$veiculo = $id ? $dao->buscarPorId($id) : false;
if (!$veiculo || $veiculo["status"] !== "disponivel") {
    $veiculo = false;
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $veiculo ? esc($veiculo["marca"] . " " . $veiculo["modelo"]) . " | " : ""; ?>Bruno e Jean - Projeto Semestre</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body>
    <header class="topbar">
        <div class="topbar-left">
            <a href="index.php" class="brand-icon" aria-label="Página inicial">BJ</a>
            <a href="index.php" class="brand-text">Bruno e Jean - Projeto Semestre</a>
        </div>
        <nav class="topbar-nav" aria-label="Navegação principal">
            <a class="topbar-tab" href="index.php"><span class="tab-ico">⌂</span><span>Início</span></a>
            <a class="topbar-tab selected" href="index.php"><span class="tab-ico">▣</span><span>Veículos</span></a>
            <a class="topbar-tab" href="index.php?salvos=1"><span class="tab-ico">♡</span><span>Salvos</span></a>
        </nav>
        <div class="topbar-right">
            <a class="top-create" href="anunciar.php">+ <span>Criar anúncio</span></a>
            <div class="user-avatar">BJ</div>
        </div>
    </header>
    <main class="detail-page">
        <div class="detail-shell">
            <a href="index.php" class="back-link">← Voltar ao Marketplace</a>
            <?php if (!$veiculo) { ?>
                <div class="market-empty">
                    <h3>Este anúncio não está disponível.</h3>
                    <p>Confira outros veículos no Marketplace.</p>
                    <a href="index.php">Ver anúncios</a>
                </div>
            <?php } else { ?>
                <div class="detail-layout">
                    <div>
                        <div class="detail-photo">
                            <?php if (!empty($veiculo["foto_url"])) { ?>
                                <img src="<?php echo esc($veiculo["foto_url"]); ?>" alt="Fotografia ilustrativa do anúncio" onerror="this.classList.add('image-failed')">
                            <?php } ?>
                        </div>
                        <p class="photo-note">Imagens ilustrativas de demonstração. Não representam necessariamente o veículo anunciado.</p>
                    </div>
                    <section class="detail-info">
                        <h1><?php echo esc($veiculo["marca"] . " " . $veiculo["modelo"] . " " . $veiculo["ano"]); ?></h1>
                        <div class="detail-price"><?php echo dinheiro($veiculo["preco"]); ?></div>
                        <p class="detail-location">📍 <?php echo esc($veiculo["cidade"] . ", " . $veiculo["uf"]); ?> · Anúncio de demonstração</p>
                        <div class="detail-action">
                            <a href="index.php">Ver outros anúncios</a>
                            <button type="button" class="primary" data-save="<?php echo (int) $veiculo["id_veiculo"]; ?>" aria-label="Salvar anúncio">♡ Salvar</button>
                        </div>
                        <div class="detail-divider"></div>
                        <h2>Detalhes do veículo</h2>
                        <div class="detail-facts">
                            <div><span>Marca</span><strong><?php echo esc($veiculo["marca"]); ?></strong></div>
                            <div><span>Modelo</span><strong><?php echo esc($veiculo["modelo"]); ?></strong></div>
                            <div><span>Ano</span><strong><?php echo (int) $veiculo["ano"]; ?></strong></div>
                            <div><span>Quilometragem</span><strong><?php echo number_format((int) $veiculo["quilometragem"], 0, ",", "."); ?> km</strong></div>
                            <div><span>Categoria</span><strong><?php echo esc($veiculo["categoria"]); ?></strong></div>
                            <div><span>Localização</span><strong><?php echo esc($veiculo["cidade"] . "/" . $veiculo["uf"]); ?></strong></div>
                        </div>
                        <div class="detail-divider"></div>
                        <h2>Descrição</h2>
                        <p class="detail-description"><?php echo nl2br(esc($veiculo["descricao"] ?: "Sem descrição disponível.")); ?></p>
                        <div class="detail-divider"></div>
                        <h2>Informações do vendedor</h2>
                        <div class="seller">
                            <div class="seller-avatar"><?php echo esc(mb_substr($veiculo["nome_usuario"], 0, 1, "UTF-8")); ?></div>
                            <div><strong><?php echo esc($veiculo["nome_usuario"]); ?></strong><span>Usuário de demonstração</span></div>
                        </div>
                        <div class="seller-notice">Este é um projeto acadêmico. Os dados dos anúncios e vendedores são fictícios; não envie dinheiro nem tente contatar esses números.</div>
                    </section>
                </div>
            <?php } ?>
        </div>
    </main>
</body>
</html>
