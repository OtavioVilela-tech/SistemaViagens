<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Paciente</title>

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container">

    <h1>Cadastrar Paciente</h1>

    <p>Informe os dados da viagem e da consulta.</p>

    <hr>

    <form action="salvar.php" method="POST">

        <label for="nome">Nome do paciente</label>

        <input
            type="text"
            id="nome"
            name="nome"
            placeholder="Digite o nome completo"
            required
        >

        <br><br>


        <label for="telefone">Telefone</label>

        <input
            type="tel"
            id="telefone"
            name="telefone"
            placeholder="(35) 99999-9999"
            maxlength="15"
            required
        >

        <br><br>


        <label for="data_viagem">Data da viagem</label>

        <input
            type="date"
            id="data_viagem"
            name="data_viagem"
            required
        >

        <br><br>


        <label for="horario_consulta">Horário da consulta</label>

        <input
            type="time"
            id="horario_consulta"
            name="horario_consulta"
            required
        >

        <br><br>


        <label for="cidade_destino">Cidade de destino</label>

        <input
            type="text"
            id="cidade_destino"
            name="cidade_destino"
            placeholder="Ex: Varginha"
            required
        >

        <br><br>


        <label for="local_espera">Onde vai esperar?</label>

        <select
            id="local_espera"
            name="local_espera"
            required
            onchange="mostrarEndereco()"
        >

            <option value="">Selecione</option>

            <option value="Praça">Praça</option>

            <option value="PAM">PAM</option>

            <option value="Ginásio">Ginásio</option>

            <option value="Endereço próprio">
                Endereço próprio
            </option>

        </select>

        <br><br>


        <div id="campo-endereco" style="display: none;">

            <label for="endereco_espera">
                Endereço onde vai esperar
            </label>

            <input
                type="text"
                id="endereco_espera"
                name="endereco_espera"
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

            <option value="">Selecione</option>

            <option value="Sim">Sim</option>

            <option value="Não">Não</option>

        </select>

        <br><br>


        <label for="local_consulta">
            Local da consulta
        </label>

        <input
            type="text"
            id="local_consulta"
            name="local_consulta"
            placeholder="Ex: Hospital Bom Pastor"
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

            <option value="">Selecione</option>

            <option value="Consulta">Consulta</option>

            <option value="Exame">Exame</option>

            <option value="Retorno">Retorno</option>

            <option value="Outro">Outro</option>

        </select>

        <br><br>


        <label for="especialidade">
            Especialidade
        </label>

        <input
            type="text"
            id="especialidade"
            name="especialidade"
            placeholder="Ex: Cardiologia"
        >

        <br><br>


        <label for="observacao">
            Observação
        </label>

        <textarea
            id="observacao"
            name="observacao"
            placeholder="Digite alguma observação..."
        ></textarea>

        <br><br>


        <button type="submit">
            Cadastrar paciente
        </button>

        <a
            href="dashboard.php"
            class="botao limpar"
        >
            Voltar
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

        endereco.value = "";

    }

}

</script>

</body>

</html>