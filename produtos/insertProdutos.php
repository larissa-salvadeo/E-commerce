<?php
include("../util.php");
$conn = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $valor_unitario = $_POST['valor_unitario'];
    $imagem = salvaUpload($conn, $_FILES, 'imagem');

     $varSQL = "INSERT INTO produto (nome, descricao, valor_unitario, imagem)
               values (:nome, :descricao, :valor_unitario, :imagem)";

    $insert = $conn -> prepare($varSQL);
    $insert -> bindParam(":nome", $nome);
    $insert -> bindParam(":descricao", $descricao);
    $insert -> bindParam(":valor_unitario", $valor_unitario);
    $insert -> bindParam(":imagem", $imagem);

    if ($insert ->execute() ) {
        header("Location: produtosCrud.php");;
        exit;
    }    
}
?>