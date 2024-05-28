<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="script.js" defer></script>

    <title>Login</title>
</head>
<body>
    <div class="container col-11 col-md-9" id="form-container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6 order-md-2">
                <h2>Faça login para continuar</h2>
              
                    <?php
				session_start();
				if (isset($_SESSION['erro_login'])) {
					echo '<div style="color: red;">' . $_SESSION['erro_login'] . '</div>';
					unset($_SESSION['erro_login']);
				}
			?>
			<?php
				if(isset($_GET['email'])) {
					echo '<div style="color:#be0505;">
					<strong>Tente novamente!</strong> Esse Email já Esta sendo utilizado.
					</div>
					';
				}
			?>
			<?php
				if (isset($_GET['exclusao_sucesso']) && $_GET['exclusao_sucesso'] === 'true') {
				echo '<div style="color: green;" <strong>Conta Excluida com Sucesso!</strong>  </div>';
				}
			?>
			<?php 
				if (isset($_SESSION['cadastro_sucesso'])) {
				echo '<div style="color: green;" <strong>Cadastro realizado com sucesso!</strong> Seja bem vindo. </div>';
				unset($_SESSION['cadastro_sucesso']);
				}
			?>	
              <form data-parsley-validate action="../bd_config/logar.php"    method="post">
                 <div class="form-floating mb-3">
                        <input  class="form-control" name="nome" id="nome" placeholder="Digite seu Nome" required>
                        <label for="Nome" class="form-label">Nome</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Digite seu email" required>
                        <label for="email" class="form-label">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" required>
                        <label for="senha" class="form-label">Senha</label>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Entrar</button>
                </form>
            </div>
            <div class="col-md-6 order-md-1">
                <div class="col-12">
                    <img src="./img/login.svg" class="img-fluid" alt="Ilustração de comunicação">
                </div>
                <div class="col-12" id="link-container">
                    <a href="cadastro.php">Ainda não tenho cadastro</a>
                </div>
            </div>
        </div>
    </div>
<script src="../vendor/node_modules/jquery/dist/jquery.min.js"></script>
<script src="../vendor/node_modules/parsleyjs/dist/parsley.min.js"></script>
<script src="../vendor/node_modules/parsleyjs/dist/i18n/pt-br.js"></script>
<link rel="stylesheet" href="../vendor/node_modules/parsleyjs/src/parsley.css">
</body>
</html>