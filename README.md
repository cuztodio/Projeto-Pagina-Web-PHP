# Sistema Web PHP + MySQL (PDO): Login + CRUD (Produtos & Categorias)

Projeto acadêmico **sem Laravel**, usando **PHP 8+**, **MySQL**, **PDO**, **password_hash**, **password_verify**, **prepared statements** e **proteções básicas (XSS, CSRF)**.

## Funcionalidades
- Autenticação (login/logout) com `password_hash` / `password_verify`
- Sessão e páginas protegidas
- CRUD completo para **Produtos** (tabela principal) e **Categorias** (relacionamento 1:N)
- Busca por nome e filtro por categoria na lista de produtos
- **Exportação CSV** dos produtos (recurso extra obrigatório)
- **Upload de imagem** do produto (opcional; salva o caminho do arquivo)
- Proteções: **PDO + prepared statements**, **XSS via `htmlspecialchars`**, **CSRF token** nos formulários
- Organização de pastas: `config/`, `includes/`, `public/`, `assets/`, `sql/`

## Requisitos
- PHP 8.1+ com extensões `pdo` e `pdo_mysql`
- MySQL 8+
- Navegador web moderno

## Instalação
1. **Crie o banco de dados** e importe os scripts:
   - `sql/schema.sql`
   - `sql/seed.sql`

2. **Configure a conexão** em `config/db.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'php_crud_auth_app');
   define('DB_USER', 'root');
   define('DB_PASS', 'sua_senha');
   ```

3. **Permissões de upload (opcional)**:
   - Certifique-se de que a pasta `public/uploads` exista e tenha permissão de escrita:
     ```bash
     mkdir -p public/uploads
     ```

4. **Suba o servidor PHP de desenvolvimento** na pasta `public/`:
   ```bash
   cd public
   php -S localhost:8000
   ```
   Acesse: http://localhost:8000

## Usuários de teste
- **admin@exemplo.com** / **admin123**
- **user@exemplo.com** / **user123**

## Estrutura de Pastas
```
config/
  db.php                 # Conexão PDO
includes/
  auth.php               # Autorização + CSRF helpers
  functions.php          # Funções utilitárias (sanitize etc.)
assets/
  styles.css             # Estilos simples
public/
  index.php              # Redireciona para login/dashboard
  login.php              # Form + processamento de login
  logout.php             # Encerra sessão
  dashboard.php          # Tela protegida
  products/
    list.php             # Listagem + busca/filtros + export CSV
    create.php           # Cadastrar produto (com upload opcional)
    edit.php             # Editar produto (com upload opcional)
    delete.php           # Deletar produto (CSRF)
    export_csv.php       # Gera CSV
  categories/
    list.php             # Listar categorias
    create.php           # Cadastrar categoria
    edit.php             # Editar categoria
    delete.php           # Deletar categoria
sql/
  schema.sql             # Criação de tabelas, chaves, índices
  seed.sql               # Dados iniciais (usuários, categorias)
README.md                # Este manual/tutorial
```

## Segurança Implementada (resumo)
- **SQL Injection**: *sempre* via **PDO + prepared statements**
- **XSS**: Saída sanitizada com `htmlspecialchars($str, ENT_QUOTES, 'UTF-8')`
- **Senhas**: `password_hash()` e `password_verify()`
- **Sessões**: `session_regenerate_id()` após login + `session_destroy()` no logout
- **CSRF**: token em formulários de ações sensíveis (create/edit/delete/login)

## Recurso Novo (além do tutorial)
- **Exportação CSV** dos produtos, com filtros aplicados.
- **Upload de imagens** de produtos (validação simples: extensão e tamanho).

## Integração com POO2 (se aplicável)
- O projeto usa um **único banco MySQL** com chaves estrangeiras entre `products` e `categories`,
  podendo ser integrado ao seu esquema unificado de POO2.

## Observações
- Código comentado e didático para apresentação na NP2.
- Todos os membros devem entender o fluxo: **login → dashboard → CRUD → export CSV**.
