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
    $sql = "SELECT email FROM usuario WHERE email = :email";

    $select = $conn->prepare($sql);
    $select->bindParam(":email", $email);
    $select->execute();

    if ($select->fetch()){
        header("Location: index.php?cadastro=erro&msg=Este%20email%20ja%20esta%20cadastrado");
        exit;
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

        $imagem = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = salvaUpload($conn, $_FILES, 'imagem');
        }

        if ($imagem != null) {

            $sqlImagem = "UPDATE usuario SET imagem = :imagem WHERE id_usuario = :id_usuario";

            $update = $conn->prepare($sqlImagem);

            $update->bindParam(":imagem", $imagem);
            $update->bindParam(":id_usuario", $idUsuario);

            $update->execute();
            $_SESSION['sessionImagem'] = $imagem;
        }

        // Cria a sessão
        $_SESSION['sessionConectado'] = TRUE;
        $_SESSION['sessionLogin'] = $email;
        $_SESSION['sessionNome'] = $nome;
        $_SESSION['sessionId'] = $idUsuario;


        // Cookie
        setcookie("usuarioLogado", $email, time() + (30 * 24 * 60 * 60), "/");

        header(
            "Location: index.php?cadastro=sucesso&nome=" . urlencode($nome)
        );
        exit;

    } catch (PDOException $e) {

    header(
        "Location: index.php?cadastro=erro&msg=Erro%20ao%20realizar%20o%20cadastro"
    );
    exit;
}
}
?>