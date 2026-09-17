<?php
session_start();
require "conexao.php";

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $senha == "") {
    header("Location: index.php?erro=1");
    exit;
}

$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

if ($usuario && password_verify($senha, $usuario["senha"])) {
    $_SESSION["usuario"] = $usuario["nome"];
    $_SESSION["id_usuario"] = $usuario["id"];
    header("Location: cadastro.php");
    exit;
}

header("Location: index.php?erro=1");
exit;
