<?php

include "../infra/conexao.php";

$id = $_POST["id"] ?? null;
$nome = $_POST["nome"] ?? '';
$preco = $_POST["preco"] ?? 0;
$categoria = $_POST["categoria"] ?? '';
$descricao = $_POST["descricao"] ?? '';
$usuario_id = $_POST["usuario_id"] ?? null;

if (!$id) {
    die("ID do prato não informado.");
}

$sql = "UPDATE pratos SET nome = ?, descricao = ?, preco = ?, categoria = ?, usuario_id = ? WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssdsii", $nome, $descricao, $preco, $categoria, $usuario_id, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

header("Location: ../index.php");
exit;

?>

<header>
    <link rel="stylesheet" href="style/styles.css">
</header>

