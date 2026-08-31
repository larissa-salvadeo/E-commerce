<?php
    include ("util.php");
    $conn = conecta();
    $id_usuario = $_GET['id_usuario'];
    $varSQL = "UPDATE usuario SET excluido = TRUE, data_exclusao = NOW() WHERE id_usuario = :id_usuario";

    $delete = $conn->prepare($varSQL);
    $delete->bindParam(':id_usuario', $id_usuario);
    $delete->execute();
    
    header("Location: usuarios.php");
?>