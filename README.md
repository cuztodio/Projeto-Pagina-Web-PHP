📘 1️⃣ Visão Geral

Este projeto é um sistema web completo desenvolvido em PHP puro (sem frameworks), com banco de dados MySQL e PDO para conexão segura.
Inclui autenticação de usuários, CRUD completo de produtos, associação a categorias, exportação de dados em CSV e medidas básicas de segurança (senhas hash, proteção contra SQL Injection e XSS).

⚙️ 2️⃣ Pré-requisitos

Antes de rodar o sistema, é necessário ter instalado:

PHP 8.1 ou superior

MySQL 8.0 ou superior

MySQL Workbench

Um editor de código (VS Code recomendado)

Navegador atualizado (Chrome, Edge, etc.)

🧱 3️⃣ Estrutura do Projeto
php_crud_auth_app/
 ┣ config/
 ┃ ┗ db.php               → conexão com banco via PDO
 ┣ includes/
 ┃ ┣ auth.php             → controle de sessão e login
 ┃ ┗ functions.php        → funções auxiliares
 ┣ public/
 ┃ ┣ assets/
 ┃ ┃ ┗ styles.css         → estilos do site
 ┃ ┣ index.php            → redirecionamento ou dashboard
 ┃ ┣ login.php            → tela de login
 ┃ ┣ logout.php           → finaliza sessão
 ┃ ┣ dashboard.php        → área protegida após login
 ┃ ┣ categories/          → CRUD de categorias
 ┃ ┗ products/            → CRUD de produtos + export_csv.php
 ┗ sql/
   ┗ database.sql         → script completo do banco de dados

🧰 4️⃣ Configurando o Banco de Dados

Abra o MySQL Workbench

Clique em “New SQL Tab”

Copie e cole o script SQL (que te mandei anteriormente)

Execute tudo (⚡ botão de raio)

🔹 Isso vai criar:

Banco de dados php_crud_auth_app

Tabelas users, categories, products

Usuário admin e user já prontos

🔑 5️⃣ Credenciais de Acesso
Tipo	E-mail	Senha
Administrador	admin@example.com
	admin123
Usuário comum	user@example.com
	user123
🧩 6️⃣ Configurando o PHP
1. Verifique se o PHP está instalado:

Abra o PowerShell ou CMD e digite:

php -v


Se aparecer a versão, está tudo certo.

2. Ative o driver PDO MySQL (se necessário)

Abra o arquivo:

C:\php\php.ini


Procure as linhas:

;extension=pdo_mysql
;extension=mysqli


Remova o ponto e vírgula (;) no início delas:

extension=pdo_mysql
extension=mysqli


Salve e reinicie o terminal.

🖥️ 7️⃣ Executando o Projeto

Abra o terminal dentro da pasta public do projeto:

cd C:\Users\SeuUsuario\Downloads\php_crud_auth_app\public


Inicie o servidor embutido do PHP:

php -S localhost:8000


Acesse o sistema no navegador:
👉 http://localhost:8000

🔐 8️⃣ Sistema de Login

Acesse com as credenciais acima.

Após logar, será redirecionado para o dashboard.

Apenas usuários autenticados acessam as páginas de CRUD.

🛠 9️⃣ CRUD de Produtos e Categorias
Produtos:

Criar, editar e excluir produtos.

Associar produtos a categorias.

Exportar dados em CSV formatado para Excel.

Categorias:

Adicionar novas categorias.

Deletar ou editar categorias existentes.

Evita duplicatas automaticamente (UNIQUE).

📤 🔟 Exportar Dados para CSV

Na tela de produtos, clique em “Exportar CSV”.
O arquivo será baixado com as colunas:

ID;Nome;Categoria;Preço


O CSV abre corretamente no Excel (PT-BR), com acentuação preservada.

🔒 11️⃣ Segurança Implementada

PDO + Prepared Statements → evita SQL Injection

password_hash() / password_verify() → senhas seguras

htmlspecialchars() em entradas → proteção contra XSS

Sessões PHP → controla autenticação e expiração de login

ON DELETE SET NULL → garante integridade referencial

🧠 12️⃣ Funcionalidade Extra (Requisito NP2)

💡 Exportação de dados para CSV formatado (compatível com Excel)

Implementada no arquivo:

public/products/export_csv.php


Esse recurso exporta automaticamente os produtos cadastrados com suas categorias, já prontos para análise e relatórios administrativos.

🧹 13️⃣ Comandos SQL úteis (administração rápida)

Listar todas as categorias:

SELECT * FROM categories;


Deletar produtos de uma categoria:

DELETE FROM products WHERE category_id = 2;


Desassociar produtos de uma categoria:

UPDATE products SET category_id = NULL WHERE category_id = 2;


Resetar o banco:

DROP DATABASE php_crud_auth_app;

🎨 14️⃣ Estilo e Interface

Layout limpo e responsivo.

Cores suaves e espaçamento agradável.

Campos com feedback visual (mensagens de erro e sucesso).

🚀 15️⃣ Sugestões de Expansão

Upload de imagem para produtos (image_path).

Controle de permissões (admin x usuário).

Geração de relatórios em PDF.

API REST para integração com aplicações móveis.

🧾 16️⃣ Conclusão

Esse sistema atende aos requisitos da NP2:
✅ Estrutura organizada
✅ CRUD completo
✅ Login com hash e segurança
✅ Relacionamentos com chaves estrangeiras
✅ Funcionalidade extra implementada (Exportação CSV)
✅ Manual/tutorial explicativo