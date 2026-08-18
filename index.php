<?php

include "infra/conexao.php";

$filtro_usuario = $_GET['usuario_id'] ?? null;

if ($filtro_usuario) {
    $stmt = $conexao->prepare("
        SELECT pratos.*, usuarios.nome AS usuario_nome
        FROM pratos
        INNER JOIN usuarios ON pratos.id_usuario = usuarios.id
        WHERE pratos.id_usuario = ?
    ");
    $stmt->bind_param("i", $filtro_usuario);
    $stmt->execute();
    $pratos = $stmt->get_result();
} else {
    $sql = "SELECT * FROM pratos";
    $pratos = mysqli_query($conexao, $sql);
}

$usuarios = mysqli_query($conexao, "SELECT * FROM usuarios");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Restaurante</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <header>
        <h1>CRUD - Restaurante</h1>
    </header>
    <main>
        <h2>Adicione um Prato!</h2>
        <form action="public/cadastrar.php" method="POST">
            <label for="prato">prato:</label>
            <input type="text" name="prato">
            <br>
            <label for="preco">Preço:</label>
            <input type="text" name="preco">
            <br>
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria">
            <br>
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao">
            <br>
            <button type="submit">Cadastrar</button>
            <br>

        </form>