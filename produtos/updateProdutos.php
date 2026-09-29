<?php
    include "../util.php";       
    $conn = conecta();

    $id_produto = $_POST['id_produto'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor_unitario = $_POST['valor_unitario'];
    
    $varSQL = "UPDATE produto set nome = :nome, descricao = :descricao, valor_unitario = :valor_unitario WHERE id_produto = :id_produto";

    $update = $conn->prepare($varSQL);
    $update->bindParam(':nome', $nome);
    $update->bindParam(':descricao', $descricao);
    $update->bindParam(':valor_unitario', $valor_unitario);
    $update->bindParam(':id_produto', $id_produto);

    if($update->execute()){
        $imagem = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = salvaUpload($conn, $_FILES, 'imagem');
        }

        if ($imagem != null) {

            $sqlImagem = "UPDATE produto SET imagem = :imagem WHERE id_produto = :id_produto";

            $update = $conn->prepare($sqlImagem);

            $update->bindParam(":imagem", $imagem);
            $update->bindParam(":id_produto", $id_produto);

            $update->execute();
        }
    }  

    header("Location: produtosCrud.php");
    
?>