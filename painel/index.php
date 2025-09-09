<?php
require_once '../database.php';

// Buscar todos os participantes
try {
    $db = getDatabase();
    $stmt = $db->query("SELECT id, nome, email, data_inscricao FROM participantes ORDER BY nome ASC");
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
    <style>
        .header-panel {
            background: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #0d6efd;
        }
        .participant-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .participant-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }
        .participant-link {
            text-decoration: none;
            color: inherit;
        }
        .participant-link:hover {
            color: inherit;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <!-- Header -->
    <div class="header-panel">
        <div class="container">
            <h1 class="mb-0"><i class="fas fa-chart-bar me-3"></i>Painel de Controle</h1>
            <p class="mb-0 mt-2">Sistema de Gerenciamento - Congressos Científicos</p>
        </div>
    </div>

    <div class="container">
        <!-- Estatísticas -->
        <div class="row">
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 class="text-primary"><i class="fas fa-users me-2"></i><?php echo count($participantes); ?></h3>
                    <p class="mb-0">Total de Inscritos</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 class="text-success"><i class="fas fa-calendar me-2"></i><?php echo date('d/m/Y'); ?></h3>
                    <p class="mb-0">Data Atual</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card text-center">
                    <h3 class="text-info"><i class="fas fa-clock me-2"></i><?php echo date('H:i'); ?></h3>
                    <p class="mb-0">Horário Atual</p>
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
                                            <div class="text-end">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    Inscrito em: <?php echo date('d/m/Y H:i', strtotime($participante['data_inscricao'])); ?>
                                                </small><br>
                                                <span class="badge bg-primary">
                                                    <i class="fas fa-eye me-1"></i>Ver Perfil
                                                </span>
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
        <div class="container text-center">
            <div class="text-muted">
                <i class="fas fa-cog me-1"></i>
                Painel de Controle - Congressos Científicos | 
                <i class="fas fa-calendar me-1"></i><?php echo date('Y'); ?>
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