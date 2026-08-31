<?php
    include "util.php";       
    $conn = conecta();

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor_unitario = $_POST['valor_unitario'];
    
    $nomeImagem = basename($_FILES['imagem']['name']);
    $caminhoImagem = "Imagens/" . $nomeImagem;
    move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem);

    
    $varSQL = "INSERT INTO produto (nome, descricao, valor_unitario, imagem)
               values (:nome, :descricao, :valor_unitario, :imagem)";

    $insert = $conn -> prepare($varSQL);
    $insert -> bindParam(":nome", $nome);
    $insert -> bindParam(":descricao", $descricao);
    $insert -> bindParam(":valor_unitario", $valor_unitario);
    $insert -> bindParam(":imagem", $caminhoImagem);

    if ($insert ->execute() ) {
        salvaUpload($conn, $_FILES, 'imagem');
    }

    header("Location: produtos.php");
?>