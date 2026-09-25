<?php 
include("util.php");
include("_cabecalho.php");?>

    <!------MAIN------>
    <main class="sobre">
        <!------------QUEM SOMOS?------------>
        <div class="quem">
            <section id="texto-quem">
                <h1 id="titulo-quem"><b>Quem somos?</b></h1><br>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis inventore incidunt magni itaque accusamus excepturi possimus. Porro, veniam. Suscipit illo natus dolor assumenda recusandae tenetur delectus aut totam cumque ipsa. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto molestias, voluptas delectus ipsum dolorem quos temporibus consequatur magni explicabo itaque a eaque amet tempora dignissimos, asperiores nam. Ex, optio impedit!LoremLor  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis saepe corrupti cumque natus magnam? Beatae officiis, quasi sapiente iure porro maxime, voluptas provident corporis voluptatum ea error earum inventore.</p>                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis inventore incidunt magni itaque accusamus excepturi possimus. Porro, veniam. Suscipit illo natus dolor assumenda recusandae tenetur delectus aut totam cumque ipsa. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto molestias, voluptas delectus ipsum dolorem quos temporibus consequatur magni explicabo itaque a eaque amet tempora dignissimos, asperiores nam. Ex, optio impedit!LoremLor  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis saepe corrupti cumque natus magnam? Beatae officiis, quasi sapiente iure porro maxime, voluptas provident corporis voluptatum ea error earum inventore.</p>
            </section>
            <section id="img-quem">
                <img src="Imagens/devs.png" alt="Desenvolvedores">
            </section>
        </div><br><br>
        <!------------NOSSA MISSÃO, VISÃO E VALORES------------>
        <div class="mvv">
            <h1 id="titulo-mvv"><b>Nossa missão, visão e valores</b></h1><br>
            <section id="missao">
                <h1><b>Missão</b></h1><br>
                <p>Proporcionar momentos de conforto, tranquilidade e concentração por meio de velas aromáticas que transformam ambientes de estudo e convivência em espaços mais agradáveis e acolhedores.</p><br>
            </section>
            <section id="visao">
                <h1><b>Visão</b></h1><br>
                <p>Oferecer velas aromáticas criativas e de qualidade, capazes de proporcionar ambientes aconchegantes e contribuir para a concentração e o bem-estar das pessoas.</p><br>
            </section>
            <section id="valores">
                <h1><b>Valores</b></h1><br>
                <ul>
                    <li>Bem-estar: buscamos tornar os momentos do dia mais leves e agradáveis.</li>
                    <li>Criatividade: valorizamos combinações de aromas e ideias que tornam cada ambiente especial.</li>
                    <li>Qualidade: prezamos pela qualidade dos nossos produtos e pela satisfação dos clientes.</li>
                    <li>Responsabilidade: buscamos escolhas mais conscientes na produção e nos materiais utilizados.</li>
                    <li>Aconchego: acreditamos que pequenos detalhes podem transformar um espaço.</li>
                    <li>Foco e tranquilidade: incentivamos ambientes que favoreçam concentração, relaxamento e produtividade.</li>
                    <li>Cuidado: colocamos atenção em cada etapa, desde a criação até a experiência do cliente.</li>
                </ul><br>
            </section>
        </div>
        <!------------CONHEÇA OS DESENVOLVEDORES------------>
        <div class="desenvolvedores">
            <h1 id="titulo-devs"><b>Conheça os Desenvolvedores</b></h1>
            <section id="dev1"> 
                <img src="Imagens/dev1.png" alt="Desenvolvedor 1">
                <h3>Ana Júlia Pereira da Silva Leal</h3>
            </section>
            <section id="dev2"> 
                <img src="Imagens/dev2.png" alt="Desenvolvedor 2">
                <h3>Julia Gonçalves de Souza Campos</h3>
            </section>
            <section id="dev3">
                <img src="Imagens/dev3.png" alt="Desenvolvedor 3">
                <h3>Larissa Salvadeo Santana</h3>
            </section>
            <section id="dev4"> 
                <img src="Imagens/dev4.png" alt="Desenvolvedor 4">
                <h3>Pietra Borgo Bernardi</h3>
            </section>    
            <section id="dev5"> 
                <img src="Imagens/dev5.png" alt="Desenvolvedor 5">
                <h3>Thales Navarro Neves</h3>
            </section>    
            <section id="devs">     
                <!--<img src="Imagens/devs.png" alt="Desenvolvedores">-->
            </section> 
        </div>   
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
        <nav>
            <ul>
                <li><a href="contato.php"><i class="fi fi-brands-instagram"></i></a></li>
                <li><a href="contato.php"><i class="fi fi-brands-facebook"></i></a></li>
            </ul>
        </nav> 
        <br>
        <p>&copy; 2026. Todos os direitos reservados.</p>    
    </footer>

    <script src="script.js"></script>
</body>
</html>