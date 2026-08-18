<?php
include "../infra/conexao.php";
$id = $_GET["id"];
$sql = "DELETE FROM pratos WHERE id=$id";
mysqli_query($conexao,$sql);
header("Location: ../index.php");
?>