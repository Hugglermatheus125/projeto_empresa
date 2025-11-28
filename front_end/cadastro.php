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
                    <h3 class="login-subtitulo"><i>Digite seus dados de acesso nos campos abaixo:</i></h3>

                    <form action="../back_end/login.php" method="POST" class="login-form" onsubmit="verificacaoFormulario()">

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
                            Acessar
                        </button>

                    </form>
                </section>

            </div>
        </div>
    </div>
</main>

<?php
include '../includes/footer.php';
?>