<?php

require_once "config/conexao.php";


$id = $_GET["id"] ?? 0;


$sql = "
    SELECT *
    FROM pacientes
    WHERE id = ?
";


$stmt = $conexao->prepare($sql);


$stmt->bind_param(
    "i",
    $id
);


$stmt->execute();


$resultado =
    $stmt->get_result();


$paciente =
    $resultado->fetch_assoc();


if (!$paciente) {

    die("Paciente não encontrado.");

}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Editar Paciente</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>

<div class="container">


    <h1>
        Editar Paciente
    </h1>


    <hr>


    <form
        action="atualizar.php"
        method="POST"
    >


        <input
            type="hidden"
            name="id"
            value="<?= $paciente["id"] ?>"
        >


        <label for="nome">
            Nome do paciente
        </label>

        <input
            type="text"
            id="nome"
            name="nome"
            value="<?= htmlspecialchars($paciente["nome"]) ?>"
            required
        >

        <br><br>


        <label for="telefone">
            Telefone
        </label>

        <input
            type="tel"
            id="telefone"
            name="telefone"
            value="<?= htmlspecialchars($paciente["telefone"]) ?>"
            maxlength="15"
            required
        >

        <br><br>


        <label for="data_viagem">
            Data da viagem
        </label>

        <input
            type="date"
            id="data_viagem"
            name="data_viagem"
            value="<?= htmlspecialchars($paciente["data_viagem"]) ?>"
            required
        >

        <br><br>


        <label for="horario_consulta">
            Horário da consulta
        </label>

        <input
            type="time"
            id="horario_consulta"
            name="horario_consulta"
            value="<?= htmlspecialchars($paciente["horario_consulta"]) ?>"
            required
        >

        <br><br>


        <label for="cidade_destino">
            Cidade de destino
        </label>

        <input
            type="text"
            id="cidade_destino"
            name="cidade_destino"
            value="<?= htmlspecialchars($paciente["cidade_destino"]) ?>"
            required
        >

        <br><br>


        <label for="local_espera">
            Onde vai esperar?
        </label>

        <select
            id="local_espera"
            name="local_espera"
            required
            onchange="mostrarEndereco()"
        >

            <option
                value="Praça"
                <?= $paciente["local_espera"] == "Praça" ? "selected" : "" ?>
            >
                Praça
            </option>


            <option
                value="PAM"
                <?= $paciente["local_espera"] == "PAM" ? "selected" : "" ?>
            >
                PAM
            </option>


            <option
                value="Ginásio"
                <?= $paciente["local_espera"] == "Ginásio" ? "selected" : "" ?>
            >
                Ginásio
            </option>


            <option
                value="Endereço próprio"
                <?= $paciente["local_espera"] == "Endereço próprio" ? "selected" : "" ?>
            >
                Endereço próprio
            </option>

        </select>

        <br><br>


        <div
            id="campo-endereco"
            style="<?= $paciente["local_espera"] == "Endereço próprio" ? "display:block;" : "display:none;" ?>"
        >

            <label for="endereco_espera">
                Endereço onde vai esperar
            </label>

            <input
                type="text"
                id="endereco_espera"
                name="endereco_espera"
                value="<?= htmlspecialchars($paciente["endereco_espera"] ?? "") ?>"
                placeholder="Rua, número, bairro"
            >

            <br><br>

        </div>


        <label for="acompanhado">
            Vai acompanhado?
        </label>

        <select
            id="acompanhado"
            name="acompanhado"
            required
        >

            <option
                value="Sim"
                <?= $paciente["acompanhado"] == "Sim" ? "selected" : "" ?>
            >
                Sim
            </option>


            <option
                value="Não"
                <?= $paciente["acompanhado"] == "Não" ? "selected" : "" ?>
            >
                Não
            </option>

        </select>

        <br><br>


        <label for="local_consulta">
            Local da consulta
        </label>

        <input
            type="text"
            id="local_consulta"
            name="local_consulta"
            value="<?= htmlspecialchars($paciente["local_consulta"]) ?>"
            required
        >

        <br><br>


        <label for="tipo_atendimento">
            Tipo de atendimento
        </label>

        <select
            id="tipo_atendimento"
            name="tipo_atendimento"
            required
        >

            <option
                value="Consulta"
                <?= $paciente["tipo_atendimento"] == "Consulta" ? "selected" : "" ?>
            >
                Consulta
            </option>


            <option
                value="Exame"
                <?= $paciente["tipo_atendimento"] == "Exame" ? "selected" : "" ?>
            >
                Exame
            </option>


            <option
                value="Retorno"
                <?= $paciente["tipo_atendimento"] == "Retorno" ? "selected" : "" ?>
            >
                Retorno
            </option>


            <option
                value="Outro"
                <?= $paciente["tipo_atendimento"] == "Outro" ? "selected" : "" ?>
            >
                Outro
            </option>

        </select>

        <br><br>


        <label for="especialidade">
            Especialidade
        </label>

        <input
            type="text"
            id="especialidade"
            name="especialidade"
            value="<?= htmlspecialchars($paciente["especialidade"] ?? "") ?>"
        >

        <br><br>


        <label for="observacao">
            Observação
        </label>

        <textarea
            id="observacao"
            name="observacao"
        ><?= htmlspecialchars($paciente["observacao"] ?? "") ?></textarea>

        <br><br>


        <button type="submit">
            Salvar alterações
        </button>


        <a
            href="dashboard.php"
            class="botao limpar"
        >
            Cancelar
        </a>


    </form>

</div>


<script>

function mostrarEndereco() {

    const local =
        document.getElementById("local_espera").value;

    const campo =
        document.getElementById("campo-endereco");

    const endereco =
        document.getElementById("endereco_espera");


    if (local === "Endereço próprio") {

        campo.style.display = "block";

        endereco.required = true;

    } else {

        campo.style.display = "none";

        endereco.required = false;

    }

}

</script>

</body>

</html>