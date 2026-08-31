<html>
    <body>
        <form action = "insertProdutos.php" method = "POST" enctype="multipart/form-data"> 
            <label for = "nome">Nome: </label>
            <input type = "text" name = "nome"/>
            <br><br>
            <label for = "descricao">Descrição: </label>
            <input type = "text" name = "descricao"/>
            <br><br>
            <label for = "valor_unitario">Valor Unitário: </label>
            <input type = "number" name = "valor_unitario" step="0.01"/>
            <br><br>
            <label for = 'imagem'>Imagem: </label>
            <input type='file' name='imagem'><br>
            <br><br>
            <input type="submit" value="Adicionar"/>
        </form>
    </body>
</html>