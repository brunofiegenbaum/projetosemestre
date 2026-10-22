-- Bruno e Jean - Projeto Semestre
-- Marketplace de compra e venda de veículos (Sprint 1)
-- Ao importar novamente, os dados anteriores destas tabelas serão apagados.

CREATE DATABASE IF NOT EXISTS projetosemestre
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE projetosemestre;

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
  marca VARCHAR(60) NOT NULL,
  modelo VARCHAR(90) NOT NULL,
  categoria VARCHAR(30) NOT NULL DEFAULT 'Carros',
  ano INT NOT NULL,
  preco DECIMAL(12,2) NOT NULL,
  quilometragem INT NOT NULL,
  cidade VARCHAR(80) NOT NULL,
  uf CHAR(2) NOT NULL,
  descricao TEXT,
  foto_url VARCHAR(500),
  status VARCHAR(15) NOT NULL DEFAULT 'disponivel',
  FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
) ENGINE=InnoDB;

-- Os 5 usuários e anúncios a seguir são fictícios (dados para o trabalho).
INSERT INTO usuarios (nome, email, telefone) VALUES
('Lucas Martins','lucas@exemplo.test','(51) 90000-0001'),
('Mariana Costa','mariana@exemplo.test','(51) 90000-0002'),
('Rafael Silva','rafael@exemplo.test','(51) 90000-0003'),
('Julia Souza','julia@exemplo.test','(51) 90000-0004'),
('Gabriel Oliveira','gabriel@exemplo.test','(51) 90000-0005');

-- Fotos ilustrativas de automóveis, obtidas de imagens públicas do Unsplash.
-- Não representam necessariamente o modelo exato anunciado.
INSERT INTO veiculos
(id_usuario, marca, modelo, categoria, ano, preco, quilometragem, cidade, uf, descricao, foto_url) VALUES
(1,'Volkswagen','Golf GTI','Hatches',2015,89900,99000,'Lajeado','RS','Hatch esportivo, interior conservado. Anúncio demonstrativo.','https://images.unsplash.com/photo-1502161254066-6c74afbf7b6f?w=900&q=80&auto=format&fit=crop'),
(2,'Honda','Civic Touring','Sedãs',2018,114900,74000,'Teutônia','RS','Sedã turbo para uso diário. Dados fictícios.','https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=900&q=80&auto=format&fit=crop'),
(3,'BMW','320i Sport','Sedãs',2016,121900,106000,'Estrela','RS','Sedã esportivo. Fotos meramente ilustrativas.','https://images.unsplash.com/photo-1555215695-3004980ad54e?w=900&q=80&auto=format&fit=crop'),
(4,'Ford','Mustang GT','Esportivos',2017,279900,43000,'Porto Alegre','RS','V8, automático e interior em couro. Anúncio fictício.','https://images.unsplash.com/photo-1494976388531-d1058494cdd8?w=900&q=80&auto=format&fit=crop'),
(5,'Chevrolet','Camaro SS','Esportivos',2014,199900,62000,'Canoas','RS','Esportivo com visual marcante. Anúncio demonstrativo.','https://images.unsplash.com/photo-1552519507-da3b142c6e3d?w=900&q=80&auto=format&fit=crop'),
(1,'Volkswagen','Fusca 1300','Clássicos',1980,34900,90000,'Westfália','RS','Carro antigo com ótimo estilo. Informações fictícias.','https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=900&q=80&auto=format&fit=crop'),
(2,'Toyota','Corolla XEi','Sedãs',2020,122500,58000,'Lajeado','RS','Sedã confortável e econômico. Anúncio demonstrativo.','https://images.unsplash.com/photo-1542362567-b07e54358753?w=900&q=80&auto=format&fit=crop'),
(3,'Jeep','Renegade Longitude','SUVs',2021,99900,64000,'Bom Retiro do Sul','RS','SUV para o dia a dia, dados fictícios.','https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=900&q=80&auto=format&fit=crop'),
(4,'Porsche','911 Carrera','Esportivos',2019,679900,28000,'Novo Hamburgo','RS','Carro esportivo de alto desempenho. Anúncio demonstrativo.','https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=900&q=80&auto=format&fit=crop'),
(5,'Audi','A3 Sedan','Sedãs',2018,112900,88000,'Bento Gonçalves','RS','Sedã moderno, anúncio fictício.','https://images.unsplash.com/photo-1511919884226-fd3cad34687c?w=900&q=80&auto=format&fit=crop'),
(1,'Fiat','Argo Drive','Hatches',2022,66900,43000,'Garibaldi','RS','Hatch compacto. Anúncio fictício.','https://images.unsplash.com/photo-1566939889291-d9e5b2e9488c?w=900&q=80&auto=format&fit=crop'),
(2,'Mercedes-Benz','C180','Sedãs',2017,129900,79000,'Porto Alegre','RS','Sedã com visual elegante. Anúncio fictício.','https://images.unsplash.com/photo-1502161254066-6c74afbf7b6f?w=900&q=80&auto=format&fit=crop'),
(3,'Chevrolet','S10 LTZ','Picapes',2020,169900,102000,'Santa Cruz do Sul','RS','Picape para trabalho e lazer. Anúncio demonstrativo.','https://images.unsplash.com/photo-1489824904134-891ab64532f1?w=900&q=80&auto=format&fit=crop'),
(4,'Volkswagen','Jetta GLI','Sedãs',2021,179900,49000,'Lajeado','RS','Sedã turbo esportivo. Anúncio demonstrativo.','https://images.unsplash.com/photo-1555215695-3004980ad54e?w=900&q=80&auto=format&fit=crop'),
(5,'Honda','HR-V EX','SUVs',2019,102900,81000,'Encantado','RS','SUV versátil para cidade. Anúncio fictício.','https://images.unsplash.com/photo-1542362567-b07e54358753?w=900&q=80&auto=format&fit=crop'),
(1,'Volkswagen','Gol GTS','Clássicos',1994,47900,152000,'Teutônia','RS','Hatch clássico para colecionadores. Anúncio demonstrativo.','https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=900&q=80&auto=format&fit=crop');
