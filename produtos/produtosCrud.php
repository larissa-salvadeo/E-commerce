<?php

include "../util.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$paginaAtual = basename($_SERVER['PHP_SELF']);

$conn = conecta();

SaiseHacker();

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

if (isset($_SESSION['sessionConectado-Lumiere']) && $_SESSION['sessionConectado-Lumiere'] === TRUE) {
    $imagemUsuario = $_SESSION['sessionImagem-Lumiere'] ?? 'Imagens/usuario.png';
} else {
    $imagemUsuario = 'Imagens/usuario.png';
}

$pesquisa = $_GET['pesquisa'] ?? '';

$varSQL = "SELECT id_produto, nome, descricao, valor_unitario, imagem FROM produto WHERE excluido = FALSE 
            AND (nome ILIKE :pesquisa OR descricao ILIKE :pesquisa) ORDER BY id_produto ASC";


$select = $conn->prepare($varSQL);

$pesquisaBanco = "%" . $pesquisa . "%";

$select->bindParam(':pesquisa',$pesquisaBanco,PDO::PARAM_STR);

$select->execute();
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

<body id="container">

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
                <a class="<?= ($paginaAtual == 'produtosCrud.php') ? 'active' : '' ?>" href="../admin.php">
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

    <main style="width: 100%; text-align: center; display: block;">

    <div style="width: 80%; margin: 0 auto 20px auto; text-align: left; display: block;">
        <form method="GET" action="" style="display: block;">
            <input type="text" name="pesquisa" placeholder="Pesquisar usuário..." value="<?= htmlspecialchars($pesquisa) ?>" style="width: 300px; padding: 10px; border: 1px solid #5F8565; border-radius: 5px;">
            <button type="submit" style="padding: 10px 20px; background-color: #5F8565; color: white; border: none; border-radius: 5px; cursor: pointer;">Pesquisar</button>
        </form>
    </div>
    
    <table style="border: 2px #5F8565 dotted; border-collapse: collapse; width: 80%; margin: 0 auto;">
        <thead style="background-color: #5F8565; color: white;">
            <tr>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">ID</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">NOME</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">DESCRIÇÃO</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">VALOR UNITÁRIO</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">QUANTIDADE ESTOQUE</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">IMAGEM</th>
                <th style="border: 1px #5F8565 dotted; padding: 10px;">AÇÕES</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($linha = $select->fetch(PDO::FETCH_ASSOC)):
            $id_produto = $linha['id_produto'];
            $nome = $linha['nome'];
            $descricao = $linha['descricao'];

            $qtd_estoque = 0;

            $valor = $linha['valor_unitario'];
            $imagem = $linha['imagem'];
        ?>

            <tr>
                <td style="border: 1px #5F8565 dotted; padding: 10px;"><?=$id_produto?></td>
                <td style="border: 1px #5F8565 dotted; padding: 10px;"><?=$nome?></td>
                <td style="border: 1px #5F8565 dotted; padding: 10px;"><?=$descricao?></td>
                <td style="border: 1px #5F8565 dotted; padding: 10px;"><?=$valor?></td>
                <td style="border: 1px #5F8565 dotted; padding: 10px;"><?=$qtd_estoque?></td>
                <td style="border: 1px #5F8565 dotted; padding: 10px;">
                    <img height="80" src="../<?=$imagem?>" alt="Imagem do Produto"/>
                </td>

                <td style="border: 1px #5F8565 dotted; padding: 10px;">
                    <div class="acoes">
                        <a href="alterarProdutos.php?id_produto=<?= htmlspecialchars($linha['id_produto'], ENT_QUOTES, 'UTF-8') ?>">
                            <img height="35" src="../Imagens/alterar.png" alt="Alterar"/>
                        </a>
                        <a href="excluirProdutos.php?id_produto=<?= htmlspecialchars($linha['id_produto'], ENT_QUOTES, 'UTF-8') ?>">
                            <img height="35" src="../Imagens/excluir.png" alt="Excluir"/>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

        <br><br>

        <a href="adicionarProdutos.php">
            <img height="60" src="../Imagens/adicionar.png" alt="Adicionar Produto"/>
        </a>


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