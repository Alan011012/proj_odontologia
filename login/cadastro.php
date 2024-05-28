<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <script src="script.js" defer></script>

    <title>Cadastro</title>
</head>

<body>
    <div class="container col-11 col-md-9" id="form-container">
        <div class="row align-items-center gx-5">
            <div class="col-md-6">
                <h2>Realize seu cadastro</h2>
                <form data-parsley-validate action="../bd_config/cadastra.php" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome" required>
                        <label for="nome" class="form-label">Digite seu nome</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
                        <label for="email" class="form-label">Digite seu email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="senha"
                            placeholder="Digite sua senha" required>
                        <label for="Senha" class="form-label">Digite seu senha</label>
                    </div>
                    <div class="mb-3">
                 
                    </div>
                    <div class="mb-3">
                        <div class="form-check mb-2">
                        </div>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Cadastrar</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="row align-items-center">
                    <div class="col-12">
                        <img src="./img/registro.svg" alt="Ilustração de formulario" class="img-fluid">
                    </div>
                    <div class="col-12" id="link-container">
                        <a href="login.php">Eu já possuo cadastro</a>
                    </div>
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