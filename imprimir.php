<?php

require_once "config/conexao.php";


$data = $_GET["data"] ?? "";


if ($data === "") {

    die("Data da viagem não informada.");

}


$sql = "
    SELECT *
    FROM pacientes
    WHERE data_viagem = ?

    ORDER BY
        cidade_destino ASC,
        horario_consulta ASC,
        nome ASC
";


$stmt = $conexao->prepare($sql);


$stmt->bind_param(
    "s",
    $data
);


$stmt->execute();


$resultado =
    $stmt->get_result();


$total =
    $resultado->num_rows;

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <title>
        Viagens do dia
    </title>


    <style>

        body {

            font-family: Arial, sans-serif;

            margin: 30px;

            color: #222;

        }


        .cabecalho {

            text-align: center;

            margin-bottom: 25px;

        }


        .cabecalho h1 {

            margin-bottom: 5px;

        }


        .cabecalho h2 {

            margin-top: 5px;

        }


        .cabecalho p {

            margin: 5px;

        }


        .informacoes {

            margin-bottom: 20px;

        }


        table {

            width: 100%;

            border-collapse: collapse;

            font-size: 11px;

        }


        th {

            background: #eeeeee;

            border: 1px solid #999;

            padding: 7px;

            text-align: left;

        }


        td {

            border: 1px solid #999;

            padding: 7px;

        }


        .total {

            margin-top: 20px;

            font-weight: bold;

        }


        .botoes {

            margin-bottom: 20px;

        }


        .botao-imprimir {

            padding: 10px 18px;

            background: #2563eb;

            color: white;

            border: none;

            border-radius: 5px;

            cursor: pointer;

        }


        @media print {

            .botoes {

                display: none;

            }


            body {

                margin: 10px;

            }


            table {

                font-size: 9px;

            }


            th,
            td {

                padding: 5px;

            }

        }

    </style>

</head>


<body>


<div class="botoes">

    <button
        class="botao-imprimir"
        onclick="window.print()"
    >
        🖨️ Imprimir
    </button>

</div>


<div class="cabecalho">

    <h1>
        SECRETARIA MUNICIPAL DE SAÚDE
    </h1>


    <h2>
        Relação de Pacientes - Viagem
    </h2>


    <p>

        <strong>
            Data da viagem:
        </strong>

        <?= date(
            "d/m/Y",
            strtotime($data)
        ) ?>

    </p>

</div>


<div class="informacoes">

    <strong>
        Total de pacientes:
    </strong>

    <?= $total ?>

</div>


<?php if ($total > 0): ?>


<table>

    <thead>

        <tr>

            <th>Paciente</th>

            <th>Telefone</th>

            <th>Horário</th>

            <th>Cidade</th>

            <th>Onde espera</th>

            <th>Endereço</th>

            <th>Acompanhado</th>

            <th>Local da consulta</th>

            <th>Atendimento</th>

            <th>Especialidade</th>

            <th>Observação</th>

        </tr>

    </thead>


    <tbody>


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
                <?= htmlspecialchars(
                    $paciente["observacao"] ?? ""
                ) ?>
            </td>

        </tr>


    <?php endwhile; ?>


    </tbody>

</table>


<?php else: ?>


<p>
    Não existem pacientes cadastrados para esta data.
</p>


<?php endif; ?>


<p class="total">

    Total de pacientes:
    <?= $total ?>

</p>


</body>

</html>


<?php

$stmt->close();

$conexao->close();

?>