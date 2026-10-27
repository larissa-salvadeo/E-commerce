<?php

include("util.php");
session_start();

$conn = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já existe
    $sql = "SELECT excluido FROM usuario WHERE email = :email LIMIT 1";

    $select = $conn->prepare($sql);
    $select->bindParam(":email", $email);
    $select->execute();

    $usuarioExistente = $select->fetch(PDO::FETCH_ASSOC);

    if ($usuarioExistente) {

        if ((int)$usuarioExistente['excluido'] === 1) {
            header("Location: index.php?cadastro=erro&msg=conta_excluida");
            exit;
        } else {
            header("Location: index.php?cadastro=erro&msg=email_ja_cadastrado");
            exit;
        }
    }
    // Cadastra o usuário
    $varSQL = "INSERT INTO usuario (nome, email, senha, telefone)
               VALUES (:nome, :email, :senha, :telefone)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":email", $email);
    $insert->bindParam(":senha", $senha_hash);
    $insert->bindParam(":telefone", $telefone);

    try {
        $insert->execute();
        $idUsuario = $conn->lastInsertId();

        $imagem = 'Imagens/usuario.png';

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = salvaUpload($conn, $_FILES, 'imagem');
        }

        if ($imagem != null) {

            $sqlImagem = "UPDATE usuario SET imagem = :imagem WHERE id_usuario = :id_usuario";

            $update = $conn->prepare($sqlImagem);

            $update->bindParam(":imagem", $imagem);
            $update->bindParam(":id_usuario", $idUsuario);

            $update->execute();
            $_SESSION['sessionImagem-Lumiere'] = $imagem;
        }

        // Cria a sessão
        $_SESSION['sessionConectado-Lumiere'] = TRUE;
        $_SESSION['sessionLogin-Lumiere'] = $email;
        $_SESSION['sessionNome-Lumiere'] = $nome;
        $_SESSION['sessionId-Lumiere'] = $idUsuario;


        // Cookie
        setcookie("usuarioLogado-Lumiere", $email, time() + (30 * 24 * 60 * 60), "/");

        header(
            "Location: index.php?cadastro=sucesso&nome=" . urlencode($nome)
        );
        exit;

    } catch (PDOException $e) {

    header(
        "Location: index.php?cadastro=erro&msg=Erro%20ao%20realizar%20o%20cadastro");
    exit;
}
}
?>