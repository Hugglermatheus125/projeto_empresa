<?php
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

                    <form action="cadastro.php" method="POST" class="login-form">

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input
                                type="text"
                                name="nome"
                                id="nome"
                                class="form-control"
                                required>
                        </div>

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

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input
                                type="tel"
                                name="telefone"
                                id="telefone"
                                class="form-control"
                                placeholder="(00) 00000-0000"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="data_nasc" class="form-label">Data de Nascimento</label>
                            <input
                                type="date"
                                name="data_nasc"
                                id="data_nasc"
                                class="form-control"
                                required>
                        </div>

                        <button type="submit" class="btn botao-login w-100">
                            Cadastrar
                        </button>

                    </form>

                    <?php
                    // Mostrar erro abaixo do formulário — igual no JS
                    if (!empty($erro)) {
                        echo "<div class='caixa-erro'><p>$erro</p></div>";
                    }
                    ?>

                </section>

            </div>
        </div>
    </div>
</main>

<?php
$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["password"]);
    $telefone = trim($_POST["telefone"]);
    $dataNasc = trim($_POST["data_nasc"]);

    //ve se tem campo vazio
    if (empty($nome) || empty($email) || empty($senha) || empty($telefone) || empty($dataNasc)) {
        $erro = "Por favor, preencha todos os campos obrigatórios.";
    }

    //ve se o telefone e em formato valido com essa coisa ai
    if (!$erro) {
        $telRegex = "/^\(\d{2}\) \d{5}-\d{4}$/";
        if (!preg_match($telRegex, $telefone)) {
            $erro = "O telefone deve estar no formato (00) 00000-0000.";
        }
    }

    //ve se o nome de usuario ja existe no banco
    // 's' representa string
    if (!$erro) {
        $check = $conn->prepare("SELECT ID FROM Usuarios WHERE Nome = ?");
        $check->bind_param("s", $nome);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {
            $erro = "Este nome já está em uso. Escolha outro.";
        }

        $check->close();
    }

    //see não houver erro ele inserir no banco
    if (!$erro) {

        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Usuarios (Nome, Email, Senha, Telefone, DataNasc)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nome, $email, $senhaHash, $telefone, $dataNasc);

        if ($stmt->execute()) {
            echo "<h3>Cadastro realizado com sucesso!</h3>";
        } else {
            $erro = "Erro ao cadastrar: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}

include '../includes/footer.php';

?>