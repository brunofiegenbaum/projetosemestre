<?php
require_once "conexao.php";
require_once "VeiculoDAO.php";

$veiculoDAO = new VeiculoDAO($conexao);
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
$veiculo = $id ? $veiculoDAO->buscarPorId($id) : false;

if (!$veiculo || $veiculo["status"] !== "disponivel") {
    http_response_code(404);
}

function texto($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}

function reais($valor) {
    return "R$ " . number_format($valor, 2, ",", ".");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $veiculo ? texto($veiculo["marca"] . " " . $veiculo["modelo"]) : "Anúncio não encontrado"; ?> — RUA.</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="logo" href="index.php">rua<span>.</span></a>
            <nav aria-label="Menu principal">
                <a class="nav-link" href="index.php">Início</a>
                <a class="nav-link" href="index.php#anuncios">Explorar</a>
            </nav>
            <span class="header-soon">Anunciar <span>em breve</span></span>
        </div>
    </header>
    <main class="container detail-page">
        <a href="index.php#anuncios" class="back-link">← Voltar para anúncios</a>
        <?php if (!$veiculo || $veiculo["status"] !== "disponivel") { ?>
            <div class="empty-state">
                <h1>Anúncio não encontrado.</h1>
                <p>Este veículo não está disponível.</p>
                <a href="index.php#anuncios" class="button-primary">Ver outros veículos ↗</a>
            </div>
        <?php } else { ?>
            <div class="detail-heading">
                <div>
                    <span class="section-kicker">RUA / DETALHES DO ANÚNCIO</span>
                    <h1><?php echo texto($veiculo["marca"] . " " . $veiculo["modelo"]); ?><span>.</span></h1>
                    <p><?php echo texto($veiculo["cidade"] . " / " . $veiculo["uf"]); ?></p>
                </div>
                <strong><?php echo reais($veiculo["preco"]); ?></strong>
            </div>
            <div class="detail-grid">
                <div class="detail-main">
                    <div class="detail-illustration">
                        <span class="section-kicker">AUTO / <?php echo (int) $veiculo["ano"]; ?></span>
                        <svg viewBox="0 0 600 250" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Ilustração genérica de um automóvel" role="img">
                            <path d="M61 174L107 159L167 94C181 79 201 70 230 68H397C426 68 443 79 461 98L509 148L544 158L563 179V198H530M91 198H65V179" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M177 102H392C411 102 423 108 436 124L456 148H132L177 102Z" stroke="currentColor" stroke-width="3"/>
                            <path d="M306 102V148M143 160H446" stroke="currentColor" stroke-width="2"/>
                            <circle cx="143" cy="197" r="31" fill="#101410" stroke="currentColor" stroke-width="4"/>
                            <circle cx="479" cy="197" r="31" fill="#101410" stroke="currentColor" stroke-width="4"/>
                        </svg>
                        <small>IMAGEM ILUSTRATIVA · FOTOS REAIS EM UMA PRÓXIMA ETAPA</small>
                    </div>
                    <div class="detail-section">
                        <h2>Ficha do veículo</h2>
                        <div class="spec-grid">
                            <div><span>Marca</span><strong><?php echo texto($veiculo["marca"]); ?></strong></div>
                            <div><span>Modelo</span><strong><?php echo texto($veiculo["modelo"]); ?></strong></div>
                            <div><span>Ano</span><strong><?php echo (int) $veiculo["ano"]; ?></strong></div>
                            <div><span>Quilometragem</span><strong><?php echo number_format($veiculo["quilometragem"], 0, ",", "."); ?> km</strong></div>
                            <div><span>Cidade</span><strong><?php echo texto($veiculo["cidade"]); ?></strong></div>
                            <div><span>Estado</span><strong><?php echo texto($veiculo["uf"]); ?></strong></div>
                        </div>
                    </div>
                    <div class="detail-section">
                        <h2>Sobre o anúncio</h2>
                        <p><?php echo nl2br(texto($veiculo["descricao"] ?: "O anunciante ainda não informou uma descrição.")); ?></p>
                    </div>
                </div>
                <aside class="seller-panel">
                    <span class="section-kicker">ANUNCIANTE</span>
                    <h2><?php echo texto($veiculo["nome_usuario"]); ?></h2>
                    <p>O contato com o anunciante será implementado nas próximas sprints.</p>
                    <div class="seller-notice">Anúncio de demonstração. Não é uma oferta real.</div>
                    <a href="index.php#anuncios" class="button-primary">Continuar explorando ↗</a>
                </aside>
            </div>
        <?php } ?>
    </main>
    <footer class="site-footer">
        <div class="container footer-content">
            <a class="logo" href="index.php">rua<span>.</span></a>
            <span>SEU PRÓXIMO CARRO COMEÇA AQUI.</span>
            <span>PROJETO DO SEMESTRE · UNIVATES · 2026</span>
        </div>
    </footer>
</body>
</html>
