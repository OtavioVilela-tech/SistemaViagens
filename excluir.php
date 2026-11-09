<?php

require_once "config/conexao.php";


$id = $_GET["id"] ?? 0;


$sql = "
    DELETE FROM pacientes
    WHERE id = ?
";


$stmt = $conexao->prepare($sql);


$stmt->bind_param(
    "i",
    $id
);


$stmt->execute();


$stmt->close();

$conexao->close();


header("Location: dashboard.php");

exit;

?>