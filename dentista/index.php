<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('location: ../login/login.php');
    exit();
}

// Conexão com o banco de dados
$host = 'localhost';
$db = 'odontologia';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Função para obter o nome do usuário logado
function getLoggedInUser($pdo) {
    $usuario_id = $_SESSION['usuario_id'];
    $stmt = $pdo->prepare('SELECT nome FROM usuarios WHERE id = ?');
    $stmt->execute([$usuario_id]);
    $usuario = $stmt->fetch();
    return $usuario ? $usuario['nome'] : 'Usuário';   
}

$usuario = getLoggedInUser($pdo);

$stmt_count_emails = $pdo->query('SELECT COUNT(*) AS total_emails FROM usuarios');
$total_emails = $stmt_count_emails->fetchColumn();
$valor=$total_emails - 1;

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>DentalMaster</title>
    <style>
        /* Seu estilo CSS aqui */
        .sidebar {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100vh;
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
                        <a href="#" class="sidebar-link">
                            <i class="fa-solid fa-list pe-2"></i>
                            Meu Consultório
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="pages">
                            <i class="fa-regular fa-file-lines pe-2"></i>
                            Pacientes
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="dashboard">
                            <i class="fa-solid fa-sliders pe-2"></i>
                            Agenda
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link collapsed" 
                            aria-expanded="false" aria-controls="auth">
                            <i class="fa-regular fa-user pe-2"></i>
                            Plano de caixa
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
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Meu Consultório</h3>
                    </div>
                    <!-- Cards Section -->
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-light text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Pacientes:</h5>
                                    <p class="card-text">Total de usuários Cadastrados: <?php echo $valor; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Card 2</h5>
                                    <p class="card-text">Conteúdo do Card 2.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Card 3</h5>
                                    <p class="card-text">Conteúdo do Card 3.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Card 4</h5>
                                    <p class="card-text">Conteúdo do Card 4.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="confirmLogoutModal" tabindex="-1" aria-labelledby="confirmLogoutModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmLogoutModalLabel">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Tem certeza de que deseja sair?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="../bd_config/logout.php" method="post">
                        <button type="submit" class="btn btn-danger">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script>
        // Adicione um evento de clique ao botão de sair
        document.getElementById('logoutButton').addEventListener('click', function() {
            // Exiba o modal de confirmação
            var myModal = new bootstrap.Modal(document.getElementById('confirmLogoutModal'), {});
            myModal.show();
        });
    </script>
</body>

</html>


