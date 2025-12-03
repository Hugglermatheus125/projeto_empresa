<?php
session_start();

// Impedir acesso sem login
if (!isset($_SESSION["usuario_id"])) {
    echo "<script>alert('Você precisa estar logado para criar uma postagem!'); 
    window.location.href='login.php';</script>";
    exit;
}

include '../back_end/connection.php';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<main>
    <div class="container-fluid login-caixa">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-8 col-md-6 col-lg-4">

                <section class="login-card">
                    <h2 class="login-titulo">Criar Postagem</h2>
                    <h3 class="login-subtitulo"><i>Preencha os dados abaixo:</i></h3>

                    <form action="" method="POST" enctype="multipart/form-data" class="login-form">

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Conteúdo</label>
                            <textarea name="conteudo" id="conteudo" rows="5" class="form-control" required></textarea>
                        </div>

                        <div class="mb-4">
                            <label for="anexo" class="form-label">Anexo (opcional)</label>
                            <input type="file" name="anexo" id="anexo" class="form-control">
                        </div>

                        <button type="submit" class="btn botao-login w-100">Publicar</button>
                    </form>

                </section>

            </div>
        </div>
    </div>
</main>

<?php

// Quando o usuário clicar em "Publicar"
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo   = trim($_POST["titulo"]);
    $conteudo = trim($_POST["conteudo"]);
    $userId   = $_SESSION["usuario_id"]; // ID do autor

    if (!$titulo || !$conteudo) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    }

    // Upload do anexo (caso tenha)
    $anexoNome = null;

    if (!empty($_FILES["anexo"]["name"])) {
        $arquivoTmp = $_FILES["anexo"]["tmp_name"];
        $nomeArquivo = time() . "_" . basename($_FILES["anexo"]["name"]); // evitar nomes repetidos

        // Verifica se a pasta existe
        if (!is_dir("../uploads")) {
            mkdir("../uploads", 0777, true);
        }

        // Move arquivo
        if (move_uploaded_file($arquivoTmp, "../uploads/" . $nomeArquivo)) {
            $anexoNome = $nomeArquivo;
        }
    }

    // Inserir no banco
    $sql = "INSERT INTO Postagens (IdUsuario, Titulo, Conteudo, Anexo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $userId, $titulo, $conteudo, $anexoNome);

    if ($stmt->execute()) {
        echo "<script>alert('Postagem publicada!'); window.location.href='postagens.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao publicar a postagem!'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}

include '../includes/footer.php';
?>
