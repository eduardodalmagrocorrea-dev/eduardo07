<?php
$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "formulario_ifsc";

$conn = new mysqli($servidor, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Erro ao conectar com o banco: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
