<?php
    include "util.php";

    $conn = conecta();

    $varSQL = "SELECT * FROM produto";
    $select = $conn->query($varSQL);
?>

<html>
    <body>
        <form action = "insertEntradas.php" method = "POST" enctype="multipart/form-data"> 
            <select name="fk_produto" required>
                <option value="">Selecione um produto</option>
                    <?php
                        while($produto = $select-> fetch()) {
                    ?>
                        
                        <option value="<?= $produto['id_produto'] ?>">
                            <?= $produto['nome'] ?>
                        </option>
                    
                    <?php
                    }
                    ?>
            </select>
            <br><br>
            <label for = "quantidade">Quantidade: </label>
            <input type = "number" name = "quantidade" step="0.01"/>
            <br><br>
            <label for = "custo_unitario">Custo Unitário: </label>
            <input type = "number" name = "custo_unitario" step="0.01"/>
            <br><br>
            <label for = 'obs'>Observação: </label>
            <input type='text' name='obs'><br>
            <br><br>
            <label for = 'data_entrada'>Data de Entrada: </label>
            <input type='date' name='data_entrada'><br>
            <br><br>
            <label for = 'imagem'>Imagem: </label>
            <input type='file' name='imagem'><br>
            <br><br>
            <input type="submit" value="Adicionar"/>
        </form>
    </body>
</html>