# Bruno e Jean - Projeto Semestre

**Integrantes:** Bruno Fiegenbaum e Jean (sobrenome a completar).  
**Tema:** marketplace de compra e venda de veículos com visual escuro inspirado no Facebook Marketplace.  
**Disciplina:** Desenvolvimento de Aplicações para Internet — Univates.

## Rodando no XAMPP

1. No XAMPP, inicie **Apache** e **MySQL**.
2. Clone o repositório em `C:\xampp\htdocs\projetosemestre`:
   `git clone https://github.com/brunofiegenbaum/projetosemestre.git`
3. No navegador abra `http://localhost/phpmyadmin`, clique em **Importar** e escolha o arquivo `banco.sql`.
4. Entre em `http://localhost/projetosemestre/` para abrir o Marketplace.
5. Entre em `http://localhost/projetosemestre/exemplo.php` para apresentar o teste da Sprint 1.

**Banco:** `projetosemestre`. Exatamente duas tabelas: `usuarios` (5 registros fictícios) e `veiculos` (16 registros fictícios), relacionadas por `id_usuario` (1:N). O SQL apaga e recria essas tabelas ao ser importado novamente.

## Estrutura do código

| Arquivo | Função |
| --- | --- |
| `banco.sql` | Tabelas, FOREIGN KEY e dados de teste |
| `conexao.php` | PDO para MySQL |
| `UsuarioDAO.php` e `VeiculoDAO.php` | Os 5 métodos CRUD por tabela, usando `prepare` e `execute` |
| `exemplo.php` | Testa inserção, listagem, busca, atualização e exclusão |
| `index.php` | Página inicial com filtros e anúncios |
| `anuncio.php` | Detalhes de um anúncio |
| `anunciar.php` | Criar anúncio selecionando um usuário de demonstração |
| `style.css` e `script.js` | Estilo, favoritos locais e menu de filtros no celular |

**Entrega da Sprint 1:** concluída no código; execução no XAMPP/MySQL precisa ser verificada localmente.  
**Pendentes para as próximas sprints:** API JSON com Bearer, `testes-api.sh`, telas CRUD com `fetch`, edição e exclusão pela interface.

---

## Enunciado original da atividade

DESENVOLVIMENTO DE APLICAÇÕES PARA INTERNET · UNIVATES
Projeto do Semestre — Sistema Web Completo
Duplas · Início: 08/10/2026 · Apresentação final: 03/12/2026

Ideia
Construir um sistema web de cadastro e consulta sobre um tema escolhido pela dupla, juntando tudo
que vimos até aqui:
Front-end: HTML, CSS e JavaScript (como na Prova 1)
API: PHP devolvendo JSON, protegida por token (como a API de clientes)
Banco: MySQL acessado com PDO e classes DAO
Integração: páginas que usam fetch para listar, cadastrar, editar e excluir (como na aula 4)
Sugestões de tema (um tema por dupla, sem repetir)
Biblioteca (autores → livros) Pet shop (tutores → animais) Academia (planos → alunos)
Oficina (clientes → veículos) Restaurante (categorias → pratos) Eventos (eventos → inscrições)
Clínica (médicos → consultas) Outro tema aprovado pelo professor
Requisitos
Banco de dados (MySQL)
1. Arquivo banco.sql que cria o banco e as tabelas do zero.
2. No mínimo 2 tabelas relacionadas (1:N) com chave estrangeira ( FOREIGN KEY ).
3. Pelo menos 5 registros de exemplo em cada tabela ( INSERT ).
Back-end (PHP)
4. conexao.php com PDO (um único lugar com usuário/senha do banco).
5. Uma classe DAO por tabela, com os métodos inserir , listar , buscarPorId , atualizar e
excluir .
6. Somente prepare + execute com ? nos SQLs que recebem dados do usuário (nada de concatenar
variável no SQL).
7. API REST que responde em JSON, com os métodos GET (todos e por ?id= ), POST , PUT e DELETE
para a tabela principal.
8. API exige Authorization: Bearer <token> e responde 401 sem token válido.
9. Códigos HTTP corretos: 200, 201 (criado), 400 (dados inválidos), 401, 404 (não encontrado), 405
(método não permitido).
10. Validação no servidor: campos obrigatórios vazios retornam 400 com mensagem de erro (lembre da
calculadora!).
Front-end (HTML, CSS, JS)
11. No mínimo 4 páginas: início, listagem, cadastro e edição.
12. Header com menu e footer iguais em todas as páginas.
13. CSS externo (sem style="" ), layout com Flexbox ou Grid e que funcione no celular.
14. JavaScript com fetch + async/await consumindo a sua API.

15. Listagem em tabela montada pelo JS, com botões Editar e Excluir em cada linha.
16. Excluir pede confirmação ( confirm ) antes de chamar a API.
17. Mensagens de sucesso/erro mostradas na página (sem alert para isso).
18. Na tela de cadastro da tabela "filha", um <select> carregado pela API com os registros da tabela
"pai".
Entrega e organização
19. testes-api.sh com os curl testando todas as rotas (incluindo os casos de erro).
20. README.md com: tema, integrantes, como rodar, e onde está cada requisito.
Cronograma (sprints)
Data Sprint Entrega
08/10 0 —
Planejamento

Tema, dupla, modelo das tabelas, esboço das telas (em aula)

22/10 1 — Banco +
DAO

banco.sql , conexao.php , DAOs funcionando (script de teste tipo
exemplo.php )

05/11 2 — API API completa com token + testes-api.sh passando
19/11 3 — Front-end Páginas consumindo a API, layout pronto
26/11 4 — Ajustes Validação, mensagens, responsividade, README
03/12 Final Apresentação de 10 min por dupla + entrega do código
Cada sprint é mostrada ao professor em aula (5 min por dupla). Sprint não apresentada perde a nota dela.
Avaliação
Item Peso
Sprints 1 a 4 (acompanhamento) 30%
Banco + DAO (req. 1–6) 15%
API (req. 7–10, 19) 20%
Front-end (req. 11–18) 20%
Apresentação final + README 15%
Na apresentação, os dois integrantes precisam saber explicar qualquer parte do código.
Pergunta não respondida desconta do item correspondente.
Pontos extras (até +1,0)
Busca/filtro na listagem ( GET ?busca= ) feita no SQL com LIKE
Login com tela própria gerando o token (em vez de token fixo)
Paginação na listagem
Publicado em um servidor acessível pela internet
