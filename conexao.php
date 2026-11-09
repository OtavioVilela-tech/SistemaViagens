<?php

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "sistema_viagens_novo";

$conexao = new mysqli(
    $servidor,
    $usuario,
    $senha,
    $banco
);

if ($conexao->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conexao->connect_error);
}

$conexao->set_charset("utf8mb4");

?>