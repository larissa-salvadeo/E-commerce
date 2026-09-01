<!--
Integrantes:
Ana Júlia Leal - N°3
Julia Campos - N°18
Larissa Salvadeo - N°21
Pietra Borgo - N°31
Thales Navarro - N°34
-->
<?php
session_start();
include("util.php");

$conn = conecta();

$mensagem = $_GET['mensagem'] ?? '';
$imagemUsuario = 'Imagens/usuario.png';

if (!isset($_SESSION['sessionConectado']) && isset($_COOKIE['usuarioLogado'])) {

    $email = $_COOKIE['usuarioLogado'];

    $sql = "SELECT id_usuario, nome, email FROM usuario WHERE email = :email AND excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->bindParam(':email', $email);
    $select->execute();

    $usuario = $select->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        $_SESSION['sessionConectado'] = TRUE;
        $_SESSION['sessionLogin'] = $usuario['email'];
        $_SESSION['sessionNome'] = $usuario['nome'];
        $_SESSION['sessionId'] = $usuario['id_usuario'];
    }
}

if (isset($_SESSION['sessionConectado']) && $_SESSION['sessionConectado'] === TRUE && isset($_SESSION['sessionId'])) {
    $id_usuario = $_SESSION['sessionId'];
    $extensoes = ['png', 'jpg', 'jpeg', 'webp'];
    
    foreach ($extensoes as $ext) {
        $caminho = "Imagens/" . $id_usuario . "." . $ext;
        if (file_exists($caminho)) {
            $imagemUsuario = $caminho;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumière</title>
    <link rel="stylesheet" href="style.css">
    <!-- Flaticon -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-brands/css/uicons-brands.css">
    <!-- Font Awesome (para os ícones do menu mobile) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Merriweather:ital,opsz,wght@0,18..144,300..900;1,18..144,300..900&display=swap" rel="stylesheet">
    <link rel="icon" href="Imagens/Icone.png" type="image/png">
</head>

<body id="container">
    <!------HEADER------>
    <header>
        <!--Logo-->
        <div class="bloco-titulo">
            <a href="index.php"><img src="Imagens/Logo.png" alt="Logo"></a>
        </div>
        
        <nav class="navheader">
            <!-- Botão Hambúrguer Mobile -->
            <div class="icon menu-btn">
                <i class="fas fa-bars"></i>
            </div>

            <!-- Links do Menu -->
            <div class="menu-links">
                <!-- Botão Fechar Mobile -->
                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>
                <a class="active" href="index.php">Home <i class="fi fi-rr-home"></i></a>
                <a href="produtos.php">Produtos</a>
                <a href="sobre.php">Sobre nós</a>

                <?php if (isset($_SESSION['sessionConectado']) && $_SESSION['sessionConectado'] === TRUE): ?>

                <a class="usuario-menu" href="#" id="abrirUsuario">
                    <div class="usuario-logado">
                        <img src="<?= htmlspecialchars($imagemUsuario) ?>" alt="Foto do usuário">
                        <span>
                            <?= htmlspecialchars($_SESSION['sessionNome']) ?>
                        </span>
                    </div>
                </a>
                <?php else: ?>
                <a class="btn-open" id="openModalBtn" href="#">
                    Login <i class="fi fi-rr-user"></i>
                </a>
                <?php endif; ?>

                <a href="carrinho.php">Carrinho <i class="fi fi-rr-shopping-cart"></i></a>
            </div>

            <!-- Barra de Pesquisa -->
            <div class="pesquisa">
                <form action="/action.php">
                    <input type="text" placeholder="Pesquisar..." name="search">
                    <button type="submit"><i class="fi fi-rr-search"></i></button>
                </form>
            </div>
        </nav>
    </header>

    <!------MAIN------>
    <main>          
        <!------------CARROSSEL------------>
        <div class="slideshow-container">
            <div class="slides-track" id="track">
                <div class="mySlides">
                    <img src="Imagens/Slide1.png" alt="Slide 1">
                </div>

                <div class="mySlides">
                    <img src="Imagens/Slide2.png" alt="Slide 2">
                </div>

                <div class="mySlides">
                    <img src="Imagens/Slide3.png" alt="Slide 3">
                </div>
            </div>
        </div>

        <div class="dots-container">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>

        <!------------CATEGORIAS------------>
        <section id="catAmb"> 
            <a href="catAmb.php"><img src="Imagens/Ambiente.png" alt="Categoria Ambiente"></a>
        </section>
        <section id="catEst"> 
            <a href="catEst.php"><img src="Imagens/Estudos.png" alt="Categoria Estudo"></a>
        </section>

        <!------------VÍDEO------------>
        <figure>
            <video autoplay muted playsinline controls width="100%" loop>
                <source src="Imagens/Video.mp4" type="video/mp4">
            </video>
        </figure>
    </main>

    <div id="modalUsuario" class="modal-usuario">
        <div class="modal-usuario-content">

            <span class="fechar-usuario" id="fecharUsuario">&times;</span>
            <h2>Minha conta</h2>
            <img src="<?= htmlspecialchars($imagemUsuario) ?>" alt="Foto do usuário" class="foto-usuario-modal">

            <h3><?= htmlspecialchars($_SESSION['sessionNome']) ?></h3>

            <p><?= htmlspecialchars($_SESSION['sessionLogin']) ?></p>

            <div class="botoes-usuario">
                <a href="CRUD Usuários/logout.php" class="btn-sair">
                    Sair
                </a>

                <a href="CRUD Usuários/excluirConta.php" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">
                    Excluir conta
                </a>
            </div>
        </div>
    </div>

    <!-- MODAL POP-UP -->
    <div id="modalLogin" class="modal">
        <div class="modal-content animate">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <div id="mensagemLogin" class="mensagem-login"></div>

            <div class="container-login" id="container-login">
                <div class="form-container sign-up-container">
                    <form action="CRUD Usuários/cadastrar.php" method="POST" enctype="multipart/form-data">
                        <h1>Cadastrar Conta</h1>
                        <input type="text" placeholder="Nome" name="nome" required/>
                        <input type="email" placeholder="Email" name="email" required/>
                        <input type="password" placeholder="Senha" name="senha"required />
                        <input type="text" placeholder="Telefone" name="telefone" required/>
                        <input type="file" placeholder="Imagem" name="imagem" />
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form action="CRUD Usuários/login.php" method="POST">
                        <h1>Entrar</h1>
                        <input type="email" name="usuario" placeholder="Email" required/>
                        <input type="password" name="senha" placeholder="Senha" required/>
                        <a href="#">Esqueci minha senha</a>
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
    <!------FOOTER------>
    <footer>
        <a href="index.php"><img src="Imagens/Logo.png" alt="Logo" width="120px" height="90px"></a>
        <nav>
            <ul>
                <li><a href="sobre.php">Sobre Nós</a></li>
            </ul>
        </nav>
        <br>
        <nav>
            <ul>
                <li><a href="https://www.instagram.com/lumiere.ltda/" target="_blank"><i class="fi fi-brands-instagram"></i></a></li>
                <li><a href="https://www.facebook.com/profile.php?id=61593508136608" target="_blank"><i class="fi fi-brands-facebook"></i></a></li>
            </ul>
        </nav> 
        <br>
        <p>&copy; 2026. Todos os direitos reservados.</p>    
    </footer>

    <script src="script.js"></script>
</body>
</html>