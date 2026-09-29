<?php
include "../util.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paginaAtual = basename($_SERVER['PHP_SELF']);
$conn = conecta();
$id_usuario = $_GET['id_usuario'];

SaiseHacker();
// Login automático pelo cookie
if (!isset($_SESSION['sessionConectado-Lumiere']) && isset($_COOKIE['usuarioLogado-Lumiere'])) {

    $email = $_COOKIE['usuarioLogado-Lumiere'];

    $sql = "SELECT id_usuario, nome, email, admin, imagem FROM usuario WHERE email = :email AND excluido = FALSE";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['sessionConectado-Lumiere'] = TRUE;
        $_SESSION['sessionLogin-Lumiere'] = $usuario['email'];
        $_SESSION['sessionNome-Lumiere'] = $usuario['nome'];
        $_SESSION['sessionId-Lumiere'] = $usuario['id_usuario'];
        $_SESSION['sessionAdmin-Lumiere'] = $usuario['admin'];
        $_SESSION['sessionImagem-Lumiere'] = $usuario['imagem'];
    }
}

// Imagem do usuário
if (isset($_SESSION['sessionConectado-Lumiere']) && $_SESSION['sessionConectado-Lumiere'] === TRUE) {
    $imagemUsuario = $_SESSION['sessionImagem-Lumiere'] ?? 'Imagens/usuario.png';
} else {
    $imagemUsuario = 'Imagens/usuario.png';
}

$varSQL ="SELECT id_usuario, nome, email, telefone, admin, imagem FROM usuario WHERE id_usuario = :id_usuario";

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id_usuario', $id_usuario);
    $select->execute();
    $linha = $select->fetch(); 

    $id_usuario = $linha['id_usuario'];
    $nome = $linha['nome'];
    $email = $linha['email'];
    $telefone = $linha['telefone'];
    $admin = $linha['admin'];
    $imagem = $linha['imagem'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumière Velas Aromáticas - Gerenciamento de Usuários</title>

    <!-- CSS Principal -->
    <link rel="stylesheet" href="../style.css">

    <!-- Flaticon -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-brands/css/uicons-brands.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">

    <link rel="icon" href="../Imagens/Icone.png" type="image/png">
</head>

<body id="containerCrud">

    <!------ HEADER ------>
    <header>
        <!-- Logo -->
        <div class="bloco-titulo">
            <a href="../index.php"><img src="../Imagens/Logo.png" alt="Logo"></a>
        </div>

        <nav class="navheader">
            <!-- Botão Hambúrguer Mobile -->
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>
            <!-- Links do Menu -->
            <div class="menu-links">

                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>

                <a class="<?= ($paginaAtual == 'index.php' || $paginaAtual == 'busca.php' || $paginaAtual == 'catAmb.php' || $paginaAtual == 'catEst.php') ? 'active' : '' ?>" href="../index.php">
                    Home <i class="fi fi-rr-home"></i>
                </a>

                <a class="<?= ($paginaAtual == 'produtos.php' || $paginaAtual == 'paginaProduto.php') ? 'active' : '' ?>" href="../produtos.php">
                    Produtos
                </a>

                <a class="<?= ($paginaAtual == 'sobre.php') ? 'active' : '' ?>" href="../sobre.php">
                    Sobre nós
                </a>

                <?php if (isset($_SESSION['sessionConectado-Lumiere']) && $_SESSION['sessionConectado-Lumiere'] === TRUE): ?>

                    <a class="usuario-menu" href="#" id="abrirUsuario">
                        <div class="usuario-logado">
                            <img src="../<?= htmlspecialchars($imagemUsuario ?? 'Imagens/usuario.png', ENT_QUOTES, 'UTF-8') ?>" alt="Foto do usuário">
                            <span><?= htmlspecialchars($_SESSION['sessionNome-Lumiere'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                    </a>

                <?php else: ?>

                    <a class="btn-open" id="openModalBtn" href="#">
                        Login <i class="fi fi-rr-user"></i>
                    </a>

                <?php endif; ?>

                <a class="<?= ($paginaAtual == 'carrinho.php') ? 'active' : '' ?>" href="../carrinho.php">
                    Carrinho <i class="fi fi-rr-shopping-cart"></i>
                </a>

                <?php if (isset($_SESSION['sessionAdmin-Lumiere']) && $_SESSION['sessionAdmin-Lumiere'] === TRUE): ?>
                <a class="<?= ($paginaAtual == 'alterarUsuarios.php') ? 'active' : '' ?>" href="../admin.php">
                    Admin <i class="fi fi-rr-user"></i>
                </a>
                <?php endif;?>
            </div>

            <!-- Barra de Pesquisa -->

            <div class="pesquisa">
                <form action="../busca.php" method="GET">
                    <input type="text" placeholder="Pesquisar..." name="search">
                    <button type="submit"><i class="fi fi-rr-search"></i></button>
                </form>
            </div>

        </nav>

    </header>


    <!------ CONTEÚDO PRINCIPAL ------>

    <main class="main-alterar-usuario">
        <form action="updateUsuarios.php" method="post" enctype="multipart/form-data" class="form-editar-usuario">

            <input type="hidden" name="id_usuario" value="<?= htmlspecialchars($id_usuario) ?>">

            <h1>Editar Usuário</h1>

            <p class="subtitulo-editar">
                Altere os dados da conta abaixo
            </p>

            <label for="nome">Nome</label>
            <input
                type="text"
                id="nome"
                name="nome"
                value="<?= htmlspecialchars($nome) ?>"
                required
            >

            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                value="<?= htmlspecialchars($email) ?>"
                required
            >

            <label for="senha">
                Nova Senha
                <span>(deixe em branco para não alterar)</span>
            </label>

            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite uma nova senha"
            >

            <label for="telefone">Telefone</label>
            <input
                type="text"
                id="telefone"
                name="telefone"
                value="<?= htmlspecialchars($telefone) ?>"
                required
            >

            <div class="campo-admin">

                <div>
                    <label for="admin">Administrador</label>

                    <p>
                        Permitir que este usuário tenha acesso administrativo.
                    </p>
                </div>

                <label class="switch">
                    <input
                        type="checkbox"
                        id="admin"
                        name="admin"
                        value="1"
                        <?= $admin ? 'checked' : '' ?>
                    >

                    <span class="slider"></span>
                </label>

            </div>

            <label for="imagem">Imagem do usuário</label>

            <input
                type="file"
                id="imagem"
                name="imagem"
                accept="image/*"
            >

            <button type="submit" class="btn-salvar-usuario">Salvar alterações</button>

        </form>
        <!-- MODAL DE USUÁRIO -->

        <?php if (isset($_SESSION['sessionConectado-Lumiere']) && $_SESSION['sessionConectado-Lumiere'] === TRUE): ?>

            <div id="modalUsuario" class="modal-usuario">

                <div class="modal-usuario-content">

                    <span class="fechar-usuario" id="fecharUsuario">&times;</span>

                    <h2>Minha conta</h2>

                    <img src="../<?= htmlspecialchars($imagemUsuario, ENT_QUOTES, 'UTF-8') ?>" alt="Foto do usuário" class="foto-usuario-modal">

                    <h3><?= htmlspecialchars($_SESSION['sessionNome-Lumiere'] ?? '', ENT_QUOTES, 'UTF-8') ?></h3>

                    <p><?= htmlspecialchars($_SESSION['sessionLogin-Lumiere'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

                    <div class="botoes-usuario">

                        <a href="../logout.php" class="btn-sair">Sair</a>

                        <a href="../excluirConta.php" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir conta</a>

                    </div>

                </div>

            </div>

        <?php endif; ?>


        <!-- MODAL POP-UP DE LOGIN/CADASTRO -->

        <div id="modalLogin" class="modal">

            <div class="modal-content animate">

                <span class="close-btn" id="closeModalBtn">&times;</span>

                <div id="mensagemLogin" class="mensagem-login"></div>

                <div class="container-login" id="container-login">

                    <div class="form-container sign-up-container">

                        <form action="../cadastrar.php" method="POST" enctype="multipart/form-data">

                            <h1>Cadastrar Conta</h1>

                            <input type="text" placeholder="Nome" name="nome" required/>

                            <input type="email" placeholder="Email" name="email" required/>

                            <input type="password" placeholder="Senha" name="senha" required />

                            <input type="text" placeholder="Telefone" name="telefone" required/>

                            <input type="file" name="imagem" />

                            <button type="submit">Cadastrar</button>

                        </form>

                    </div>


                    <div class="form-container sign-in-container">

                        <form action="../login.php" method="POST">

                            <h1>Entrar</h1>

                            <input type="email" name="usuario" placeholder="Email" required/>

                            <input type="password" name="senha" placeholder="Senha" required/>

                            <a href="../esqueci.php">Esqueci minha senha</a>

                            <button type="submit">Entrar</button>

                        </form>

                    </div>


                    <div class="overlay-container">

                        <div class="overlay">

                            <div class="overlay-panel overlay-left">

                                <h1>Bem-vindo de volta!</h1>

                                <p>Acesse sua conta com seu login e senha</p>

                                <button type="button" class="ghost" id="signIn">Entrar</button>

                            </div>

                            <div class="overlay-panel overlay-right">

                                <h1>Olá!</h1>

                                <p>Preencha seus dados para começar essa jornada com a gente</p>

                                <button type="button" class="ghost" id="signUp">Cadastrar</button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>


    <!------ FOOTER ------>

    <footer>

        <a href="../index.php"><img src="../Imagens/Logo.png" alt="Logo" width="120px" height="90px"></a>

        <nav>

            <ul>
                <li><a href="../sobre.php">Sobre Nós</a></li>
            </ul>

        </nav>

        <nav>

            <ul>

                <li><a href="https://www.instagram.com/lumiere.ltda/" target="_blank"><i class="fi fi-brands-instagram"></i></a></li>

                <li><a href="https://www.facebook.com/profile.php?id=61593508136608" target="_blank"><i class="fi fi-brands-facebook"></i></a></li>

            </ul>

        </nav>

        <hr class="linha">

        <p>&copy; 2026. Todos os direitos reservados.</p>

    </footer>


    <script src="../script.js"></script>

</body>

</html>