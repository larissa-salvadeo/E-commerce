<?php
    include "util.php";       
    $conn = conecta();

    $id_produto = $_POST['id_produto'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor_unitario = $_POST['valor_unitario'];

    if($_FILES['imagem']['name'] != ""){
        $nomeImagem = basename($_FILES['imagem']['name']);
        $caminhoImagem = "Imagens/" . $nomeImagem;
        move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);
        $varSQL = "UPDATE produto set nome = :nome, descricao = :descricao, valor_unitario = :valor_unitario, imagem = :imagem WHERE id_produto = :id_produto";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':imagem', $caminhoImagem);
    }
    else{
       $varSQL = "UPDATE produto set nome = :nome, descricao = :descricao, valor_unitario = :valor_unitario WHERE id_produto = :id_produto";
        $update = $conn->prepare($varSQL);
    }

    $update->bindParam(':nome', $nome);
    $update->bindParam(':descricao', $descricao);
    $update->bindParam(':valor_unitario', $valor_unitario);
    $update->bindParam(':id_produto', $id_produto);

    if ( $update ->execute() ) {
        salvaUploadId($conn, $_FILES, 'arquivo', $_POST['id_produto']);
    }

    header("Location: produtos.php");
    
?>