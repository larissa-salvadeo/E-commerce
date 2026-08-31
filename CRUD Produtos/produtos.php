<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php
            include "util.php";
            
            $conn = conecta();

            $varSQL = "SELECT * FROM produto WHERE excluido = FALSE";
            $select = $conn->query($varSQL);

            echo "<table style='border: 2px #0091ff dotted; width: 80%' border='2'> 
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>DESCRIÇÃO</th>
                            <th>VALOR UNITÁRIO</th>
                            <th>QUANTIDADE ESTOQUE</th>
                            <th>IMAGEM</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>";
            
            $sql_conta = "SELECT COUNT(*) FROM produto WHERE excluido = FALSE AND nome = :nome";
            $select_count = $conn->prepare($sql_conta);

            while ($linha = $select->fetch() ){
                $id_produto = $linha['id_produto'];
                $nome = $linha['nome'];
                $descricao = $linha['descricao'];
                $valor = $linha['valor_unitario'];

                $select_count->bindParam(':nome', $nome);
                $select_count->execute();

                $qtd_estoque = $select_count->fetchColumn();

                $imagem = $linha['imagem'];
                $excluido = $linha['excluido'];
                $data_exclusao = $linha['data_exclusao'];

                echo "<tr>
                        <td>$id_produto</td>
                        <td>$nome</td>
                        <td>$descricao</td>
                        <td><center>$valor<center></td>
                        <td><center>$qtd_estoque<center></td>
                        <td><center> <img height=80 src='$imagem'/> <center></td>
                        <td>
                            <div>
                                <a href='alterarProdutos.php?id_produto=".$id_produto."'> <center> <img height=35 src='Imagens/alterar.png'/> <center></a>
                                <a href='excluirProdutos.php?id_produto=".$id_produto."'> <center> <img height=35 src='Imagens/excluir.png'/> <center></a>
                            </div>
                        </td>
                        
                    </tr>";
            }

            echo "</table><br><br>";
            echo "<a href='adicionarProdutos.php'><img height=60 src='Imagens/adicionar.png'/></button>";
        
        ?>
    </body>
</html>