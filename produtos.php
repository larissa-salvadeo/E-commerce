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
                <a href="index.php">Home <i class="fi fi-rr-home"></i></a>
                <a class="active" href="produtos.php">Produtos</a>
                <a href="sobre.php">Sobre nós</a>
                <a class="btn-open" id="openModalBtn" href="#">Login <i class="fi fi-rr-user"></i></a>
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
        
    </main>
    <!-- MODAL POP-UP -->
    <div id="modalLogin" class="modal">
        <div class="modal-content animate">
            <span class="close-btn" id="closeModalBtn">&times;</span>

            <div class="container-login" id="container-login">
                <div class="form-container sign-up-container">
                    <form action="#">
                        <h1>Cadastrar Conta</h1>
                        <input type="text" placeholder="Nome" />
                        <input type="email" placeholder="Email" />
                        <input type="password" placeholder="Senha" />
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form action="#">
                        <h1>Entrar</h1>
                        <input type="email" placeholder="Email" />
                        <input type="password" placeholder="Senha" />
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