-- Projeto do semestre: RUA. - Compra e venda de veículos
-- Sprint 1: MySQL, duas tabelas (usuarios e veiculos) e cinco registros em cada.
-- IMPORTANTE: este script recria as tabelas e apaga os dados anteriores delas.

CREATE DATABASE IF NOT EXISTS rua_veiculos
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE rua_veiculos;

DROP TABLE IF EXISTS veiculos;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE veiculos (
    id_veiculo INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    marca VARCHAR(50) NOT NULL,
    modelo VARCHAR(80) NOT NULL,
    ano INT NOT NULL,
    preco DECIMAL(12,2) NOT NULL,
    quilometragem INT NOT NULL,
    cidade VARCHAR(80) NOT NULL,
    uf CHAR(2) NOT NULL,
    descricao TEXT,
    status VARCHAR(15) NOT NULL DEFAULT 'disponivel',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Dados fictícios apenas para apresentar o sistema.
INSERT INTO usuarios (nome, email, telefone) VALUES
('Lucas Martins', 'lucas@exemplo.test', '(51) 90000-0001'),
('Mariana Costa', 'mariana@exemplo.test', '(51) 90000-0002'),
('Rafael Silva', 'rafael@exemplo.test', '(51) 90000-0003'),
('Julia Souza', 'julia@exemplo.test', '(51) 90000-0004'),
('Gabriel Oliveira', 'gabriel@exemplo.test', '(51) 90000-0005');

INSERT INTO veiculos
(id_usuario, marca, modelo, ano, preco, quilometragem, cidade, uf, descricao) VALUES
(1, 'Volkswagen', 'Fusca 1300', 1980, 34900.00, 90000, 'Westfália', 'RS', 'Clássico com interior claro e visual original.'),
(1, 'Volkswagen', 'Golf GTI', 1995, 39900.00, 145000, 'Lajeado', 'RS', 'Hatch esportivo para quem gosta dos anos 90.'),
(2, 'Chevrolet', 'Vectra CD 2.0', 1997, 24900.00, 172000, 'Teutônia', 'RS', 'Sedã clássico confortável e bem equipado.'),
(3, 'Honda', 'Civic EXR', 2014, 68900.00, 112000, 'Estrela', 'RS', 'Sedã com câmbio automático e bom espaço.'),
(4, 'Toyota', 'Corolla XEi', 2017, 82900.00, 94000, 'Lajeado', 'RS', 'Sedã para uso diário. Anúncio demonstrativo.');
