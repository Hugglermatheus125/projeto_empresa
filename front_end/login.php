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

                    <h2 class="login-titulo">Entrar</h2>
                    <h3 class="login-subtitulo"><i>Digite seus dados de acesso:</i></h3>

                    <form action="login.php" method="POST" class="login-form">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <p class="p2"><strong>Não tem uma conta?
                                <a href="cadastro.php">Clique aqui.</a></strong></p>

                        <button type="submit" class="btn botao-login w-100">Acessar</button>
                    </form>

                </section>
            </div>
        </div>
    </div>
</main>

<?php

// login
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $senha = trim($_POST["password"]);

    // CAMPOS VAZIOS
    if (!$email || !$senha) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit();
    }

    $sql = "SELECT IdUsuario, Nome, Email, Senha FROM Usuarios WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // EMAIL NÃO EXISTE
    if ($resultado->num_rows === 0) {
        echo "<script>alert('Email não encontrado!'); history.back();</script>";
        exit();
    }

    $usuario = $resultado->fetch_assoc();

    // SENHA ERRADA
    if (!password_verify($senha, $usuario["Senha"])) {
        echo "<script>alert('Senha incorreta!'); history.back();</script>";
        exit();
    }

    // LOGIN OK
    $_SESSION["usuario_id"]    = $usuario["IdUsuario"];
    $_SESSION["usuario_nome"]  = $usuario["Nome"];
    $_SESSION["usuario_email"] = $usuario["Email"];

    echo "<script>
            alert('Login realizado com sucesso!');
            window.location.href='../front_end/index.php';
         </script>";
    exit();

    $stmt->close();
    $conn->close();
}

include '../includes/footer.php';
?>
