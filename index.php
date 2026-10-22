<?php
require_once "conexao.php";
require_once "VeiculoDAO.php";

$veiculoDAO = new VeiculoDAO($conexao);

function esc($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}
function dinheiro($valor) {
    return "R$ " . number_format((float) $valor, 0, ",", ".");
}
function param($nome) {
    return isset($_GET[$nome]) && is_string($_GET[$nome]) ? trim($_GET[$nome]) : "";
}
function endereco($mudancas = []) {
    $filtros = [];
    foreach (["busca", "cidade", "min", "max", "categoria", "ordem", "salvos"] as $chave) {
        $valor = param($chave);
        if ($valor !== "") {
            $filtros[$chave] = $valor;
        }
    }
    foreach ($mudancas as $chave => $valor) {
        if ($valor === "") {
            unset($filtros[$chave]);
        } else {
            $filtros[$chave] = $valor;
        }
    }
    return "index.php" . (count($filtros) ? "?" . http_build_query($filtros) : "");
}

$busca = substr(param("busca"), 0, 80);
$cidade = substr(param("cidade"), 0, 80);
$min = param("min");
$max = param("max");
$min = $min !== "" && is_numeric($min) && $min >= 0 ? (float) $min : null;
$max = $max !== "" && is_numeric($max) && $max >= 0 ? (float) $max : null;
$categoria = param("categoria");
$categorias = ["Todos", "Hatches", "Sedãs", "SUVs", "Picapes", "Esportivos", "Clássicos"];
if (!in_array($categoria, $categorias, true)) {
    $categoria = "";
}
if ($categoria === "Todos") {
    $categoria = "";
}
$ordem = param("ordem");
$ordens = ["recentes", "menor_preco", "maior_preco", "mais_novos", "mais_antigos"];
if (!in_array($ordem, $ordens, true)) {
    $ordem = "recentes";
}
$salvos = param("salvos") === "1";
$veiculos = $veiculoDAO->listar($busca, $min, $max, $categoria, $ordem, $cidade);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bruno e Jean - Projeto Semestre. Plataforma de anúncios de veículos.">
    <title>Bruno e Jean - Projeto Semestre</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="script.js"></script>
</head>
<body data-salvos="<?php echo $salvos ? '1' : '0'; ?>">
    <header class="topbar">
        <div class="topbar-left">
            <a href="index.php" class="brand-icon" aria-label="Página inicial">BJ</a>
            <a href="index.php" class="brand-text">Bruno e Jean - Projeto Semestre</a>
        </div>
        <nav class="topbar-nav" aria-label="Navegação principal">
            <a href="index.php" class="topbar-tab <?php echo !$salvos ? 'selected' : ''; ?>" aria-label="Explorar anúncios" title="Explorar anúncios"><span class="tab-ico">⌂</span><span>Início</span></a>
            <a href="index.php" class="topbar-tab <?php echo !$salvos ? 'selected' : ''; ?>" aria-label="Veículos" title="Veículos"><span class="tab-ico">▣</span><span>Veículos</span></a>
            <a href="<?php echo esc(endereco(["salvos" => "1"])); ?>" class="topbar-tab <?php echo $salvos ? 'selected' : ''; ?>" aria-label="Anúncios salvos" title="Anúncios salvos"><span class="tab-ico">♡</span><span>Salvos</span></a>
        </nav>
        <div class="topbar-right">
            <a class="top-create" href="anunciar.php">+ <span>Criar anúncio</span></a>
            <div class="user-avatar" title="Projeto Bruno e Jean">BJ</div>
        </div>
    </header>

    <div class="layout">
        <aside class="sidebar">
            <div class="sidebar-heading">
                <div class="eyebrow">COMPRA E VENDA</div>
                <h1>Marketplace</h1>
            </div>
            <form action="index.php" method="get" class="filter-form" id="filter-form">
                <?php if ($salvos) { ?><input type="hidden" name="salvos" value="1"><?php } ?>
                <div class="sidebar-search">
                    <span class="search-symbol" aria-hidden="true">⌕</span>
                    <input name="busca" type="search" maxlength="80" placeholder="Pesquisar no Marketplace" aria-label="Pesquisar anúncios" value="<?php echo esc($busca); ?>">
                </div>

                <div class="sidebar-nav">
                    <a href="index.php" class="side-item <?php echo !$salvos ? 'active' : ''; ?>"><span class="side-icon">▣</span> Navegar por anúncios</a>
                    <a href="<?php echo esc(endereco(["salvos" => "1"])); ?>" class="side-item <?php echo $salvos ? 'active' : ''; ?>"><span class="side-icon">♡</span> Itens salvos</a>
                    <a href="anunciar.php" class="side-item"><span class="side-icon">＋</span> Anunciar veículo</a>
                </div>

                <a class="create-button" href="anunciar.php"><span>＋</span> Criar novo anúncio</a>

                <div class="sidebar-divider"></div>
                <div class="filter-heading"><h2>Filtros</h2><a href="<?php echo $salvos ? 'index.php?salvos=1' : 'index.php'; ?>">Limpar</a></div>
                <div class="location-hint"><span class="pin">●</span><span>Rio Grande do Sul · Brasil</span></div>

                <div class="filter-group">
                    <label for="cidade">Localização</label>
                    <input type="text" name="cidade" id="cidade" maxlength="80" placeholder="Cidade, ex.: Lajeado" value="<?php echo esc($cidade); ?>">
                </div>

                <div class="filter-group">
                    <span class="filter-label">Preço</span>
                    <div class="price-fields">
                        <input type="number" name="min" min="0" step="100" placeholder="Mín." aria-label="Preço mínimo" value="<?php echo $min !== null ? esc($min) : ''; ?>">
                        <span>até</span>
                        <input type="number" name="max" min="0" step="100" placeholder="Máx." aria-label="Preço máximo" value="<?php echo $max !== null ? esc($max) : ''; ?>">
                    </div>
                </div>

                <div class="filter-group">
                    <label for="categoria">Categoria</label>
                    <select name="categoria" id="categoria">
                        <?php foreach ($categorias as $item) { ?>
                            <option value="<?php echo $item === 'Todos' ? '' : esc($item); ?>" <?php echo (($item === "Todos" && $categoria === "") || $categoria === $item) ? "selected" : ""; ?>><?php echo esc($item); ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="ordem">Ordenar por</label>
                    <select name="ordem" id="ordem">
                        <option value="recentes" <?php echo $ordem === "recentes" ? "selected" : ""; ?>>Mais recentes</option>
                        <option value="menor_preco" <?php echo $ordem === "menor_preco" ? "selected" : ""; ?>>Menor preço</option>
                        <option value="maior_preco" <?php echo $ordem === "maior_preco" ? "selected" : ""; ?>>Maior preço</option>
                        <option value="mais_novos" <?php echo $ordem === "mais_novos" ? "selected" : ""; ?>>Ano mais novo</option>
                        <option value="mais_antigos" <?php echo $ordem === "mais_antigos" ? "selected" : ""; ?>>Ano mais antigo</option>
                    </select>
                </div>
                <button class="apply-button" type="submit">Aplicar filtros</button>
            </form>

            <div class="sidebar-bottom">
                <p>Trabalho acadêmico · anúncios demonstrativos</p>
                <p>© 2026 Bruno e Jean - Projeto Semestre</p>
            </div>
        </aside>

        <main class="market-content">
            <div class="content-top">
                <div>
                    <p class="section-eyebrow">VEÍCULOS À VENDA</p>
                    <h2><?php echo $salvos ? 'Seus anúncios salvos' : ($busca !== "" ? 'Resultados da pesquisa' : 'Sugestões para você'); ?></h2>
                </div>
                <button class="mobile-filter-toggle" type="button" aria-expanded="false">☷ Filtros</button><span class="listing-total"><?php echo count($veiculos); ?> anúncios</span>
            </div>
            <div class="category-scroll" aria-label="Filtrar por categoria">
                <?php foreach ($categorias as $item) {
                    $valor = $item === "Todos" ? "" : $item;
                ?>
                    <a href="<?php echo esc(endereco(["categoria" => $valor])); ?>" class="category-chip <?php echo $categoria === $valor ? 'active' : ''; ?>"><?php echo esc($item); ?></a>
                <?php } ?>
            </div>
            <div class="results-title">
                <div><strong><?php echo $salvos ? "Favoritos" : "Veículos disponíveis"; ?></strong><span> · <?php echo count($veiculos); ?> resultados</span></div>
                <span class="demo-label">Anúncios fictícios para demonstração</span>
            </div>

            <?php if (count($veiculos) === 0) { ?>
                <div class="market-empty"><h3>Nenhum anúncio encontrado</h3><p>Tente remover alguns filtros ou fazer uma nova busca.</p><a href="index.php">Ver todos os veículos</a></div>
            <?php } else { ?>
                <div class="market-grid" id="market-grid">
                    <?php foreach ($veiculos as $veiculo) { ?>
                        <article class="listing" data-id="<?php echo (int) $veiculo["id_veiculo"]; ?>">
                            <a href="anuncio.php?id=<?php echo (int) $veiculo["id_veiculo"]; ?>" class="listing-link" aria-label="Ver anúncio de <?php echo esc($veiculo["marca"] . " " . $veiculo["modelo"]); ?>">
                                <div class="listing-image">
                                    <?php if (!empty($veiculo["foto_url"])) { ?>
                                        <img loading="lazy" src="<?php echo esc($veiculo["foto_url"]); ?>" alt="Foto ilustrativa de automóvel" onerror="this.classList.add('image-failed')" />
                                    <?php } ?>
                                    <span class="listing-image-fallback">Sem foto disponível</span>
                                </div>
                                <div class="listing-details">
                                    <div class="listing-price"><?php echo dinheiro($veiculo["preco"]); ?></div>
                                    <h3><?php echo esc($veiculo["marca"] . " " . $veiculo["modelo"] . " " . $veiculo["ano"]); ?></h3>
                                    <p><?php echo esc($veiculo["cidade"] . ", " . $veiculo["uf"]); ?></p>
                                    <p class="listing-km"><?php echo number_format((int) $veiculo["quilometragem"], 0, ",", "."); ?> km · <?php echo esc($veiculo["categoria"]); ?></p>
                                </div>
                            </a>
                            <button type="button" class="save-card" data-save="<?php echo (int) $veiculo["id_veiculo"]; ?>" aria-label="Salvar anúncio" title="Salvar anúncio">♡</button>
                        </article>
                    <?php } ?>
                </div>
                <div class="market-empty" id="empty-saved" hidden>
                    <h3>Você ainda não salvou veículos.</h3>
                    <p>Toque no coração de um anúncio para guardar seus favoritos neste navegador.</p>
                    <a href="index.php">Explorar veículos</a>
                </div>
            <?php } ?>
        </main>
    </div>
</body>
</html>
