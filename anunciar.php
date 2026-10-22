<?php
session_start();
require_once "conexao.php";
require_once "UsuarioDAO.php";
require_once "VeiculoDAO.php";

function esc($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, "UTF-8");
}
function campo($nome) {
    return isset($_POST[$nome]) && is_string($_POST[$nome]) ? trim($_POST[$nome]) : "";
}

if (empty($_SESSION["token_formulario"])) {
    $_SESSION["token_formulario"] = bin2hex(random_bytes(24));
}

$usuarioDAO = new UsuarioDAO($conexao);
$veiculoDAO = new VeiculoDAO($conexao);
$usuarios = $usuarioDAO->listar();
$categorias = ["Hatches", "Sedãs", "SUVs", "Picapes", "Esportivos", "Clássicos", "Carros"];
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $token = campo("token_formulario");
    $id_usuario = filter_var(campo("id_usuario"), FILTER_VALIDATE_INT);
    $marca = campo("marca");
    $modelo = campo("modelo");
    $categoria = campo("categoria");
    $ano = filter_var(campo("ano"), FILTER_VALIDATE_INT);
    $preco = campo("preco");
    $quilometragem = filter_var(campo("quilometragem"), FILTER_VALIDATE_INT);
    $cidade = campo("cidade");
    $uf = strtoupper(campo("uf"));
    $descricao = campo("descricao");
    $foto_url = campo("foto_url");

    if (!hash_equals($_SESSION["token_formulario"], $token)) {
        $erro = "Formulário expirado. Atualize a página e tente novamente.";
    } elseif (!$id_usuario || !$usuarioDAO->buscarPorId($id_usuario)) {
        $erro = "Escolha um anunciante válido.";
    } elseif ($marca === "" || $modelo === "" || $cidade === "" || $uf === "") {
        $erro = "Preencha os campos obrigatórios.";
    } elseif (strlen($marca) > 60 || strlen($modelo) > 90 || strlen($cidade) > 80 || strlen($descricao) > 3000) {
        $erro = "Um dos textos ultrapassou o limite permitido.";
    } elseif (!in_array($categoria, $categorias, true)) {
        $erro = "Selecione uma categoria válida.";
    } elseif (!$ano || $ano < 1900 || $ano > (int) date("Y") + 1) {
        $erro = "Informe um ano válido.";
    } elseif (!is_numeric($preco) || (float) $preco <= 0 || (float) $preco > 999999999) {
        $erro = "Informe um preço válido.";
    } elseif ($quilometragem === false || $quilometragem < 0) {
        $erro = "Informe uma quilometragem válida.";
    } elseif (!preg_match("/^[A-Z]{2}$/", $uf)) {
        $erro = "Informe a sigla do estado, por exemplo RS.";
    } elseif ($foto_url !== "" && (strlen($foto_url) > 500 || !filter_var($foto_url, FILTER_VALIDATE_URL) || parse_url($foto_url, PHP_URL_SCHEME) !== "https")) {
        $erro = "Informe um link de foto HTTPS válido ou deixe vazio.";
    } else {
        try {
            $id = $veiculoDAO->inserir($id_usuario, $marca, $modelo, $ano, $preco, $quilometragem, $cidade, $uf, $descricao, $categoria, $foto_url);
            header("Location: anuncio.php?id=" . $id);
            exit;
        } catch (PDOException $excecao) {
            $erro = "Não foi possível cadastrar. Confira os dados e tente novamente.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar anúncio | Bruno e Jean - Projeto Semestre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div class="topbar-left">
            <a class="brand-icon" href="index.php">BJ</a>
            <a class="brand-text" href="index.php">Bruno e Jean - Projeto Semestre</a>
        </div>
        <nav class="topbar-nav" aria-label="Navegação principal">
            <a class="topbar-tab" href="index.php"><span class="tab-ico">⌂</span><span>Início</span></a>
            <a class="topbar-tab selected" href="index.php"><span class="tab-ico">▣</span><span>Veículos</span></a>
            <a class="topbar-tab" href="index.php?salvos=1"><span class="tab-ico">♡</span><span>Salvos</span></a>
        </nav>
        <div class="topbar-right"><a class="top-create" href="index.php">← Voltar</a><div class="user-avatar">BJ</div></div>
    </header>

    <main class="form-page">
        <div class="form-wrapper">
            <h1>Criar novo anúncio</h1>
            <p>Publique um veículo na vitrine do projeto. Nesta versão de aula, você escolhe um dos usuários de teste como anunciante.</p>
            <?php if ($erro !== "") { ?><div class="form-alert" role="alert"><?php echo esc($erro); ?></div><?php } ?>
            <form method="post" action="anunciar.php">
                <input type="hidden" name="token_formulario" value="<?php echo esc($_SESSION["token_formulario"]); ?>">
                <div class="form-grid">
                    <div class="form-row full">
                        <label for="id_usuario">Anunciante *</label>
                        <select name="id_usuario" id="id_usuario" required>
                            <option value="">Selecione um usuário</option>
                            <?php foreach ($usuarios as $usuario) { ?>
                                <option value="<?php echo (int) $usuario["id_usuario"]; ?>" <?php echo campo("id_usuario") === (string) $usuario["id_usuario"] ? "selected" : ""; ?>><?php echo esc($usuario["nome"]); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-row"><label for="marca">Marca *</label><input name="marca" id="marca" maxlength="60" required placeholder="Ex.: Volkswagen" value="<?php echo esc(campo("marca")); ?>"></div>
                    <div class="form-row"><label for="modelo">Modelo *</label><input name="modelo" id="modelo" maxlength="90" required placeholder="Ex.: Golf GTI" value="<?php echo esc(campo("modelo")); ?>"></div>
                    <div class="form-row"><label for="categoria">Categoria *</label>
                        <select id="categoria" name="categoria" required>
                            <?php foreach ($categorias as $item) { ?><option value="<?php echo esc($item); ?>" <?php echo campo("categoria") === $item ? "selected" : ""; ?>><?php echo esc($item); ?></option><?php } ?>
                        </select>
                    </div>
                    <div class="form-row"><label for="ano">Ano *</label><input type="number" name="ano" id="ano" min="1900" max="<?php echo (int) date("Y") + 1; ?>" placeholder="2020" required value="<?php echo esc(campo("ano")); ?>"></div>
                    <div class="form-row"><label for="preco">Preço (R$) *</label><input type="number" name="preco" id="preco" min="1" max="999999999" step="0.01" placeholder="80000" required value="<?php echo esc(campo("preco")); ?>"></div>
                    <div class="form-row"><label for="quilometragem">Quilometragem *</label><input type="number" name="quilometragem" id="quilometragem" min="0" placeholder="65000" required value="<?php echo esc(campo("quilometragem")); ?>"></div>
                    <div class="form-row"><label for="cidade">Cidade *</label><input name="cidade" id="cidade" maxlength="80" required placeholder="Lajeado" value="<?php echo esc(campo("cidade")); ?>"></div>
                    <div class="form-row"><label for="uf">Estado (sigla) *</label><input name="uf" id="uf" minlength="2" maxlength="2" required placeholder="RS" value="<?php echo esc(campo("uf")); ?>"></div>
                    <div class="form-row full"><label for="foto_url">Link da imagem (opcional)</label><input type="url" name="foto_url" id="foto_url" maxlength="500" placeholder="https://..." value="<?php echo esc(campo("foto_url")); ?>"></div>
                    <div class="form-row full"><label for="descricao">Descrição</label><textarea rows="4" maxlength="3000" name="descricao" id="descricao" placeholder="Condição do carro, opcionais, observações..."><?php echo esc(campo("descricao")); ?></textarea></div>
                </div>
                <button class="form-submit" type="submit">Publicar anúncio</button>
            </form>
        </div>
    </main>
</body>
</html>
