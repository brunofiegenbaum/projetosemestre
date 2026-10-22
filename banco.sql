-- Projeto do Semestre - Oficina Mecânica
-- Sprint 1: duas tabelas relacionadas e registros para teste

CREATE DATABASE IF NOT EXISTS oficina
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE oficina;

-- A tabela de veículos depende da tabela de clientes.
DROP TABLE IF EXISTS veiculos;
DROP TABLE IF EXISTS clientes;

CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

CREATE TABLE veiculos (
    id_veiculo INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(60) NOT NULL,
    ano INT NOT NULL,
    placa VARCHAR(7) NOT NULL UNIQUE,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
);

INSERT INTO clientes (nome, telefone) VALUES
('Maria Silva', '(51) 99999-0001'),
('João Santos', '(51) 99999-0002'),
('Ana Oliveira', '(51) 99999-0003'),
('Pedro Souza', '(51) 99999-0004'),
('Carla Ferreira', '(51) 99999-0005');

INSERT INTO veiculos (id_cliente, marca, modelo, ano, placa) VALUES
(1, 'Volkswagen', 'Fusca', 1980, 'ABC1D23'),
(2, 'Chevrolet', 'Corsa', 2005, 'DEF2G34'),
(3, 'Fiat', 'Uno', 2010, 'GHI3J45'),
(4, 'Ford', 'Ka', 2014, 'JKL4M56'),
(5, 'Toyota', 'Corolla', 2017, 'MNO5P67');
