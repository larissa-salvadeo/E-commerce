<!--
Integrantes:
Ana Júlia Leal - N°3
Julia Campos - N°18
Larissa Salvadeo - N°21
Pietra Borgo - N°31
Thales Navarro - N°34
-->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once("util.php");

$conn = conecta();

// Pega o nome do arquivo atual (ex: 'index.php', 'produtos.php', etc)
$paginaAtual = basename($_SERVER['PHP_SELF']);

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
        $_SESSION['sessaoConectado'] = TRUE;
        $_SESSION['sessaoAdmin'];
        $_SESSION['sessaoLogin'] = $usuario['email'];
        $_SESSION['sessaoNome'] = $usuario['nome'];
        $_SESSION['sessaoId'] = $usuario['id_usuario'];
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
    <title>Lumière Velas Aromáticas</title>
    <link rel="stylesheet" href="style.css">
    <!-- Flaticon -->
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/2.1.0/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-brands/css/uicons-brands.css">
    <!-- Font Awesome -->
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
                <div class="icon cancel-btn">
                    <i class="fas fa-times"></i>
                </div>
                
                <!-- Condicionais para a classe active -->
                <a class="<?= ($paginaAtual == 'index.php' || $paginaAtual == 'busca.php' || $paginaAtual == 'catAmb.php' || $paginaAtual == 'catEst.php') ? 'active' : '' ?>" href="index.php">
                    Home <i class="fi fi-rr-home"></i>
                </a>

                <a class="<?= ($paginaAtual == 'produtos.php' || $paginaAtual == 'paginaProduto.php') ? 'active' : '' ?>" href="produtos.php">
                    Produtos
                </a>
                

                <a class="<?= ($paginaAtual == 'sobre.php') ? 'active' : '' ?>" href="sobre.php">
                    Sobre nós
                </a>

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

                <a class="<?= ($paginaAtual == 'carrinho.php') ? 'active' : '' ?>" href="carrinho.php">
                    Carrinho <i class="fi fi-rr-shopping-cart"></i>
                </a>
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