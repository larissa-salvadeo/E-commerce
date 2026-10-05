<?php
    include ("util.php");
    $conn = conecta();
    $id_produto = $_GET['id_produto'];
    $varSQL = "UPDATE produto SET excluido = TRUE, data_exclusao = NOW() WHERE id_produto = :id_produto";

    $delete = $conn->prepare($varSQL);
    $delete->bindParam(':id_produto', $id_produto);
    $delete->execute();
    
    header("Location: produtos.php");
?>