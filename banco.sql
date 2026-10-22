CREATE DATABASE IF NOT EXISTS projetosemestre;
USE projetosemestre;

CREATE TABLE IF NOT EXISTS usuarios (
 id_usuario INT AUTO_INCREMENT PRIMARY KEY,
 nome VARCHAR(100) NOT NULL,
 email VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS veiculos (
 id_veiculo INT AUTO_INCREMENT PRIMARY KEY,
 id_usuario INT NOT NULL,
 marca VARCHAR(50) NOT NULL,
 modelo VARCHAR(50) NOT NULL,
 ano INT NOT NULL,
 preco DECIMAL(10,2) NOT NULL,
 FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

-- Insira os dados apenas na primeira importacao.
INSERT INTO usuarios (nome,email) VALUES
('Bruno','bruno@exemplo.com'),
('Jean','jean@exemplo.com'),
('Carlos','carlos@exemplo.com'),
('Ana','ana@exemplo.com'),
('Pedro','pedro@exemplo.com');

INSERT INTO veiculos (id_usuario,marca,modelo,ano,preco) VALUES
(1,'Volkswagen','Gol',2010,25000),
(2,'Chevrolet','Corsa',2008,19000),
(3,'Fiat','Uno',2012,23000),
(4,'Ford','Fiesta',2014,32000),
(5,'Honda','Civic',2015,65000);
