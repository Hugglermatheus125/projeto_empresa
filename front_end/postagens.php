<?php
session_start();
include '../back_end/connection.php';
include '../includes/header.php';
include '../includes/navbar.php';

// Consulta para trazer as postagens + nome do autor
$sql = "SELECT 
            p.IdPostagem,
            p.Titulo,
            p.Conteudo,
            p.Anexo,
            p.DataCriacao,
            u.Nome AS Autor
        FROM Postagens p
        JOIN Usuarios u ON p.IdUsuario = u.IdUsuario
        ORDER BY p.IdPostagem DESC"; // mais recentes primeiro

$result = $conn->query($sql);
?>

<main>
    <div class="container">

        <h2 class="mt-4 mb-4 text-center">Postagens Recentes</h2>

        <?php if ($result->num_rows > 0): ?>
            
            <?php while($post = $result->fetch_assoc()): ?>

                <div class="post-card">
                    
                    <h4 class="autor"><?= htmlspecialchars($post['Autor']) ?></h4>
                    <h3 class="titulo"><?= htmlspecialchars($post['Titulo']) ?></h3>
                    <p class="conteudo"><?= nl2br(htmlspecialchars($post['Conteudo'])) ?></p>

                    <?php if($post['Anexo']): ?>
                        <p><a class="anexo" href="../uploads/<?= $post['Anexo'] ?>" target="_blank">📎 Ver anexo</a></p>
                    <?php endif; ?>

                    <?php if(isset($post['DataCriacao'])): ?>
                        <small class="data">Postado em: <?= date('d/m/Y H:i', strtotime($post['DataCriacao'])) ?></small>
                    <?php endif; ?>

                </div>

            <?php endwhile; ?>

        <?php else: ?>
            <p class="text-center">Nenhuma postagem encontrada.</p>
        <?php endif; ?>

    </div>
</main>

<?php include '../includes/footer.php'; ?>
