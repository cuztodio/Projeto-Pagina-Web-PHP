-- sql/seed.sql
USE php_crud_auth_app;

INSERT INTO users (name, email, password_hash, role) VALUES
('Administrador', 'admin@exemplo.com', '$2y$10$2C0bE9ZqvHNiEaa0t2K0weLBsH6u0JZxPb0sLg0XnMP2k5N53H0P.', 'admin'), -- senha: admin123
('Usuário Padrão', 'user@exemplo.com', '$2y$10$zj6c3hAqQ0JqH3k9eQGx9u0Sg1n6aQxJH6c8vGq9W7pQ1k2QGZ2uK', 'user');   -- senha: user123

INSERT INTO categories (name) VALUES ('Acessórios'), ('Informática'), ('Games');

INSERT INTO products (name, price, category_id) VALUES
('Mouse Óptico', 59.90, 1),
('Teclado Mecânico', 299.00, 2),
('Controle Gamer', 199.50, 3);
