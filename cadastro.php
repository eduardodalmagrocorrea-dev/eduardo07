<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require "conexao.php";

    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = $_POST["senha"] ?? "";
    $cpf = trim($_POST["cpf"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");
    $nascimento = $_POST["nascimento"] ?? "";
    $genero = $_POST["genero"] ?? "";
    $cidade = trim($_POST["cidade"] ?? "");
    $estado = $_POST["estado"] ?? "";
    $curso = trim($_POST["curso"] ?? "");

    $erros = array();

    if (strlen($nome) < 3) $erros[] = "Digite seu nome.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = "Digite um email válido.";
    if (strlen($senha) < 6) $erros[] = "A senha precisa ter 6 caracteres ou mais.";
    if (!preg_match('/^\d{11}$/', preg_replace('/\D/', '', $cpf))) $erros[] = "CPF inválido.";
    if (!preg_match('/^\d{10,11}$/', preg_replace('/\D/', '', $telefone))) $erros[] = "Telefone inválido.";
    if ($nascimento == "") $erros[] = "Escolha a data de nascimento.";
    if ($genero == "") $erros[] = "Escolha o gênero.";
    if ($cidade == "") $erros[] = "Digite a cidade.";
    if ($estado == "") $erros[] = "Escolha o estado.";
    if ($curso == "") $erros[] = "Digite o curso.";

    if (count($erros) == 0) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios
        (nome, email, senha, cpf, telefone, nascimento, genero, cidade, estado, curso)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssss",
            $nome, $email, $senha_hash, $cpf, $telefone,
            $nascimento, $genero, $cidade, $estado, $curso
        );

        if ($stmt->execute()) {
            header("Location: index.php?cadastro=1");
            exit;
        } else {
            $erros[] = "Erro: email já cadastrado.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="caixa cadastro">
        <h1>CADASTRO</h1>

        <?php if (count($erros ?? array()) > 0) { ?>
            <div class="erro">
                <?php foreach ($erros as $erro) { ?>
                    <p><?php echo htmlspecialchars($erro); ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <form method="POST" action="cadastro.php">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Senha:</label>
            <input type="password" name="senha" minlength="6" required>

            <label>CPF:</label>
            <input type="text" name="cpf" placeholder="00000000000" required>

            <label>Telefone:</label>
            <input type="tel" name="telefone" placeholder="49999999999" required>

            <label>Data de nascimento:</label>
            <input type="date" name="nascimento" required>

            <label>Gênero:</label>
            <select name="genero" required>
                <option value="">Escolha</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>

            <label>Cidade:</label>
            <input type="text" name="cidade" required>

            <label>Estado:</label>
            <select name="estado" required>
                <option value="">Escolha</option>
                <option value="SC">Santa Catarina</option>
                <option value="RS">Rio Grande do Sul</option>
                <option value="PR">Paraná</option>
                <option value="SP">São Paulo</option>
                <option value="Outro">Outro</option>
            </select>

            <label>Curso:</label>
            <input type="text" name="curso" placeholder="Desenvolvimento de Sistemas" required>

            <p>
                <input type="checkbox" required>
                Aceito os termos.
            </p>

            <input type="submit" value="CADASTRAR">
        </form>

        <p><a href="index.php">Voltar para o login</a></p>
    </div>
</body>
</html>
