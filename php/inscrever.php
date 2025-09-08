<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $pais = $_POST["pais"];

    // Verificações de tipo
    if (!is_string($cpf) || !preg_match('/^\d{11}$/', $cpf)) {
        echo "CPF inválido.";
        exit;
    }
    if (!is_string($nome) || empty($nome)) {
        echo "Nome inválido.";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email inválido.";
        exit;
    }
    if (!is_string($senha) || strlen($senha) < 6) {
        echo "Senha inválida. Deve ter pelo menos 6 caracteres.";
        exit;
    }
    if (!is_string($telefone) || !preg_match('/^\d{10,11}$/', $telefone)) {
        echo "Telefone inválido.";
        exit;
    }
    if (!is_string($endereco) || empty($endereco)) {
        echo "Endereço inválido.";
        exit;
    }
    if (!is_string($cidade) || empty($cidade)) {
        echo "Cidade inválida.";
        exit;
    }
    if (!is_string($estado) || empty($estado)) {
        echo "Estado inválido.";
        exit;
    }
    if (!is_string($pais) || empty($pais)) {
        echo "País inválido.";
        exit;
    }


    echo "Inscrição realizada com sucesso!";
    header("Location: inscricao.html");
}