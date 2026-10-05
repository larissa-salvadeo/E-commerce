<?php
    include ("util.php");
    $conn = conecta();
    $id_entrada = $_GET['id_entrada'];
    $varSQL = "DELETE FROM entrada WHERE id_entrada = :id_entrada";

    $delete = $conn->prepare($varSQL);
    $delete->bindParam(':id_entrada', $id_entrada);
    $delete->execute();
    
    header("Location: entradas.php");
?>