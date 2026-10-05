<?php
    ob_start(); // permite redirecionar mesmo depois de incluir o cabeçalho
    include("util.php");
    include("_cabecalho.php"); 

    if (!isset($_SESSION['sessionConectado-Lumiere']) || $_SESSION['sessionConectado-Lumiere'] !== TRUE) {
        header("Location: index.php");
        exit;
    }

    $varSQL = "SELECT nome, email, telefone, admin, imagem FROM usuario WHERE id_usuario = :id AND excluido = FALSE";
    $select = $conn->prepare($varSQL);
    $select->bindParam(':id', $_SESSION['sessionId-Lumiere']);
    $select->execute();
    $usuario = $select->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        header("Location: logout.php");
        exit;
    }

    $imagem = !empty($usuario['imagem']) ? $usuario['imagem'] : 'Imagens/usuario.png';
    $tipo   = in_array($usuario['admin'], [true, 1, '1', 't', 'true'], true) ? 'Admin' : 'Cliente';
?>

    <main class="user">
            <div class="blocoFoto">
                <img src="<?= htmlspecialchars($imagem) ?>" alt="Foto do usuário">
                <p><?= $tipo ?></p>
                <h1><?= htmlspecialchars($usuario['nome']) ?></h1>
            </div>

            <div class="blocoInfo">
                <div class="blocoNome">
                    <h1>Dados da conta</h1>
                </div>
                <div class="blocoDado">
                    <div>
                        <i class="fi fi-rr-phone-call"></i>
                        <h1>Telefone</h1>
                    </div>
                    <p><?= htmlspecialchars($usuario['telefone']) ?></p>
                </div>
                <div class="blocoDado">
                    <div>
                        <i class="fi fi-rr-envelope"></i>
                        <h1>Email</h1>
                    </div>
                    <p><?= htmlspecialchars($usuario['email']) ?></p>
                </div>
                <button type="button" onclick="editarUser()">Editar</button>
            </div>

        <div class="editarPopup">
            <div class="blocoPopup">
                <div class="tituloEditar">
                    <i class="fi fi-rr-arrow-small-left" onclick="editarUser()"></i>
                    <h1>Altere seus dados</h1>
                </div>
                <form action="atualizarUsuario.php" method="POST" enctype="multipart/form-data">
                    <div class="imagemEditar">
                        <img id="previaImagem" src="<?= htmlspecialchars($imagem) ?>" alt="Foto do usuário">
                        <div>
                            <div>
                                <label for="arquivo-upload" class="botao-customizado"><i class="fi fi-rr-camera"></i>Câmera</label>
                                <input type="file" id="arquivo-upload" class="input-escondido" name="imagem" accept="image/*">
                            </div>
                            <div>
                                <input type="text" placeholder="Nome" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required/>
                                <input type="tel" placeholder="Telefone" name="telefone" value="<?= htmlspecialchars($usuario['telefone']) ?>" required/>
                            </div>
                        </div>
                    </div>
                    <button type="submit">Salvar</button>
                </form>
            </div>
        </div>
    </main>

    <?php if (isset($_GET['msg'])): ?>
    <script>alert(<?= json_encode($_GET['msg']) ?>);</script>
    <?php endif; ?>

<?php include("_rodape.php"); ?>
