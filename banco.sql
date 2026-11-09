CREATE DATABASE IF NOT EXISTS sistema_viagens_novo
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE sistema_viagens_novo;

CREATE TABLE IF NOT EXISTS pacientes (

    id INT AUTO_INCREMENT PRIMARY KEY,

    nome VARCHAR(150) NOT NULL,

    telefone VARCHAR(20) NOT NULL,

    data_viagem DATE NOT NULL,

    horario_consulta TIME NOT NULL,

    cidade_destino VARCHAR(100) NOT NULL,

    local_espera VARCHAR(50) NOT NULL,

    endereco_espera VARCHAR(250),

    acompanhado VARCHAR(10) NOT NULL,

    local_consulta VARCHAR(150) NOT NULL,

    tipo_atendimento VARCHAR(50) NOT NULL,

    especialidade VARCHAR(100),

    observacao TEXT,

    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);