<?php
include '../conexao.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $endereco = $_POST["endereco"];
    $pais = $_POST["pais"];
    $titulacao = $_POST["titulacao"] ?? '';
    $instituicao = $_POST["instituicao"] ?? '';
  
    // Salvar no banco de dados
    try {
        $conn = mysqlConnect();
       $stmt = $conn->prepare("
        INSERT INTO PARTICIPANTES 
        (cpf, nome, email, senha, telefone, endereco, cidade, estado, pais, titulacao, instituicao) 
        VALUES (:cpf, :nome, :email, :senha, :telefone, :endereco, :cidade, :estado, :pais, :titulacao, :instituicao)
    ");


    if ($stmt->execute([
            ':cpf' => $cpf,
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':telefone' => $telefone,
            ':endereco' => $endereco,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':pais' => $pais,
            ':titulacao' => $titulacao,
            ':instituicao' => $instituicao
        ])) {
        header("Location: ../inscricao.html?abrirModal=true");
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    } catch (Exception $e) {
        echo "Erro ao salvar no banco de dados: " . $e->getMessage();
    }

    

}
?>