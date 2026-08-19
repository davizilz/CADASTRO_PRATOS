<?php

include "../infra/conexao.php";

$id = $_GET["id"] ?? null;

if (!$id) {
    die("ID não informado.");
}

$sql = "SELECT * FROM pratos WHERE id = ?";
$stmt = mysqli_prepare($conexao, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$prato = mysqli_fetch_assoc($resultado);

if (!$prato) {
    die("Prato não encontrado.");
}

$usuarios = mysqli_query($conexao, "SELECT * FROM usuarios");

function h($s) {
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD - Pratos</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
    <header>
        <h1>CRUD - Pratos</h1>
    </header>

    <main>
        <h2>Editar Prato</h2>
        <form action="atualizar.php" method="POST">
            <input type="hidden" name="id" value="<?= h($prato['id']) ?>">

            <label for="nome">Nome:</label>
            <input type="text" name="nome" id="nome" value="<?= h($prato['nome']) ?>" required><br>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required><?= h($prato['descricao']) ?></textarea><br>

            <label for="preco">Preço:</label>
            <input type="number" step="0.01" name="preco" id="preco" value="<?= h($prato['preco']) ?>" required><br>

            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria" value="<?= h($prato['categoria']) ?>" required><br>

            <label for="usuario_id">Cadastrado por:</label>
            <select name="usuario_id" id="usuario_id" required>
                <option value="">Selecione o usuário</option>
                <?php while ($usuario = mysqli_fetch_assoc($usuarios)) { ?>
                    <option value="<?= h($usuario['id']) ?>" <?= ($prato['usuario_id'] == $usuario['id']) ? 'selected' : '' ?>>
                        <?= h($usuario['nome']) ?>
                    </option>
                <?php } ?>
            </select><br>

            <input type="submit" value="Atualizar">
        </form>

        <br>

        <a href="../index.php">
            <button>Voltar para o início</button>
        </a>
    </main>

</body>

</html>