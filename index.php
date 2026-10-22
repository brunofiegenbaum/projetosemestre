<?php
require_once "conexao.php";
require_once "VeiculoDAO.php";

$veiculoDAO = new VeiculoDAO($conexao);
$busca = isset($_GET["busca"]) && is_string($_GET["busca"]) ? trim($_GET["busca"]) : "";
$busca = substr($busca, 0, 80);
$veiculos = $veiculoDAO->listar($busca);

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
    <meta name="description" content="RUA. Uma nova forma de encontrar o seu próximo carro.">
    <title>RUA. — Compra e venda de veículos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="site-header">
        <div class="container header-content">
            <a class="logo" href="index.php" aria-label="RUA, início">rua<span>.</span></a>
            <nav aria-label="Menu principal">
                <a class="nav-link active" href="index.php">Início</a>
                <a class="nav-link" href="#anuncios">Explorar</a>
            </nav>
            <span class="header-soon">Anunciar <span>em breve</span></span>
        </div>
    </header>

    <main>
        <section class="hero container">
            <div class="hero-copy">
                <div class="eyebrow"><span class="eyebrow-dot"></span> FEITO PARA QUEM VIVE A ESTRADA</div>
                <h1>O próximo capítulo começa <em>na direção.</em></h1>
                <p>Do primeiro carro ao próximo sonho. Explore anúncios de veículos em um lugar simples, direto e sem enrolação.</p>
                <a href="#anuncios" class="button-primary">Explorar veículos <span aria-hidden="true">↗</span></a>
                <div class="hero-footnote">AUTOS / CULTURA / LIBERDADE <span>01 — 26</span></div>
            </div>
            <div class="hero-visual" aria-hidden="true">
                <div class="hero-visual-top"><span>RUA / GARAGEM</span><span>VOL. 01</span></div>
                <div class="hero-glow"></div>
                <svg class="hero-car" viewBox="0 0 600 250" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M61 174L107 159L167 94C181 79 201 70 230 68H397C426 68 443 79 461 98L509 148L544 158L563 179V198H530M91 198H65V179" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M177 102H392C411 102 423 108 436 124L456 148H132L177 102Z" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
                    <path d="M306 102V148M143 160H446M91 198H530" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    <circle cx="143" cy="197" r="31" fill="#101410" stroke="currentColor" stroke-width="4"/>
                    <circle cx="143" cy="197" r="13" stroke="currentColor" stroke-width="3"/>
                    <circle cx="479" cy="197" r="31" fill="#101410" stroke="currentColor" stroke-width="4"/>
                    <circle cx="479" cy="197" r="13" stroke="currentColor" stroke-width="3"/>
                    <path d="M543 163H558M70 169H90" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
                </svg>
                <div class="hero-visual-bottom"><span>ESCOLHA SEU CAMINHO.</span><span>↗</span></div>
            </div>
        </section>

        <section class="listings" id="anuncios">
            <div class="container">
                <div class="section-top">
                    <div>
                        <span class="section-kicker">O QUE TEM NA GARAGEM</span>
                        <h2>Encontre sua próxima máquina<span>.</span></h2>
                    </div>
                    <p>Seleção de anúncios de demonstração</p>
                </div>

                <form class="search-bar" method="get" action="index.php">
                    <label for="busca">BUSCAR VEÍCULO</label>
                    <div class="search-input-row">
                        <input id="busca" name="busca" type="search" maxlength="80" placeholder="Marca ou modelo. Ex.: Golf, Civic, Volkswagen..." value="<?php echo texto($busca); ?>">
                        <button type="submit">Buscar <span aria-hidden="true">↗</span></button>
                    </div>
                </form>

                <div class="results-heading">
                    <span><?php echo count($veiculos); ?> veículos encontrados</span>
                    <?php if ($busca !== "") { ?>
                        <a href="index.php#anuncios">Limpar busca ×</a>
                    <?php } else { ?>
                        <span class="results-muted">EXPLORAR / 2026</span>
                    <?php } ?>
                </div>

                <?php if (count($veiculos) === 0) { ?>
                    <div class="empty-state">
                        <h3>Nenhum carro por aqui.</h3>
                        <p>Tente outra marca ou modelo para encontrar anúncios.</p>
                        <a href="index.php#anuncios" class="button-primary">Ver todos os anúncios ↗</a>
                    </div>
                <?php } else { ?>
                    <div class="vehicle-grid">
                        <?php foreach ($veiculos as $veiculo) { ?>
                            <a class="vehicle-card" href="anuncio.php?id=<?php echo (int) $veiculo["id_veiculo"]; ?>">
                                <div class="vehicle-image theme-<?php echo (int) $veiculo["id_veiculo"] % 5; ?>">
                                    <span class="card-image-tag">RUA / AUTO</span>
                                    <svg class="card-car" viewBox="0 0 320 130" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M30 89L55 79L91 43L107 36H208L230 43L255 76L286 85L294 96V108H271M49 108H27V97" stroke="currentColor" stroke-width="3" stroke-linejoin="round"/>
                                        <path d="M105 49H206L221 77H77L105 49Z" stroke="currentColor" stroke-width="2"/>
                                        <path d="M159 49V77" stroke="currentColor" stroke-width="2"/>
                                        <circle cx="76" cy="108" r="17" fill="#161b1c" stroke="currentColor" stroke-width="3"/>
                                        <circle cx="241" cy="108" r="17" fill="#161b1c" stroke="currentColor" stroke-width="3"/>
                                    </svg>
                                    <span class="card-image-arrow">↗</span>
                                </div>
                                <div class="vehicle-content">
                                    <div class="vehicle-meta"><span><?php echo texto($veiculo["marca"]); ?></span><span><?php echo (int) $veiculo["ano"]; ?></span></div>
                                    <h3><?php echo texto($veiculo["marca"] . " " . $veiculo["modelo"]); ?></h3>
                                    <strong class="vehicle-price"><?php echo reais($veiculo["preco"]); ?></strong>
                                    <div class="vehicle-bottom">
                                        <span><?php echo number_format($veiculo["quilometragem"], 0, ",", "."); ?> km</span>
                                        <span><?php echo texto($veiculo["cidade"] . " / " . $veiculo["uf"]); ?></span>
                                    </div>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <div class="container footer-content">
            <a class="logo" href="index.php">rua<span>.</span></a>
            <span>UMA NOVA FORMA DE ENCONTRAR SEU PRÓXIMO CARRO.</span>
            <span>PROJETO DO SEMESTRE · UNIVATES · 2026</span>
        </div>
    </footer>
</body>
</html>
