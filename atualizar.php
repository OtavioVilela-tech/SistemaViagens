<?php

require_once "config/conexao.php";


$id = $_POST["id"] ?? "";

$nome = $_POST["nome"] ?? "";

$telefone = $_POST["telefone"] ?? "";

$data_viagem = $_POST["data_viagem"] ?? "";

$horario_consulta = $_POST["horario_consulta"] ?? "";

$cidade_destino = $_POST["cidade_destino"] ?? "";

$local_espera = $_POST["local_espera"] ?? "";

$endereco_espera = $_POST["endereco_espera"] ?? "";

$acompanhado = $_POST["acompanhado"] ?? "";

$local_consulta = $_POST["local_consulta"] ?? "";

$tipo_atendimento = $_POST["tipo_atendimento"] ?? "";

$especialidade = $_POST["especialidade"] ?? "";

$observacao = $_POST["observacao"] ?? "";


if ($local_espera !== "Endereço próprio") {

    $endereco_espera = "";

}


$sql = "
    UPDATE pacientes

    SET
        nome = ?,
        telefone = ?,
        data_viagem = ?,
        horario_consulta = ?,
        cidade_destino = ?,
        local_espera = ?,
        endereco_espera = ?,
        acompanhado = ?,
        local_consulta = ?,
        tipo_atendimento = ?,
        especialidade = ?,
        observacao = ?

    WHERE id = ?
";


$stmt = $conexao->prepare($sql);


if (!$stmt) {

    die(
        "Erro ao preparar atualização: "
        . $conexao->error
    );

}


$stmt->bind_param(

    "ssssssssssssi",

    $nome,
    $telefone,
    $data_viagem,
    $horario_consulta,
    $cidade_destino,
    $local_espera,
    $endereco_espera,
    $acompanhado,
    $local_consulta,
    $tipo_atendimento,
    $especialidade,
    $observacao,
    $id

);


if ($stmt->execute()) {

    header("Location: dashboard.php");

    exit;

} else {

    echo "Erro ao atualizar: "
        . $stmt->error;

}


$stmt->close();

$conexao->close();

?>