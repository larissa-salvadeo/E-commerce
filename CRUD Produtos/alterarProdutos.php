<html>
<body>
    <?php
        include "util.php";
        $conn = conecta();
        $id_produto = $_GET['id_produto'];
        $varSQL ="SELECT * FROM produto WHERE id_produto = :id_produto";

        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_produto', $id_produto);
        $select->execute();
        $linha = $select->fetch(); 

        $id_produto = $linha['id_produto'];
        $nome = $linha['nome'];
        $descricao = $linha['descricao'];
        $valor_unitario = $linha['valor_unitario'];
    ?>

    <form action='updateProdutos.php' method='post' enctype="multipart/form-data">
        
        <input type='hidden' name='id_produto' value='<?php echo $id_produto; ?>'>
        Nome<br>
        <input type='text' name='nome' value='<?php echo $nome; ?>'><br>
        Descrição<br>
        <input type='text' name='descricao' value='<?php echo $descricao; ?>'><br>
        Valor Unitário<br>
        <input type='number' name='valor_unitario' value='<?php echo $valor_unitario; ?>' step="0.01"><br>
        Imagem<br>
        <input type='file' name='imagem'><br>
        <br>
        <input type='submit' value='Salvar'>
    </form>
</body>
</html>