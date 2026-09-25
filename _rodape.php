
    <!-- MODAL DE USUÁRIO -->
    <?php if (isset($_SESSION['sessionConectado']) && $_SESSION['sessionConectado'] === TRUE): ?>
    <div id="modalUsuario" class="modal-usuario">
        <div class="modal-usuario-content">
            <span class="fechar-usuario" id="fecharUsuario">&times;</span>
            <h2>Minha conta</h2>
            <img src="<?= htmlspecialchars($imagemUsuario) ?>" alt="Foto do usuário" class="foto-usuario-modal">

            <h3><?= htmlspecialchars($_SESSION['sessionNome']) ?></h3>
            <p><?= htmlspecialchars($_SESSION['sessionLogin']) ?></p>

            <div class="botoes-usuario">
                <a href="logout.php" class="btn-sair">Sair</a>
                <a href="excluirConta.php" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir conta</a>
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
                    <form action="cadastrar.php" method="POST" enctype="multipart/form-data">
                        <h1>Cadastrar Conta</h1>
                        <input type="text" placeholder="Nome" name="nome" required/>
                        <input type="email" placeholder="Email" name="email" required/>
                        <input type="password" placeholder="Senha" name="senha" required />
                        <input type="text" placeholder="Telefone" name="telefone" required/>
                        <input type="file" placeholder="Imagem" name="imagem" />
                        <button type="submit">Cadastrar</button>
                    </form>
                </div>
                <div class="form-container sign-in-container">
                    <form action="login.php" method="POST">
                        <h1>Entrar</h1>
                        <input type="email" name="usuario" placeholder="Email" required/>
                        <input type="password" name="senha" placeholder="Senha" required/>
                        <a href="esqueci.php">Esqueci minha senha</a>
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