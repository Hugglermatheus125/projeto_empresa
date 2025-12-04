<?php
include '../back_end/connection.php';
include '../includes/header.php';
include '../includes/navbar.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="../front_end/style.css">
</head>
</head>
<body>

    <div class="container-inicio">

        <div class="text-box">
            <h2>Bem-vindo à am3nic</h2>

            <p>A am3nic é especializada em peças de hardware que unem qualidade, desempenho e preço justo. Aqui você encontra tudo para montar, atualizar ou melhorar seu PC com confiança: placas-mãe, processadores, memórias, SSDs, placas de vídeo e muito mais.

            Trabalhamos com produtos selecionados para garantir potência, durabilidade e compatibilidade. Seja para uma setup gamer, trabalho ou uso diário, estamos prontos para ajudar você a montar a máquina ideal.
            am3nic, tecnologia que acompanha seu ritmo! <br>
            Quer saber mais sobre nós? <a href="../front_end/sobre.php" class="link">clique aqui</a></p>
            <a href="../front_end/postagens.php" class="btn">EXPLORAR</a>
        </div>

        <div class="image-box">
            <img src="../assets/pc.png" alt="PC Gamer">
        </div>

    </div>

</body>
</html>

<?php
include '../includes/footer.php';
?>