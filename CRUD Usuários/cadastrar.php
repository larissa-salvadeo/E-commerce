<?php

include("../util.php");

$conn = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];

    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);

    // Verifica se o e-mail já existe
    $sql = "SELECT email FROM usuario WHERE email = :email";

    $select = $conn->prepare($sql);
    $select->bindParam(":email", $email);
    $select->execute();

    if ($select->fetch()) {

        header("Location: ../index.php?cadastro=erro&msg=Este%20email%20ja%20esta%20cadastrado");
        exit;
    }

    $varSQL = "INSERT INTO usuario 
               (nome, email, senha, telefone)
               VALUES 
               (:nome, :email, :senha, :telefone)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":email", $email);
    $insert->bindParam(":senha", $senha_hash);
    $insert->bindParam(":telefone", $telefone);

    try {

        if ($insert->execute()) {

            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                salvaUpload($conn, $_FILES, 'imagem');
            }

            header("Location: ../index.php?cadastro=sucesso");
            exit;

        } else {

            header("Location: ../index.php?cadastro=erro&msg=Não%20foi%20possivel%20realizar%20o%20cadastro");
            exit;
        }

    } catch (PDOException $e) {

        header("Location: ../index.php?cadastro=erro&msg=Erro%20ao%20realizar%20o%20cadastro");
        exit;
    }
}
?>