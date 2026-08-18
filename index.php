
<?php

include "infra/conexao.php";
$prato = mysqli_query($conexao, "SELECT * FROM prato");

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
            <label for="ano">Ano de Publicação:</label>
            <input type="number" name="ano">
            <br>
            <button type="submit">Cadastrar</button>
        </form>