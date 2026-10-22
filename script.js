// Favoritos armazenados somente no navegador (não exigem login nesta etapa).
(function () {
    var chave = "bruno_jean_favoritos";

    function lerSalvos() {
        try {
            var dados = JSON.parse(localStorage.getItem(chave) || "[]");
            return Array.isArray(dados) ? dados.map(String) : [];
        } catch (erro) {
            return [];
        }
    }

    function gravarSalvos(lista) {
        try {
            localStorage.setItem(chave, JSON.stringify(lista));
        } catch (erro) {
            // O site pode continuar funcionando mesmo se o navegador bloquear o storage.
        }
    }

    function atualizarFavoritos() {
        var salvos = lerSalvos();
        var paginaSalvos = document.body.dataset.salvos === "1";
        var encontrados = 0;

        document.querySelectorAll(".listing").forEach(function (card) {
            var id = card.dataset.id;
            var salvo = salvos.includes(id);
            var botao = card.querySelector(".save-card");
            if (botao) {
                botao.textContent = salvo ? "♥" : "♡";
                botao.classList.toggle("saved", salvo);
                botao.setAttribute("aria-label", salvo ? "Remover anúncio dos salvos" : "Salvar anúncio");
                botao.setAttribute("aria-pressed", salvo ? "true" : "false");
            }
            card.hidden = paginaSalvos && !salvo;
            if (!card.hidden) encontrados++;
        });

        var vazio = document.getElementById("empty-saved");
        if (vazio) vazio.hidden = !paginaSalvos || encontrados > 0;

        if (paginaSalvos) {
            var contador = document.querySelector(".results-title strong");
            var total = document.querySelector(".results-title span");
            if (contador) contador.textContent = "Favoritos";
            if (total) total.textContent = " · " + encontrados + " resultados";
            var indicacao = document.querySelector(".listing-total");
            if (indicacao) indicacao.textContent = encontrados + " anúncios";
        }
    }

    document.querySelectorAll("[data-save]").forEach(function (botao) {
        botao.addEventListener("click", function () {
            var id = String(botao.dataset.save);
            var salvos = lerSalvos();
            if (salvos.includes(id)) {
                salvos = salvos.filter(function (item) { return item !== id; });
            } else {
                salvos.push(id);
            }
            gravarSalvos(salvos);
            atualizarFavoritos();
        });
    });

    var toggle = document.querySelector(".mobile-filter-toggle");
    var sidebar = document.querySelector(".sidebar");
    if (toggle && sidebar) {
        toggle.addEventListener("click", function () {
            var aberto = sidebar.classList.toggle("mobile-open");
            toggle.setAttribute("aria-expanded", aberto ? "true" : "false");
            toggle.textContent = aberto ? "× Fechar filtros" : "☷ Filtros";
            if (aberto) sidebar.scrollIntoView({ behavior: "smooth" });
        });
    }

    atualizarFavoritos();
})();
