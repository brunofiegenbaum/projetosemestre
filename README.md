# Bruno e Jean - Projeto Semestre

**Disciplina:** Desenvolvimento de Aplicações para Internet — Univates (2026)  
**Integrantes:** Bruno Fiegenbaum e Jean (completar sobrenome).  
**Tema:** Marketplace de compra e venda de veículos.

O sistema foi inspirado no formato visual do Facebook Marketplace, com **modo escuro, barra superior, filtros no menu lateral, fotos e grade de anúncios**, mas usa o nome **Bruno e Jean - Projeto Semestre**.

## Sprint 1 — Banco de dados + DAO (22/10)

O projeto tem **exatamente 2 tabelas**, ligadas pela chave estrangeira:
- **usuarios:** id_usuario, nome, email, telefone.
- **veiculos:** id_veiculo, id_usuario (FOREIGN KEY), marca, modelo, categoria, ano, preco, quilometragem, cidade, uf, descricao, foto_url, status.

Um usuário pode publicar muitos veículos, mas cada veículo pertence a um usuário (relação **1:N**).

O arquivo `banco.sql` inclui **5 usuários** e **16 veículos de demonstração**. É permitido ter mais de cinco registros: o enunciado estabelece o **mínimo** de cinco em cada tabela. Dados e anúncios são fictícios; as fotos externas são meramente ilustrativas.

Os dois arquivos DAO (`UsuarioDAO.php` e `VeiculoDAO.php`) possuem:
- `inserir()`
- `listar()`
- `buscarPorId()`
- `atualizar()`
- `excluir()`

Todas as consultas usam `prepare()` e `execute()`, com placeholders `?` para os dados.

## Arquivos do projeto

| Arquivo | Para que serve |
| --- | --- |
| `banco.sql` | Cria banco `projetosemestre`, duas tabelas e os registros de demonstração |
| `conexao.php` | Centraliza os dados de acesso MySQL e cria a conexão PDO |
| `UsuarioDAO.php` | Operações com a tabela usuários |
| `VeiculoDAO.php` | Operações com a tabela veículos e filtros de pesquisa |
| `exemplo.php` | Apresentação dos DAOs com inserir, listar, buscar, editar e excluir |
| `index.php` | Vitrine do Marketplace, com categorias, filtros, favoritos e busca |
| `anuncio.php` | Detalhes de cada anúncio |
| `anunciar.php` | Formulário de publicação, com escolha de usuário e validação básica |
| `style.css` | Layout escuro, com menu lateral, cards e responsividade |
| `script.js` | Controle dos favoritos no navegador e filtros no celular |

## Como instalar e rodar com XAMPP (Windows)

**1. Ligar os serviços**

Abra **XAMPP Control Panel**. Clique **Start** no **Apache** e **MySQL**. Os dois devem mostrar **Running**.

**2. Baixar os arquivos**

Abra PowerShell:

```powershell
cd C:\xampp\htdocs
git clone https://github.com/brunofiegenbaum/projetosemestre.git
```

A pasta ficará em `C:\xampp\htdocs\projetosemestre`.

**Se a pasta já existe e foi clonada do GitHub**, abra-a e atualize:

```powershell
cd C:\xampp\htdocs\projetosemestre
git pull
```

Se a pasta local contém apenas um Git iniciado à parte e sem os arquivos do GitHub, prefira clonar o repositório em uma pasta nova (em vez de usar `git push --force`).

**3. Importar o banco SQL**

1. Abra `http://localhost/phpmyadmin`.
2. Clique em **Importar**.
3. Escolha `C:\xampp\htdocs\projetosemestre\banco.sql`.
4. Clique em **Executar / Importar**.
5. Confira na barra lateral o banco **projetosemestre** com as tabelas **usuarios** e **veiculos**.

**IMPORTANTE:** A versão anterior do projeto utilizava o banco `rua_veiculos`. Agora é `projetosemestre`. Você **precisa importar o banco.sql novo** mesmo que já tenha importado o arquivo da versão anterior. Este SQL recria as tabelas do banco `projetosemestre` e apaga qualquer dado que já estivesse nelas. Faça backup se tiver dados importantes.

**4. Conferir a conexão**

O arquivo `conexao.php` usa a configuração padrão do XAMPP:

```php
$servidor = "localhost";
$banco = "projetosemestre";
$usuario = "root";
$senha = "";
```

Caso seu MySQL tenha senha, altere **somente** esse arquivo.

**5. Abrir o sistema**

- **Marketplace:** `http://localhost/projetosemestre/`
- **Criar anúncio:** `http://localhost/projetosemestre/anunciar.php`
- **Detalhe de um veículo:** `http://localhost/projetosemestre/anuncio.php?id=1`
- **Script da Sprint 1:** `http://localhost/projetosemestre/exemplo.php`

Abra essas páginas pelo endereço `http://localhost`, não pelo Live Server ou pelo duplo clique em um arquivo PHP.

## O que testar na apresentação de 22/10

1. No phpMyAdmin, abra as tabelas `usuarios` e `veiculos`. Mostre que `veiculos.id_usuario` referencia `usuarios.id_usuario`.
2. Abra `conexao.php` e mostre o `new PDO`.
3. Abra `UsuarioDAO.php` e `VeiculoDAO.php`. Apresente os cinco métodos e o uso de `prepare()` e `execute()`.
4. Execute `http://localhost/projetosemestre/exemplo.php` para mostrar o CRUD das duas tabelas. O script usa transação e `rollBack()` para não salvar o teste.
5. Se quiser, abra a página inicial e publique um novo veículo pelo formulário `anunciar.php`. Ele entra na listagem real do banco.

## Status dos requisitos do enunciado

| Requisito | Status |
| --- | --- |
| Banco + mínimo 2 tabelas relacionadas com 5 registros por tabela | Implementado |
| Conexão PDO | Implementado |
| DAO completo para cada tabela | Implementado |
| SQL com prepare + execute e ? | Implementado |
| Script tipo exemplo.php | Implementado |
| Catálogo visual, filtros e página de detalhes | Prévia funcional (PHP) |
| Formulário de novo anúncio vinculado ao usuário | Prévia funcional (PHP) |
| API REST em JSON com Bearer token e respostas HTTP | Pendente — Sprint 2 |
| Testes das rotas em testes-api.sh | Pendente — Sprint 2 |
| As quatro páginas consumindo API com fetch + async/await | Pendente — Sprint 3 |
| Edição e exclusão pela interface com confirmação e mensagens | Pendente — Sprint 3/4 |

**Atenção:** os favoritos, por enquanto, ficam no `localStorage` do navegador, sem login. O formulário permite selecionar um usuário de demonstração, sem autenticação. Não use esta versão para anúncios reais/publicação na internet sem implementar autenticação e autorização.

## Próximas entregas

- **05/11 — Sprint 2:** API REST JSON (GET, POST, PUT, DELETE), token Bearer, status HTTP, validação e testes-api.sh.
- **19/11 — Sprint 3:** quatro telas com HTML/CSS/JS, `fetch` e `async/await`, tabela de listagem e formulários.
- **26/11 — Sprint 4:** aperfeiçoamento da validação, mensagens, responsividade e README.
- **03/12 — Apresentação final.**

**Repositório:** https://github.com/brunofiegenbaum/projetosemestre
