<?php
session_start();
include '../back_end/connection.php';
include '../includes/header.php';
?>

<main>
    <div class="container-fluid login-caixa">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <section class="login-card">
                    <h2 class="login-titulo">Cadastro</h2>
                    <h3 class="login-subtitulo"><i>Preencha seus dados abaixo:</i></h3>

                    <!-- FORM CADASTRO -->
                    <!-- envio para o MESMO arquivo -->
                    <form method="POST" class="login-form">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-4">
                            <label for="data_nasc" class="form-label">Data de Nascimento</label>
                            <input type="date" name="data_nasc" id="data_nasc" class="form-control" required>
                        </div>

                        <button type="submit" class="btn botao-login w-100">Cadastrar</button>
                    </form>

                </section>

            </div>
        </div>
    </div>
</main>


<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome     = trim($_POST["nome"]);
    $email    = trim($_POST["email"]);
    $senha    = trim($_POST["password"]);
    $dataNasc = trim($_POST["data_nasc"]);

    // CAMPOS VAZIOS
    if (!$nome || !$email || !$senha || !$dataNasc) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit();
    }

    // VALIDAR DATA REAL + BLOQUEAR FUTURO + <13 ANOS
    $dataObj = DateTime::createFromFormat('Y-m-d', $dataNasc);

    if (!$dataObj || $dataObj->format('Y-m-d') !== $dataNasc) {
        echo "<script>alert('Data inválida!'); history.back();</script>";
        exit();
    }

    // BLOQUEAR ANO MENOR QUE 1900
    if ($dataObj < new DateTime('1900-01-01')) {
        echo "<script>alert('A data deve ser maior que 01/01/1900!'); history.back();</script>";
        exit();
    }

    $hoje = new DateTime();
    $idade = $hoje->diff($dataObj)->y;

    if ($dataObj > $hoje) {
        echo "<script>alert('Data no futuro não é válida!'); history.back();</script>";
        exit();
    }

    if ($idade < 13) {
        echo "<script>alert('É necessário ter pelo menos 13 anos para se cadastrar.'); history.back();</script>";
        exit();
    }

    // VERIFICA NOME
    $check = $conn->prepare("SELECT IdUsuario FROM Usuarios WHERE Nome = ?");
    $check->bind_param("s", $nome);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('Este nome já está em uso!'); history.back();</script>";
        exit();
    }
    $check->close();

    // VERIFICA EMAIL
    $check = $conn->prepare("SELECT IdUsuario FROM Usuarios WHERE Email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo "<script>alert('Este email já está cadastrado!'); history.back();</script>";
        exit();
    }
    $check->close();

    // INSERIR NO BANCO
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO Usuarios (Nome, Email, Senha, DataNasc) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $email, $senhaHash, $dataNasc);

    if ($stmt->execute()) {
        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href='../front_end/login.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Erro ao cadastrar!'); history.back();</script>";
        exit();
    }

    $stmt->close();
    $conn->close();
}

include '../includes/footer.php';
?>