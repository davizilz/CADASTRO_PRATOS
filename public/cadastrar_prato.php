<?php
 
include "../infra/conexao.php";
 
$prato = $_POST["prato"];
$preco = $_POST["preco"];
$categoria = $_POST["categoria"];
$descricao = $_POST["descricao"];
 
$sql = "INSERT INTO pratos (prato, preco, categoria, descricao) VALUES (?, ?, ?, ?)";
 
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "ssi", $titulo, $autor, $ano);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
 
header("Location: ../index.php");
?>

