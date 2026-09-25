<?php
    include "util.php";       
    $conn = conecta();

    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];
    $admin = isset($_POST['admin']) ? 1 : 0;
    
    if (!empty($senha)) {
        $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
        $varSQL = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, telefone = :telefone, admin = :admin WHERE id_usuario = :id_usuario";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':senha', $senha_hash);
    } 
    else {
        $varSQL = "UPDATE usuario SET nome = :nome, email = :email, telefone = :telefone, admin = :admin WHERE id_usuario = :id_usuario";
        $update = $conn->prepare($varSQL);
    }

    $update->bindParam(':nome', $nome);
    $update->bindParam(':email', $email);
    $update->bindParam(':telefone', $telefone);
    $update->bindParam(':admin', $admin);
    $update->bindParam(':id_usuario', $id_usuario);

    if ( $update -> execute() ) {
        salvaUploadId($conn, $_FILES, 'imagem', $_POST['id_usuario']);
    }

    header("Location: usuarios.php");
    
?>