<?php
require_once '../database.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST["cpf"];
    $nome = $_POST["nome"];
    $cidade = $_POST["cidade"];
    $estado = $_POST["estado"];
    $pais = $_POST["pais"];
    $titulacao = $_POST["titulacao"] ?? '';
    $instituicao = $_POST["instituicao"] ?? '';
  
    // Salvar no banco de dados
    try {
        $db = getDatabase();
        $stmt = $db->prepare("INSERT INTO participantes (cpf, nome, email, senha, telefone, endereco, cidade, estado, pais, titulacao, instituicao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Hash da senha para segurança
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $stmt->execute([$cpf, $nome, $email, $senha_hash, $telefone, $endereco, $cidade, $estado, $pais, $titulacao, $instituicao]);
     
        
    } catch(PDOException $e) {
        if ($e->getCode() == 23000) { 
            echo "<!DOCTYPE html>
                    <html lang='pt-br'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Erro na Inscrição</title>
                            <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
                        </head>
                    <body>
                        <div class='container mt-5'>
                            <div class='row justify-content-center'>
                                <div class='col-md-6'>
                                    <div class='alert alert-warning text-center'>
                                        <h4><i class='fas fa-exclamation-triangle me-2'></i>CPF já cadastrado!</h4>
                                        <p>Este CPF já está registrado em nosso sistema.</p>
                                        <a href='../inscricao.html' class='btn btn-primary'>Tentar Novamente</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css' rel='stylesheet'>
                    </body>
                    </html>";
        } else {
            echo "Erro ao salvar inscrição: " . $e->getMessage();
        }
    }

    header("Location: ../inscricao.html?abrirModal=true");

}
?>