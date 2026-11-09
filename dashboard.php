<?php

require_once "config/conexao.php";


$pacienteBusca = $_GET["paciente"] ?? "";

$dataBusca = $_GET["data"] ?? "";

$cidadeBusca = $_GET["cidade"] ?? "";


$sql = "
    SELECT
        p.*,

        (
            SELECT COUNT(*)
            FROM pacientes p2
            WHERE LOWER(TRIM(p2.nome))
                = LOWER(TRIM(p.nome))
        ) AS quantidade_viagens

    FROM pacientes p

    WHERE 1=1
";


$parametros = [];

$tipos = "";


if ($pacienteBusca !== "") {

    $sql .= " AND p.nome LIKE ? ";

    $parametros[] =
        "%" . $pacienteBusca . "%";

    $tipos .= "s";

}


if ($dataBusca !== "") {

    $sql .= " AND p.data_viagem = ? ";

    $parametros[] = $dataBusca;

    $tipos .= "s";

}


if ($cidadeBusca !== "") {

    $sql .= " AND p.cidade_destino LIKE ? ";

    $parametros[] =
        "%" . $cidadeBusca . "%";

    $tipos .= "s";

}


$sql .= "
    ORDER BY
        p.data_viagem ASC,
        p.horario_consulta ASC,
        p.cidade_destino ASC,
        p.nome ASC
";


$stmt = $conexao->prepare($sql);


if (!$stmt) {

    die(
        "Erro na consulta: "
        . $conexao->error
    );

}


if (!empty($parametros)) {

    $stmt->bind_param(
        $tipos,
        ...$parametros
    );

}


$stmt->execute();


$resultado = $stmt->get_result();


$totalViagens = 0;


if ($pacienteBusca !== "") {

    $sqlTotal = "
        SELECT COUNT(*) AS total
        FROM pacientes
        WHERE nome LIKE ?
    ";


    $stmtTotal =
        $conexao->prepare($sqlTotal);


    $buscaTotal =
        "%" . $pacienteBusca . "%";


    $stmtTotal->bind_param(
        "s",
        $buscaTotal
    );


    $stmtTotal->execute();


    $resultadoTotal =
        $stmtTotal->get_result();


    $dadosTotal =
        $resultadoTotal->fetch_assoc();


    $totalViagens =
        $dadosTotal["total"];


    $stmtTotal->close();

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

    <title>Sistema de Viagens</title>

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>

<div class="container grande">


    <div class="topo">

        <div>

            <h1>
                Sistema de Viagens
            </h1>

            <p>
                Controle de pacientes, viagens e consultas.
            </p>

        </div>


        <div>

            <a
                href="cadastro.php"
                class="botao"
            >
                + Cadastrar paciente
            </a>

        </div>

    </div>


    <div class="filtros">

        <h2>
            Consultar viagens
        </h2>


        <form
            action="dashboard.php"
            method="GET"
        >


            <div class="filtros-campos">


                <div>

                    <label for="paciente">
                        Nome do paciente
                    </label>

                    <input
                        type="text"
                        id="paciente"
                        name="paciente"
                        value="<?= htmlspecialchars($pacienteBusca) ?>"
                        placeholder="Digite o nome"
                    >

                </div>


                <div>

                    <label for="data">
                        Data da viagem
                    </label>

                    <input
                        type="date"
                        id="data"
                        name="data"
                        value="<?= htmlspecialchars($dataBusca) ?>"
                    >

                </div>


                <div>

                    <label for="cidade">
                        Cidade
                    </label>

                    <input
                        type="text"
                        id="cidade"
                        name="cidade"
                        value="<?= htmlspecialchars($cidadeBusca) ?>"
                        placeholder="Digite a cidade"
                    >

                </div>


            </div>


            <button type="submit">
                🔎 Consultar
            </button>


            <a
                href="dashboard.php"
                class="botao limpar"
            >
                Limpar
            </a>


        </form>

    </div>


    <?php if ($dataBusca !== ""): ?>

        <div class="resultado-busca">

            <strong>
                Viagens do dia:
            </strong>

            <?= date(
                "d/m/Y",
                strtotime($dataBusca)
            ) ?>


            <br><br>


            <a
                href="imprimir.php?data=<?= urlencode($dataBusca) ?>"
                target="_blank"
                class="botao"
            >
                🖨️ Imprimir viagens do dia
            </a>

        </div>

    <?php endif; ?>


    <?php if ($pacienteBusca !== ""): ?>

        <div class="resultado-busca">

            <strong>
                Quantidade de viagens encontradas:
            </strong>

            <?= $totalViagens ?>

        </div>

    <?php endif; ?>


    <div class="tabela-container">


        <table>


            <thead>

                <tr>

                    <th>Paciente</th>

                    <th>Telefone</th>

                    <th>Data</th>

                    <th>Horário</th>

                    <th>Cidade</th>

                    <th>Onde espera</th>

                    <th>Endereço</th>

                    <th>Acompanhado?</th>

                    <th>Local da consulta</th>

                    <th>Atendimento</th>

                    <th>Especialidade</th>

                    <th>Viagens</th>

                    <th>Ações</th>

                </tr>

            </thead>


            <tbody>


            <?php if ($resultado->num_rows > 0): ?>


                <?php while ($paciente = $resultado->fetch_assoc()): ?>


                    <tr>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["nome"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["telefone"]
                            ) ?>
                        </td>


                        <td>
                            <?= date(
                                "d/m/Y",
                                strtotime(
                                    $paciente["data_viagem"]
                                )
                            ) ?>
                        </td>


                        <td>
                            <?= date(
                                "H:i",
                                strtotime(
                                    $paciente["horario_consulta"]
                                )
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["cidade_destino"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["local_espera"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["endereco_espera"] ?? ""
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["acompanhado"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["local_consulta"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["tipo_atendimento"]
                            ) ?>
                        </td>


                        <td>
                            <?= htmlspecialchars(
                                $paciente["especialidade"] ?? ""
                            ) ?>
                        </td>


                        <td>
                            <?= $paciente["quantidade_viagens"] ?>
                        </td>


                        <td>

                            <a
                                href="editar.php?id=<?= $paciente["id"] ?>"
                                class="editar"
                            >
                                Editar
                            </a>


                            <a
                                href="excluir.php?id=<?= $paciente["id"] ?>"
                                class="excluir"
                                onclick="return confirmarExclusao();"
                            >
                                Excluir
                            </a>

                        </td>


                    </tr>


                <?php endwhile; ?>


            <?php else: ?>


                <tr>

                    <td
                        colspan="13"
                        style="text-align: center;"
                    >
                        Nenhum paciente encontrado.
                    </td>

                </tr>


            <?php endif; ?>


            </tbody>

        </table>

    </div>

</div>


<script src="js/script.js"></script>

</body>

</html>


<?php

$stmt->close();

$conexao->close();

?>