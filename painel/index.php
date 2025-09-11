<?php
include '../conexao.php';

$participantes = []; 

// Buscar todos os participantes
try {
    $conn = mysqlConnect();
    $stmt = $conn->prepare("SELECT id, nome, email FROM PARTICIPANTES ORDER BY nome ASC");
    $stmt->execute();
     $participantes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $erro = "Erro ao buscar participantes: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Congressos Científicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="index.css">
</head>
<body style="background-color: #f8f9fa;">
    <!-- Header -->
    <div class="header-panel">
        <div class="container">
            <h1 class="mb-0"><i class="fas fa-chart-bar me-3"></i>Painel de Controle</h1>
            <p class="mb-0 mt-2">Sistema de Gerenciamento - Congressos Científicos</p>
        </div>
    </div>

    <div class="container justify-content-center">
        <!-- Estatísticas -->
        <div class="row">
            <div class="col-md-4 ">
                <div class="stats-card text-center">
                    <h3 class="text-primary"><i class="fas fa-users me-2"></i><?php echo count($participantes); ?></h3>
                    <p class="mb-0">Total de Inscritos</p>
                </div>
            </div>
        </div>

        <!-- Listagem de Participantes -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-list me-2"></i>Lista de Participantes Inscritos</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($erro)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $erro; ?>
                            </div>
                        <?php elseif (empty($participantes)): ?>
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Nenhum participante inscrito ainda.</strong><br>
                                <small>Os participantes aparecerão aqui após se inscreverem no evento.</small>
                            </div>
                        <?php else: ?>
                            <?php foreach ($participantes as $participante): ?>
                                <div class="participant-item">
                                    <a href="perfil.php?id=<?php echo $participante['id']; ?>" class="participant-link">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1">
                                                    <i class="fas fa-user me-2 text-primary"></i>
                                                    <?php echo htmlspecialchars($participante['nome']); ?>
                                                </h5>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    <?php echo htmlspecialchars($participante['email']); ?>
                                                </small>
                                            </div>
                                            
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links de Navegação -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="../index.html" class="btn btn-outline-primary me-2">
                    <i class="fas fa-home me-1"></i>Voltar ao Site
                </a>
                <a href="../inscricao.html" class="btn btn-outline-success">
                    <i class="fas fa-plus me-1"></i>Nova Inscrição
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light mt-5 py-4 border-top">
        <div class="container d-flex flex-column flex-md-row align-items-center justify-content-between">
            <div class="text-center mb-3 mb-md-0">
                <img src="https://moodle.universo.edu.br/pluginfile.php/1/theme_moove/logo/1755605085/brasao_2d.png" alt="Logo Universo" width="80" class="mb-2 mx-auto d-block">
                <div class="fw-semibold">UBERLÂNDIA - MG | 2025</div>
            </div>
            <div class="text-center text-md-end">
                <span class="fw-light">Universo - Desenvolvido por Arthur Borges de Moura.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Atualizar horário em tempo real
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('pt-BR', {
                hour: '2-digit',
                minute: '2-digit'
            });
            document.querySelector('.stats-card h3 .fa-clock').parentElement.textContent = timeString;
        }
        
        // Atualizar a cada minuto
        setInterval(updateTime, 60000);
        
        // Animação suave para os cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.participant-item');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
</body>
</html>