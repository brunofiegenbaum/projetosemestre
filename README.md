# RUA. — Compra e venda de veículos

Projeto do semestre da disciplina **Desenvolvimento de Aplicações para Internet — Univates (2026)**.

**Tema:** plataforma de anúncios de compra e venda de veículos, com proposta visual jovem, escura e minimalista. Não é uma cópia de outro marketplace.

**Integrantes:** Bruno Fiegenbaum e **[preencher nome da dupla]**.

## Sprint 1 — Banco + DAO (22/10/2026)

A Sprint 1 exige um banco MySQL com pelo menos duas tabelas relacionadas, cinco registros de teste em cada uma, conexão PDO, uma DAO para cada tabela e um script de demonstração.

### Banco de dados

**Banco:** `rua_veiculos`

**Tabela pai: `usuarios`**
- `id_usuario` (PRIMARY KEY)
- `nome`, `email` e `telefone`

**Tabela filha: `veiculos`**
- `id_veiculo` (PRIMARY KEY)
- `id_usuario` (FOREIGN KEY para `usuarios.id_usuario`)
- `marca`, `modelo`, `ano`, `preco`, `quilometragem`, `cidade`, `uf`, `descricao`, `status`

**Relacionamento 1:N:** um usuário pode publicar vários veículos, mas cada veículo tem um único anunciante. Existem **exatamente 2 tabelas**, com **5 registros fictícios em cada uma**.

### Arquivos

| Arquivo | Função |
| --- | --- |
| `banco.sql` | Cria o banco, as duas tabelas, a chave estrangeira e os dados de exemplo |
| `conexao.php` | Conecta ao MySQL usando PDO |
| `UsuarioDAO.php` | Inserir, listar, buscarPorId, atualizar e excluir usuários |
| `VeiculoDAO.php` | Inserir, listar, buscarPorId, atualizar e excluir veículos; buscar anúncios por marca ou modelo |
| `exemplo.php` | Demonstra as cinco operações dos dois DAOs |
| `index.php` | Vitrine inicial com tema escuro e busca (prévia visual) |
| `anuncio.php` | Página de detalhes de um veículo (prévia visual) |
| `style.css` | Visual dark/minimalista responsivo, com CSS externo |

As classes DAO usam **`prepare()` + `execute()`**. Os comandos que recebem valores têm parâmetros `?`, em vez de juntar dados do usuário diretamente ao SQL.

## Como rodar pelo XAMPP (Windows)

### 1. Ligar o servidor

Abra **XAMPP Control Panel** e clique em **Start** para:
- **Apache** — executa as páginas PHP no navegador.
- **MySQL** — guarda os registros dos veículos e usuários.

Os dois precisam estar com o status verde (**Running**).

### 2. Baixar o projeto no lugar certo

No PowerShell, execute:

```powershell
cd C:\xampp\htdocs
git clone https://github.com/brunofiegenbaum/projetosemestre.git
```

A pasta do projeto deverá ficar em:

```text
C:\xampp\htdocs\projetosemestre
```

**Importante:** o repositório precisa estar dentro de `htdocs` para o Apache servir o PHP. Se a pasta já existir dentro de `htdocs`, abra-a e rode `git pull` em vez de clonar de novo. A pasta antiga na Área de Trabalho pode continuar lá, mas não é a que o XAMPP vai abrir automaticamente.

### 3. Criar o banco de dados

1. Abra `http://localhost/phpmyadmin`.
2. Na aba **Importar**, escolha `C:\xampp\htdocs\projetosemestre\banco.sql`.
3. Clique em **Importar/Executar**.
4. Na barra lateral do phpMyAdmin deve aparecer o banco `rua_veiculos`, com as tabelas `usuarios` e `veiculos`.

**Cuidado:** executar `banco.sql` novamente apaga e recria as duas tabelas. Faça isso apenas quando quiser reiniciar os dados de exemplo.

### 4. Conferir a conexão

O arquivo `conexao.php` está configurado para a instalação padrão do XAMPP:

```php
$servidor = "localhost";
$banco = "rua_veiculos";
$usuario = "root";
$senha = "";
```

Se você colocou uma senha no MySQL, modifique **somente** `conexao.php`.

### 5. Abrir no navegador

- **Site:** `http://localhost/projetosemestre/`
- **Teste da Sprint 1:** `http://localhost/projetosemestre/exemplo.php`
- **Detalhes do primeiro anúncio:** `http://localhost/projetosemestre/anuncio.php?id=1`

Na página de teste, você verá a listagem, inserção, consulta, atualização e exclusão de usuários e veículos. Os registros criados ali são desfeitos com `rollBack()` e não ficam gravados.

**Não abra `index.php` pelo Explorador de Arquivos e não use Live Server no VS Code para executar PHP.** Abra pela URL `http://localhost` com Apache e MySQL ativos.

### Erros comuns

- **404 / página não encontrada:** a pasta não está em `htdocs\projetosemestre` ou Apache não foi iniciado.
- **Erro ao conectar:** o MySQL não está iniciado, o SQL não foi importado ou as credenciais estão diferentes.
- **`could not find driver`:** extensão PHP `pdo_mysql` não está habilitada.
- **Apache não inicia:** outra aplicação pode estar usando a porta 80. Verifique o log do XAMPP.
- **`git clone` diz que a pasta já existe:** dentro da pasta certa use `git pull`, não `git clone` novamente.

## Para apresentar a Sprint 1 em 5 minutos

1. No phpMyAdmin, mostrar as tabelas `usuarios` e `veiculos`, com 5 registros cada.
2. Explicar que `veiculos.id_usuario` é uma chave estrangeira e faz o relacionamento 1:N.
3. Abrir `conexao.php`, `UsuarioDAO.php` e `VeiculoDAO.php`. Mostrar os métodos e o uso de `prepare` e `execute`.
4. Executar `exemplo.php` pelo navegador e explicar os testes.
5. Se der tempo, mostrar o visual inicial em `index.php`.

## Próximas etapas (PDF da atividade)

- **05/11 — Sprint 2:** criar API REST JSON, GET (lista e por ID), POST, PUT, DELETE, token Bearer, validações e `testes-api.sh`.
- **19/11 — Sprint 3:** criar as quatro páginas exigidas (início, listagem, cadastro e edição) em HTML/CSS/JS, consumindo API via `fetch` + `async/await`. Incluir `select` de usuários/anunciantes.
- **26/11 — Sprint 4:** mensagens de erro e sucesso, confirmação para excluir, responsividade e revisão do README.
- **03/12 — Entrega final.**

A **vitrine atual é apenas uma prévia funcional em PHP**: ela lista anúncios do MySQL, permite buscar e abrir detalhes, mas **a API JSON com token, o login e o CRUD via telas ainda não foram implementados**. A integração definitiva com `fetch` virá na Sprint 3.

Os carros e usuários do SQL são **dados fictícios de demonstração**, não veículos à venda de verdade.

**Link para entrega:** https://github.com/brunofiegenbaum/projetosemestre
