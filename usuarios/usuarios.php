<html>
    <head>
        <link rel="stylesheet" href="../style.css">
    </head>

    <body>
        <?php
            include "../util.php";
            
            $conn = conecta();
            //SaiseHacker();
            $varSQL = "SELECT id_usuario, nome, email, senha, telefone, imagem FROM usuario WHERE excluido = FALSE ORDER BY id_usuario ASC";
            $select = $conn->query($varSQL);

            echo "<center><table style='border: 2px #5F8565 dotted; width: 80%' border='2'> 
                    <thead style='background-color: #5F8565'>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>SENHA</th>
                            <th>TELEFONE</th>
                            <th>IMAGEM</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead></center>";

            while ($linha = $select->fetch() ){
                $id_usuario = $linha['id_usuario'];
                $nome = $linha['nome'];
                $email = $linha['email'];
                $senha = $linha['senha'];
                $telefone = $linha['telefone'];
                $imagem = $linha['imagem'];
        
                echo "<tr>
                        <td>$id_usuario</td>
                        <td>$nome</td>
                        <td>$email</td>
                        <td>$senha</td>
                        <td>$telefone</td>
                        <td><center> <img height=80 src='../$imagem'/> <center></td>
                        <td>
                            <div class='acoes'>
                                <a href='alterarUsuarios.php?id_usuario=".$id_usuario."'><img height=35 src='../Imagens/alterar.png'/></a>
                                <a href='excluirUsuarios.php?id_usuario=".$id_usuario."'><img height=35 src='../Imagens/excluir.png'/></a>
                            </div>
                        </td>
                        
                    </tr>";
            }

            echo "</table><br><br>";
            echo "<a href='adicionarUsuarios.php'><img height=60 src='../Imagens/adicionar.png'/></button>";
        
        ?>
    </body>
</html>