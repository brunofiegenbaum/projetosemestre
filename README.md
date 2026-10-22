# Projeto do Semestre - Oficina Mecânica

Disciplina: Desenvolvimento de Aplicações para Internet - Univates.

**Tema:** sistema de cadastro de clientes e veículos de uma oficina.

**Integrantes:** Bruno Fiegenbaum e [preencher nome do segundo integrante].

## Sprint 1 - Banco + DAO (22/10/2026)

Esta etapa implementa o banco de dados MySQL e as classes PHP responsáveis por acessar os dados. Ainda não tem telas de cadastro nem API; essas partes serão desenvolvidas nas próximas sprints.

### Estrutura

- `banco.sql`: cria o banco `oficina`, as tabelas e 5 registros de teste em cada tabela.
- `conexao.php`: faz a conexão com MySQL usando PDO.
- `ClienteDAO.php`: inserir, listar, buscarPorId, atualizar e excluir clientes.
- `VeiculoDAO.php`: inserir, listar, buscarPorId, atualizar e excluir veículos.
- `exemplo.php`: mostra as operações das duas classes DAO.

### Modelo do banco de dados

**clientes (tabela pai)**
- `id_cliente`: chave primária.
- `nome`: nome do cliente.
- `telefone`: telefone.

**veiculos (tabela filha)**
- `id_veiculo`: chave primária.
- `id_cliente`: chave estrangeira que aponta para `clientes.id_cliente`.
- `marca`, `modelo`, `ano` e `placa`: informações do veículo.

**Relacionamento:** um cliente pode ter vários veículos (1:N). Cada veículo pertence a um cliente. A chave estrangeira impede cadastrar veículo para um cliente que não existe e impede excluir um cliente que ainda tem veículos cadastrados.

### Como executar com XAMPP

1. Iniciar **Apache** e **MySQL** no XAMPP.
2. Colocar a pasta do projeto dentro de `C:\xampp\htdocs\projetosemestre`.
3. Abrir `http://localhost/phpmyadmin`, entrar na aba **SQL** e executar o conteúdo de `banco.sql` (ou importar esse arquivo). Atenção: importar novamente recria as tabelas e apaga alterações feitas nelas.
4. Conferir os dados de `conexao.php`. O arquivo está configurado para XAMPP local: servidor `localhost`, banco `oficina`, usuário `root`, senha vazia. Alterar se o seu MySQL for diferente.
5. Abrir `http://localhost/projetosemestre/exemplo.php`.

O `exemplo.php` exibe os registros, insere um cliente e um veículo de teste, busca por ID, atualiza e exclui os dois. Todas as alterações são feitas em uma transação desfeita no final, então os 5 registros originais continuam no banco.

### Requisitos atendidos na Sprint 1

| Requisito do PDF | Onde está |
| --- | --- |
| 1. Criar banco e tabelas do zero | `banco.sql` |
| 2. Duas tabelas com FOREIGN KEY (1:N) | `banco.sql` |
| 3. Cinco registros em cada tabela | `banco.sql` |
| 4. Conexão por PDO em um único arquivo | `conexao.php` |
| 5. DAO por tabela com 5 métodos | `ClienteDAO.php` e `VeiculoDAO.php` |
| 6. Comandos com prepare + execute e parâmetros ? | `ClienteDAO.php` e `VeiculoDAO.php` |

### Planejamento das próximas sprints

- **05/11 - Sprint 2:** API REST em PHP que responde JSON, usa token Bearer e permite GET, POST, PUT e DELETE. Criar `testes-api.sh`.
- **19/11 - Sprint 3:** telas de início, listagem, cadastro e edição com HTML, CSS externo e JavaScript `fetch`. O formulário de veículo deverá carregar clientes em um `select`.
- **26/11 - Sprint 4:** revisar validações, mensagens de sucesso e erro, layout para celular e documentação.
- **03/12 - Apresentação final:** demonstrar o projeto completo.

**Esboço das telas futuras:** uma página inicial com menu; uma listagem de veículos com botões Editar e Excluir; um formulário para cadastrar veículo escolhendo o cliente; e um formulário de edição preenchido com os dados existentes. Header e footer serão iguais em todas as páginas.

## Link para entrega

https://github.com/brunofiegenbaum/projetosemestre
