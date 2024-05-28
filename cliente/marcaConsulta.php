<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('location: ../login/login.php');
    exit();
}


require"../bd_config/conexao.php";
// Função para obter o nome do usuário logado
function getLoggedInUser($conn) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $conn->prepare('SELECT nome FROM usuarios WHERE id = ?');
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    return $usuario ? $usuario['nome'] : 'Usuário';   
}
$usuario = getLoggedInUser($conn);
?>  
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalMaster</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Seu estilo CSS personalizado aqui */
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: width 0.5s; /* Adicionando transição para animação suave */
        }

        .logout-section {
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Alinhar itens à esquerda */
            padding: 10px;
            border-top: 1px solid #ccc;
        }

        .user-info {
            margin-bottom: 10px; /* Adicionando margem inferior para separar o nome do usuário do botão */
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <div>
                <div class="sidebar-logo">
                    <a href="#">DentalMaster</a>
                </div>
                <!-- Sidebar Navigation -->
                <ul class="sidebar-nav">
                    <li class="sidebar-header">
                        Painel
                    </li>
                    <li class="sidebar-item">
                        <a href="index.php" class="sidebar-link">
                            <i class="fas fa-list pe-2"></i> <!-- Utilizando font-awesome para o ícone -->
                            Seja Bem Vindo
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed"
                            aria-expanded="false" aria-controls="pages">
                            <i class="far fa-file-lines pe-2"></i> <!-- Utilizando font-awesome para o ícone -->
                            Marcar consulta
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed"
                            aria-expanded="false" aria-controls="dashboard" id="updatePasswordLink">
                            <i class="fas fa-sliders pe-2"></i> <!-- Utilizando font-awesome para o ícone -->
                            Atualizar senha
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed"
                            aria-expanded="false" aria-controls="auth" id="deleteAccountLink">
                            <i class="far fa-user pe-2"></i> <!-- Utilizando font-awesome para o ícone -->
                            Deletar Conta
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Nome do usuário e botão de sair -->
            <div class="logout-section">
                <div class="user-info">
                    <strong><?php echo htmlspecialchars($usuario); ?></strong>
                </div>
                <button id="logoutButton" class="btn btn-danger">Sair</button>
            </div>
        </aside>
        <!-- Main Component -->
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <!-- Button for sidebar toggle -->
                <button class="btn" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            <!-- Formulário para Agendar Consulta -->
            <div class="container mt-5">
                <h2>Agendar Consulta</h2>
                <form action="#" method="POST">
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Endereço de Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Número de Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone" required>
                    </div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Consulta</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="mensagem" class="form-label">Mensagem Adicional</label>
                        <textarea class="form-control" id="mensagem" name="mensagem" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Agendar</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal de Atualização de Senha -->
    <div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">Atualizar Senha</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="redefinirSenha.php" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Senha Atual<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="currentPassword" name="currentPassword"
                                placeholder="Digite a senha atual" required>
                            <div class="invalid-feedback">
                                Por favor, digite sua senha atual.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nova Senha<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword"
                                placeholder="Digite a nova senha" required>
                            <div class="invalid-feedback">
                                Por favor, digite sua nova senha.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar Nova Senha<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                                placeholder="Confirme a nova senha" required>
                            <div class="invalid-feedback">
                                Por favor, confirme sua nova senha.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Atualizar Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Exclusão de Conta -->
    <div>
        <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Confirmar Exclusão de Conta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Você tem certeza que deseja excluir esta conta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="delete.php" class="btn btn-danger">Sim, Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de Confirmação de Saída da Conta -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmLogoutModalLabel">Confirmar Saída</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza que deseja sair da conta?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="logoutConfirmButton" class="btn btn-danger">Sair</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        // Adiciona um evento de clique ao link "Atualizar senha" na barra lateral
        document.getElementById('updatePasswordLink').addEventListener('click', function() {
            // Exibe o modal de atualizar senha
            var updatePasswordModal = new bootstrap.Modal(document.getElementById('updatePasswordModal'), {});
            updatePasswordModal.show();
        });

        // Adiciona um evento de clique ao link "Deletar Conta" na barra lateral
        document.getElementById('deleteAccountLink').addEventListener('click', function() {
            // Exibe o modal de exclusão de conta
            var deleteAccountModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'), {});
            deleteAccountModal.show();
        });

        // Adiciona um evento de clique ao botão de sair para abrir o modal de confirmação de saída
        document.getElementById('logoutButton').addEventListener('click', function() {
            // Exibe o modal de confirmação de saída
            var confirmLogoutModal = new bootstrap.Modal(document.getElementById('confirmLogoutModal'), {});
            confirmLogoutModal.show();
        });

        // Adiciona um evento de clique ao botão de confirmação de saída para redirecionar para a página de logout
        document.getElementById('logoutConfirmButton').addEventListener('click', function() {
            // Redireciona para a página de logout
            window.location.href = "../bd_config/logout.php";
        });

        // Adiciona um evento de clique ao elemento body para fechar o modal ao clicar fora dele
        document.addEventListener('DOMContentLoaded', function() {
            document.body.addEventListener('click', function(event) {
                // Verifica se o clique ocorreu fora do modal
                if (!event.target.closest('.modal-dialog')) {
                    // Fecha todos os modals abertos na página
                    var modals = document.querySelectorAll('.modal');
                    modals.forEach(function(modal) {
                        var bootstrapModal = bootstrap.Modal.getInstance(modal);
                        if (bootstrapModal._isShown) {
                            bootstrapModal.hide();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
