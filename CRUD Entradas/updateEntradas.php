<?php
    include "util.php";       
    $conn = conecta();

    $id_entrada = $_POST['id_entrada'];
    $fk_produto = $_POST['fk_produto'];
    $quantidade = $_POST['quantidade'];
    $custo_unitario = $_POST['custo_unitario'];
    $obs = $_POST['obs'];
    $data_entrada = $_POST['data_entrada'];

    $varSQL = "UPDATE entrada SET fk_produto = :fk_produto, quantidade = :quantidade, custo_unitario = :custo_unitario, obs = :obs, data_entrada = :data_entrada WHERE id_entrada = :id_entrada";
    $update = $conn->prepare($varSQL);

    $update->bindParam(':fk_produto', $fk_produto);
    $update->bindParam(':quantidade', $quantidade);
    $update->bindParam(':custo_unitario', $custo_unitario);
    $update->bindParam(':obs', $obs);
    $update->bindParam(':data_entrada', $data_entrada);
    $update->bindParam(':id_entrada', $id_entrada);

    if ( $update ->execute() ) {
        salvaUploadId($conn, $_FILES, 'arquivo', $_POST['id_entrada']);
    }

    header("Location: entradas.php");
    
?>