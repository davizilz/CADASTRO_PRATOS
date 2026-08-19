<?php

include "infra/conexao.php";

function h($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

$filtro_usuario = $_GET['usuario_id'] ?? null;

if ($filtro_usuario) {
    $sql = "SELECT pratos.*, usuarios.nome AS nome_usuario
            FROM pratos
            LEFT JOIN usuarios ON usuarios.id = pratos.usuario_id
            WHERE pratos.usuario_id = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $filtro_usuario);
    mysqli_stmt_execute($stmt);
    $pratos = mysqli_stmt_get_result($stmt);
} else {
    $sql = "SELECT pratos.*, usuarios.nome AS nome_usuario
            FROM pratos
            LEFT JOIN usuarios ON usuarios.id = pratos.usuario_id";
    $pratos = mysqli_query($conexao, $sql);
}

$usuarios = mysqli_query($conexao, "SELECT * FROM usuarios");

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Restaurante</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <header>
        <h1>CRUD - Restaurante</h1>
        <link rel="stylesheet" href="style/style.css"> 
    </header>
    <main>

        <h2>Cadastrar Usuário</h2>
        <form action="public/cadastrar_usuario.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
            <br>
            <label for="email">E-mail:</label>
            <input type="email" name="email" required>
            <br>
            <button type="submit">Cadastrar Usuário</button>
        </form>

        <hr>

        <h2>Adicione um Prato!</h2>
        <form action="public/cadastrar_prato.php" method="POST">
            <label for="prato">Prato:</label>
            <input type="text" name="prato" required>
            <br>
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" name="preco" required>
            <br>
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" required>
            <br>
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" required>
            <br>
            <label for="usuario_id">Cadastrado por:</label>
            <select name="usuario_id" required>
                <option value="">Selecione o usuário</option>
                <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                    <option value="<?= h($usuario['id']) ?>"><?= h($usuario['nome']) ?></option>
                <?php } ?>
            </select>
            <br>
            <button type="submit">Cadastrar</button>
        </form>

        <hr>

        <h2>Filtrar por Usuário</h2>
        <form action="index.php" method="GET">
            <select name="usuario_id" onchange="this.form.submit()">
                <option value="">Todos os usuários</option>
                <?php
                mysqli_data_seek($usuarios, 0);
                while ($usuario = mysqli_fetch_assoc($usuarios)) {
                ?>
                    <option value="<?= h($usuario['id']) ?>" <?= ($filtro_usuario == $usuario['id']) ? 'selected' : '' ?>>
                        <?= h($usuario['nome']) ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <hr>

        <h2>Pratos Cadastrados</h2>
        <table border="1">
            <tr>
                <th>Prato</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Cadastrado por</th>
                <th>Ações</th>
            </tr>
            <?php while ($prato = mysqli_fetch_assoc($pratos)) { ?>
                <tr>
                    <td><?= h($prato['nome']) ?></td>
                    <td><?= h($prato['descricao']) ?></td>
                    <td>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>
                    <td><?= h($prato['categoria']) ?></td>
                    <td><?= h($prato['nome_usuario'] ?? '—') ?></td>
                    <td>
                        <a href="public/editar.php?id=<?= h($prato['id']) ?>">Editar</a>
                        |
                        <a href="public/excluir.php?id=<?= h($prato['id']) ?>" onclick="return confirm('Excluir este prato?')">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </main>
</body>

</html>