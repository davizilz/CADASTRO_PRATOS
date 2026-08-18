<?php

include "infra/conexao.php";

$filtro_usuario = $_GET['usuario_id'] ?? null;

if ($filtro_usuario) {
    $stmt = $conexao->prepare("
        SELECT pratos.*, usuarios.nome AS usuario_nome
        FROM prato
        INNER JOIN usuario ON prato.id_usuario = usuario.id
        WHERE prato.id_usuario = ?
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
            <input type="text" name="preco" required>
            <br>
            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" required>
            <br>
            <label for="descricao">Descrição:</label>
            <input type="text" name="descricao" required>
            <br>
            <label for="id_usuario">Cadastrado por:</label>
            <select name="id_usuario" required>
                <option value="">Selecione o usuário</option>
                <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                    <option value="<?= $usuario['id'] ?>"><?= $usuario['nome'] ?></option>
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
                    <option value="<?= $usuario['id'] ?>" <?= ($filtro_usuario == $usuario['id']) ? 'selected' : '' ?>>
                        <?= $usuario['nome'] ?>
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
                    <td><?= $prato['nome'] ?></td>
                    <td><?= $prato['descricao'] ?></td>
                    <td>R$ <?= number_format($prato['preco'], 2, ',', '.') ?></td>
                    <td><?= $prato['categoria'] ?></td>
                    <td><?= $prato['usuario_id'] ?></td>
                    <td>
                        <a href="public/editar.php?id=<?= $prato['id'] ?>">Editar</a>
                        |
                        <a href="public/excluir.php?id=<?= $prato['id'] ?>" onclick="return confirm('Excluir este prato?')">Excluir</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

    </main>
</body>

</html>