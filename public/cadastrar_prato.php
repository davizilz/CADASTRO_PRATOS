<?php
 
include "../infra/conexao.php";
 
$nome = $_POST["prato"];
$preco = $_POST["preco"];
$categoria = $_POST["categoria"];
$descricao = $_POST["descricao"];
$id_usuario = $_POST["id_usuario"];

$sql = "INSERT INTO pratos (nome, preco, categoria, descricao, usuario_id) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "sssdd", $nome, $preco, $categoria, $descricao, $id_usuario);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
 
header("Location: ../index.php");
?>

