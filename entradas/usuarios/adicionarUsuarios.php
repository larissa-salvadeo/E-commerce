<html>
    <body>
        <?php
            include "../util.php";
            $conn = conecta();
            include "../_cabecalho.php";
            SaiseHacker();
        ?>
         <form action="insertUsuarios.php" method="POST" enctype="multipart/form-data">
                        <h1>Cadastrar Conta</h1>
                        <input type="text" placeholder="Nome" name="nome" required/>
                        <input type="email" placeholder="Email" name="email" required/>
                        <input type="password" placeholder="Senha" name="senha" required />
                        <input type="text" placeholder="Telefone" name="telefone" required/>
                        <input type="file" placeholder="Imagem" name="imagem"/>
                        <button type="submit">Cadastrar</button>
            </form>
    </body>
</html>