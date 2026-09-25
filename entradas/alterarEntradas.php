<html>
<body>
    <?php
        include "util.php";
        $conn = conecta();
        $id_entrada = $_GET['id_entrada'];
        $varSQL ="SELECT * FROM entrada WHERE id_entrada = :id_entrada";

        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_entrada', $id_entrada);
        $select->execute();
        $linha = $select->fetch(); 

        $id_entrada = $linha['id_entrada'];
        $fk_produto = $linha['fk_produto'];
        $quantidade = $linha['quantidade'];
        $custo_unitario = $linha['custo_unitario'];
        $obs = $linha['obs'];
        $data_entrada = $linha['data_entrada'];
    ?>

    <form action='updateEntradas.php' method='post' enctype="multipart/form-data">
        
        <input type='hidden' name='id_entrada' value='<?php echo $id_entrada; ?>'>
        <input type='hidden' name='fk_produto' value='<?php echo $fk_produto; ?>'>
        Quantidade<br>
        <input type='number' name='quantidade' value='<?php echo $quantidade; ?>' step="0.01"><br>
        Custo Unitário<br>
        <input type='number' name='custo_unitario' value='<?php echo $custo_unitario; ?>' step="0.01"><br>
        Observação<br>
        <input type='text' name='obs' value='<?php echo $obs; ?>'><br>
        Data de Entrada<br>
        <input type='date' name='data_entrada' value='<?php echo $data_entrada; ?>' required><br>
        Imagem<br>
        <input type='file' name='imagem' accept='image/*'><br>
        <br>
        <input type='submit' value='Salvar'>
    </form>
</body>
</html>