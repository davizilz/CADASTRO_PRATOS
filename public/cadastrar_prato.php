<?php
 
include "../infra/conexao.php";
 
$nome = $_POST["prato"];
$preco = $_POST["preco"];
$categoria = $_POST["categoria"];
$descricao = $_POST["descricao"];
$usuario_id = $_POST["usuario_id"];

$sql = "INSERT INTO pratos (nome, preco, categoria, descricao, usuario_id) VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "sssss", $nome, $preco, $categoria, $descricao, $usuario_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
 
header("Location: ../index.php");
?>

