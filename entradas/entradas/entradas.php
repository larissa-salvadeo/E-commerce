<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php
            include "util.php";
            
            $conn = conecta();

            $varSQL = "SELECT * FROM entrada";
            $select = $conn->query($varSQL);

            echo "<table style='border: 2px #0091ff dotted; width: 80%' border='2'> 
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>FK_PRODUTO</th>
                            <th>QUANTIDADE</th>
                            <th>CUSTO UNITÁRIO</th>
                            <th>OBSERVAÇÃO</th>
                            <th>DATA ENTRADA</th>
                            <th>IMAGEM</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>";
            
            while ($linha = $select->fetch() ){
                $id_entrada = $linha['id_entrada'];
                $fk_produto = $linha['fk_produto'];
                $quantidade = $linha['quantidade'];
                $custo_unitario = $linha['custo_unitario'];
                $obs = $linha['obs'];
                $data_entrada = $linha['data_entrada'];
                $imagem = "Imagens/$id_entrada.png";

                echo "<tr>
                        <td>$id_entrada</td>
                        <td>$fk_produto</td>
                        <td>$quantidade</td>
                        <td><center>$custo_unitario<center></td>
                        <td><center>$obs<center></td>
                        <td><center>$data_entrada<center></td>
                        <td><center> <img height=80 src='$imagem'/> <center></td>
                        <td>
                            <div>
                                <a href='alterarEntradas.php?id_entrada=".$id_entrada."'> <center> <img height=35 src='Imagens/alterar.png'/> <center></a>
                                <a href='excluirEntradas.php?id_entrada=".$id_entrada."'> <center> <img height=35 src='Imagens/excluir.png'/> <center></a>
                            </div>
                        </td>
                        
                    </tr>";
            }

            echo "</table><br><br>";
            echo "<a href='adicionarEntradas.php'><img height=60 src='Imagens/adicionar.png'/></button>";
        
        ?>
    </body>
</html>