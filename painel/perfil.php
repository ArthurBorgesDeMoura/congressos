<?php
include '../conexao.php';

// Verificar se o ID foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$participante_id = (int)$_GET['id'];

// Buscar dados do participante
try {
    $conn = mysqlConnect();
    $stmt = $conn ->prepare("SELECT * FROM participantes WHERE id = ?");
    $stmt->execute([$participante_id]);
    $participante = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$participante) {
        $erro = "Participante não encontrado.";
    }
} catch(PDOException $e) {
    $erro = "Erro ao buscar dados do participante: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Participante - Congressos Científicos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="perfil.css">
</head>
<body style="background-color: #f8f9fa;">
    <!-- Botão Voltar -->
    <a href="index.php" class="btn btn-primary back-btn">
        <i class="fas fa-arrow-left me-2"></i>Voltar à Lista
    </a>

    <!-- Header -->
    <div class="header-profile">
        <div class="container text-center">
            <h1 class="mb-0"><i class="fas fa-user-circle me-3"></i>Perfil do Participante</h1>
            <p class="mb-0 mt-2">Detalhes completos da inscrição</p>
        </div>
    </div>

    <div class="container">
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong><?php echo $erro; ?></strong>
                <div class="mt-3">
                    <a href="index.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left me-1"></i>Voltar à Lista
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="profile-card">
                        <!-- Avatar e Nome -->
                        <div class="text-center ">
                            <div class="avatar-placeholder">
                                <?php echo strtoupper(substr($participante['nome'], 0, 1)); ?>
                            </div>
                            <h2 class="mb-4"><?php echo htmlspecialchars($participante['nome']); ?></h2>
                            <span class="status-badge">
                                <i class="fas fa-check-circle me-1"></i>Inscrito
                            </span>
                        </div>

                        <hr class="my-4">

                        <!-- Informações Pessoais -->
                        <h4 class="mb-3 text-primary">
                            <i class="fas fa-user me-2"></i>Informações Pessoais
                        </h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-id-card me-1"></i>CPF
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['cpf']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-envelope me-1"></i>E-mail
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['email']); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-phone me-1"></i>Telefone
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['telefone']); ?></span>
                                </div>
                            </div>
                            
                        </div>

                        <!-- Endereço -->
                        <h4 class="mb-3 text-primary mt-4">
                            <i class="fas fa-map-marker-alt me-2"></i>Endereço
                        </h4>

                        <div class="info-row">
                            <span class="info-label">
                                <i class="fas fa-home me-1"></i>Endereço Completo
                            </span>
                            <span class="info-value"><?php echo htmlspecialchars($participante['endereco']); ?></span>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-city me-1"></i>Cidade
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['cidade']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-map me-1"></i>Estado
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['estado']); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-globe me-1"></i>País
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['pais']); ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Informações Acadêmicas -->
                        <h4 class="mb-3 text-primary mt-4">
                            <i class="fas fa-graduation-cap me-2"></i>Informações Acadêmicas
                        </h4>

                        <div class="row">
                            <?php if (!empty($participante['titulacao'])): ?>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-award me-1"></i>Titulação
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['titulacao']); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($participante['instituicao'])): ?>
                            <div class="col-md-6">
                                <div class="info-row">
                                    <span class="info-label">
                                        <i class="fas fa-university me-1"></i>Instituição
                                    </span>
                                    <span class="info-value"><?php echo htmlspecialchars($participante['instituicao']); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Ações -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <a href="index.php" class="btn btn-primary me-2">
                                <i class="fas fa-list me-1"></i>Voltar à Lista
                            </a>
                            <button class="btn btn-outline-info" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>Imprimir Perfil
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
        // Animação de entrada suave
        document.addEventListener('DOMContentLoaded', function() {
            const profileCard = document.querySelector('.profile-card');
            if (profileCard) {
                profileCard.style.opacity = '0';
                profileCard.style.transform = 'translateY(30px)';
                setTimeout(() => {
                    profileCard.style.transition = 'all 0.6s ease';
                    profileCard.style.opacity = '1';
                    profileCard.style.transform = 'translateY(0)';
                }, 200);
            }

            // Animação para as informações
            const infoRows = document.querySelectorAll('.info-row');
            infoRows.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                setTimeout(() => {
                    row.style.transition = 'all 0.4s ease';
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 400 + (index * 100));
            });
        });

        // Formatação de CPF e telefone
        function formatCPF(cpf) {
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        }

        function formatPhone(phone) {
            if (phone.length === 11) {
                return phone.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (phone.length === 10) {
                return phone.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
            }
            return phone;
        }

        // Aplicar formatação após o carregamento
        window.onload = function() {
            const cpfElement = document.querySelector('.info-value');
            if (cpfElement) {
                const cpf = cpfElement.textContent.replace(/\D/g, '');
                if (cpf.length === 11) {
                    cpfElement.textContent = formatCPF(cpf);
                }
            }
        };
    </script>
</body>
</html>