<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>

    <body>
        <?php
            include "util.php";
            
            $conn = conecta();

            $varSQL = "SELECT id_usuario, nome, email, senha, telefone, imagem FROM usuario WHERE excluido = FALSE";
            $select = $conn->query($varSQL);

            echo "<table style='border: 2px #0091ff dotted; width: 80%' border='2'> 
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>EMAIL</th>
                            <th>SENHA</th>
                            <th>TELEFONE</th>
                            <th>IMAGEM</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>";

            while ($linha = $select->fetch() ){
                $id_usuario = $linha['id_usuario'];
                $nome = $linha['nome'];
                $email = $linha['email'];
                $senha = $linha['senha'];
                $telefone = $linha['telefone'];
                $imagem = "Imagens/$id_usuario.png";

                if (!file_exists($imagem) ) {
                    $nomeArquivo = "Imagens/semnome.png";
                }      
        
                echo "<tr>
                        <td>$id_usuario</td>
                        <td>$nome</td>
                        <td>$email</td>
                        <td>$senha</td>
                        <td>$telefone</td>
                        <td><center> <img height=80 src='$imagem'/> <center></td>
                        <td>
                            <div>
                                <a href='alterarUsuarios.php?id_usuario=".$id_usuario."'> <center> <img height=35 src='Imagens/alterar.png'/> <center></a>
                                <a href='excluirUsuarios.php?id_usuario=".$id_usuario."'> <center> <img height=35 src='Imagens/excluir.png'/> <center></a>
                            </div>
                        </td>
                        
                    </tr>";
            }

            echo "</table><br><br>";
            echo "<a href='adicionarUsuarios.php'><img height=60 src='Imagens/adicionar.png'/></button>";
            echo "<a href='login.php'>Fazer Login</a>";
        
        ?>
    </body>
</html>