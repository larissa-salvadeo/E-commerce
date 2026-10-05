<?php
    include "util.php";       
    $conn = conecta();

    $fk_produto = $_POST['fk_produto'];
    $quantidade = $_POST['quantidade'];
    $custo_unitario = $_POST['custo_unitario'];
    $obs = $_POST['obs'];
    $data_entrada = $_POST['data_entrada'];
    
    $varSQL = "INSERT INTO entrada (fk_produto, quantidade, custo_unitario, obs, data_entrada)
               values (:fk_produto, :quantidade, :custo_unitario, :obs, :data_entrada)";

    $insert = $conn -> prepare($varSQL);
    $insert -> bindParam(":fk_produto", $fk_produto);
    $insert -> bindParam(":quantidade", $quantidade);
    $insert -> bindParam(":custo_unitario", $custo_unitario);
    $insert -> bindParam(":obs", $obs);
    $insert -> bindParam(":data_entrada", $data_entrada);

    if ($insert ->execute() ) {
        salvaUpload($conn, $_FILES, 'imagem');
    }

    header("Location: entradas.php");
?>