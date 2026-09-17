<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="caixa">
        <h1>LOGIN</h1>

        <?php if (isset($_GET["erro"])) { ?>
            <p class="erro">Email ou senha errados.</p>
        <?php } ?>

        <?php if (isset($_GET["cadastro"])) { ?>
            <p class="ok">Cadastro realizado!</p>
        <?php } ?>

        <form action="login.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" required>

            <input type="submit" value="ENTRAR">
        </form>

        <p>Não tem cadastro? <a href="cadastro.php">Clique aqui</a></p>
    </div>
</body>
</html>
