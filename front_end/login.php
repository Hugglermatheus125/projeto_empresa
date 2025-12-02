<?php
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

                    <form action="login.php" method="POST" class="login-form" onsubmit="return verificacaoFormulario(event)">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                required>
                        </div>

                        <button type="submit" class="btn botao-login w-100">
                            Acessar
                        </button>

                    </form>
                </section>

            </div>
        </div>
    </div>
</main>

<script>
    function verificacaoFormulario(event) {
        if (event) event.preventDefault();

        let email = document.getElementById("email").value.trim();
        let senha = document.getElementById("password").value.trim();
        let erros = [];

        if (!email || !senha) {
            erros.push("Preencha todos os campos obrigatórios.");
        }

        const oldBox = document.querySelector(".caixa-erro");
        if (oldBox) oldBox.remove();

        if (erros.length > 0) {
            const caixa = document.createElement("div");
            caixa.classList.add("caixa-erro");
            caixa.innerHTML = erros.map(e => `<p>${e}</p>`).join("");

            const form = document.querySelector(".login-form");
            form.insertAdjacentElement("afterend", caixa);

            return false;
        }

        event.target.submit();
        return true;
    }
</script>

<?php
include '../includes/footer.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $senha = trim($_POST["password"]);

    $sql = "SELECT IdUsuario, Nome, Email, Senha FROM Usuarios WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        echo "<div class='caixa-erro'><p>Email não encontrado.</p></div>";
        $stmt->close();
        exit;
    }

    $usuario = $resultado->fetch_assoc();
    $hash = $usuario["Senha"];

    if (!password_verify($senha, $hash)) {
        echo "<div class='caixa-erro'><p>Senha incorreta.</p></div>";
        $stmt->close();
        exit;
    }

    session_start();
    $_SESSION["usuario_id"] = $usuario["IdUsuario"];
    $_SESSION["usuario_nome"] = $usuario["Nome"];
    $_SESSION["usuario_email"] = $usuario["Email"];

    echo "<h3>Login realizado com sucesso!</h3>";
    echo "
<div class='caixa-erro'>
    <p>Login realizado com sucesso! Redirecionando...</p>
</div>

<script>
    setTimeout(function() {
        window.location.href = '../index.html';
    }, 2000); // 2 segundos
</script>
";
    exit;

    $stmt->close();
    $conn->close();
}
?>