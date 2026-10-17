<!-- MODAL DE USUÁRIO -->
    <?php 

        if (isset($_SESSION['sessionConectado-Lumiere']) && $_SESSION['sessionConectado-Lumiere'] === TRUE): 
        
        if(($_SESSION['sessionAdmin-Lumiere'])== true)
            $tipo="Administrador";
        else
            $tipo="Cliente";

        $varSQL = "SELECT telefone FROM usuario WHERE id_usuario = :id AND excluido = FALSE";
        $select = $conn->prepare($varSQL);
        $select->bindParam(':id', $_SESSION['sessionId-Lumiere']);
        $select->execute();
        $telefone = $select->fetchColumn(); // retorna direto o valor, ou false se não achar
    
        if($telefone == null)
            $telefone="Não foi cadastrado!"

    ?>
    <div id="modalUsuario" class="modal-usuario">
        <div class="modal-usuario-content">
            <span class="fechar-usuario" id="fecharUsuario">&times;</span>
    
            <div class="blocoImg">
                <h2>Minha conta</h2>
                <img src="<?= $_SESSION['sessionImagem-Lumiere'] ?>" alt="Foto do usuário" class="foto-usuario-modal">
                <p class="tipoConta"><?= $tipo ?></p>
                <h3><?= htmlspecialchars($_SESSION['sessionNome-Lumiere']) ?></h3>
            </div>
            <div>
                <div class="blocoNome">
                    <h1>Dados</h1>
                </div>
                <div class="dado">
                    <div class="blocoDado">
                        <div>
                            <i class="fi fi-rr-phone-call"></i>
                            <h1>Telefone</h1>
                        </div>
                        <p><?= htmlspecialchars($telefone)  ?></p>
                    </div>
                    <div class="blocoDado">
                        <div>
                            <i class="fi fi-rr-envelope"></i>
                            <h1>Email</h1>
                        </div>
                        <p><?= htmlspecialchars($_SESSION['sessionLogin-Lumiere']) ?></p>
                    </div>
                </div>               
                <button class="btnSalvar" type="button" onclick="editarUser()">Editar</button>
            </div>
            <div class="botoes-usuario">
                <a href="logout.php" class="btn-sair">Sair</a>
                <a href="excluirConta.php" class="btn-excluir" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">Excluir conta</a>
            </div>
        </div>
    </div>

    <div class="editarPopup">
            <div class="blocoPopup">
                <div class="tituloEditar">
                    <i class="fi fi-rr-arrow-small-left" onclick="editarUser()"></i>
                    <h1>Altere seus dados</h1>
                </div>
                <form action="atualizarUsuario.php" method="POST" enctype="multipart/form-data">
                    <div class="imagemEditar">
                        <img id="previaImagem" src="<?= $_SESSION['sessionImagem-Lumiere'] ?>" alt="Foto do usuário">
                        <div>
                            <div class="campo-arquivo">
                                <input type="file" name="imagem" id="imagemEditar" accept="image/*">
                                <label for="imagemEditar" class="arquivo-label">
                                    <i class="fi fi-rr-picture"></i>
                                    <span class="arquivo-texto">Escolher imagem</span>
                                </label>

                                <label for="imagemEditar" class="arquivo-label btn-camera" hidden>
                                    <i class="fi fi-rr-camera"></i> Tirar foto
                                </label>
                            </div>
                            <div>
                                <input type="text" placeholder="Nome" name="nome" value="<?= $_SESSION['sessionNome-Lumiere']?>"/>
                                <input type="tel" id="telefone" placeholder="(14) 99999-9999" maxlength="15" minlength="15" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" title="Telefone inválido. Use DDD + número" name="telefone" value="<?= htmlspecialchars($telefone) ?>" />
                            </div>
                        </div>
                    </div>
                    <button class="botao-customizado" type="submit">Salvar</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <!-- MODAL POP-UP DE LOGIN/CADASTRO -->
    <div id="modalLogin" class="modal">
        <div class="modal-content animate">
            <span class="close-btn" id="closeModalBtn">&times;</span>
            <div id="mensagemLogin" class="mensagem-login"></div>
            <div class="abas-login" id="abasLogin">
                <button type="button" id="abaEntrar" class="ativa">Entrar</button>
                <button type="button" id="abaCadastrar">Cadastrar</button>
            </div>
            <div class="container-login" id="container-login">
                <div class="form-container sign-up-container">
                    <form action="cadastrar.php" method="POST" enctype="multipart/form-data">
                        <h1>Cadastrar Conta</h1>
                        <input type="text" placeholder="Nome" name="nome" required/>
                        <input type="email" placeholder="Email" name="email" required/>
                        <input type="password" placeholder="Senha" name="senha" required />
                        <input type="tel" id="telefone" placeholder="(14) 99999-9999" maxlength="15" minlength="15" pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}" title="Telefone inválido. Use DDD + número" name="telefone" required/>
                        <div class="campo-arquivo">
                            <input type="file" name="imagem" id="imagemCadastro" accept="image/*">
                            <label for="imagemCadastro" class="arquivo-label">
                                <i class="fi fi-rr-picture"></i>
                                <span class="arquivo-texto">Escolher imagem</span>
                            </label>

                            <label for="imagemCadastro" class="arquivo-label btn-camera" hidden>
                                <i class="fi fi-rr-camera"></i> Tirar foto
                            </label>
                        </div>
                        <button  type="submit">Cadastrar</button>
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

    <div id="cameraBox" class="camera-box" hidden>
        <div class="camera-conteudo">
            <video id="cameraVideo" autoplay playsinline muted></video>
            <canvas id="cameraCanvas" hidden></canvas>
            <div class="camera-acoes">
                <button type="button" id="btnCapturar" class="camera-capturar">Capturar</button>
                <button type="button" id="btnCancelarCamera" class="camera-cancelar">Cancelar</button>
            </div>
        </div>
    </div>

    <!------FOOTER------>
    <footer>
        <a href="index.php"><img src="Imagens/Logo.png" alt="Logo" width="120px" height="90px"></a>
        <nav>
            <ul  class="sobreLinks">
                <li><a href="sobre.php#linkQuem">Nossa História</a></li>
                <li><a href="sobre.php#linkMvv">Missão, Visão e Valores</a></li>
                <li><a href="sobre.php#linkDev">Desenvolvedores</a></li>
            </ul>
        </nav>
        <nav>
            <ul>
                <li><a href="https://www.instagram.com/lumiere.ltda/" target="_blank"><i class="fi fi-brands-instagram"></i></a></li>
                <li><a href="https://www.facebook.com/profile.php?id=61593508136608" target="_blank"><i class="fi fi-brands-facebook"></i></a></li>
                <li><a href="mailto:lumiere.velasaromaticascti@gmail.com" target="_blank"><i class="fi fi-rr-envelope"></i></a></li>
            </ul>
        </nav> 
        <hr class="linha">
        <p>&copy; 2026. Todos os direitos reservados.</p>    
    </footer>

    <script src="script.js"></script>
</body>
</html>