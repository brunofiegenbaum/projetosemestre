USE projetosemestre;
-- Execute somente se as colunas ainda nao existirem.
ALTER TABLE veiculos
ADD COLUMN quilometragem INT NOT NULL DEFAULT 0,
ADD COLUMN foto VARCHAR(255) DEFAULT NULL;
