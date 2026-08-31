<html>
<body>
    <?php
        include "util.php";
        $conn = conecta();
        $id_usuario = $_GET['id_usuario'];

        $varSQL ="SELECT id_usuario, nome, email, telefone, admin FROM usuario WHERE id_usuario = :id_usuario";

        $select = $conn->prepare($varSQL);
        $select->bindParam(':id_usuario', $id_usuario);
        $select->execute();
        $linha = $select->fetch(); 

        $id_usuario = $linha['id_usuario'];
        $nome = $linha['nome'];
        $email = $linha['email'];
        $telefone = $linha['telefone'];
        $admin = $linha['admin'];
    ?>

    <form action='updateUsuarios.php' method='post' enctype="multipart/form-data">
        
        <input type='hidden' name='id_usuario' value='<?php echo $id_usuario; ?>'>
        Nome<br>
        <input type='text' name='nome' value='<?php echo $nome; ?>'><br>
        Email<br>
        <input type='email' name='email' value='<?php echo $email; ?>'><br>
        Nova Senha *(deixe em branco se não quiser alterar)*<br>
        <input type='password' name='senha' value=''><br><br>
        Telefone<br>
        <input type='text' name='telefone' value='<?php echo $telefone; ?>'><br>
        Admin<br>
        <input type='checkbox' name='admin' value='1' <?php if ($admin) echo 'checked'; ?>><br>
        Imagem<br>
        <input type='file' name='imagem' accept='image/*'><br>
        <br>
        <input type='submit' value='Salvar'>
    </form>
</body>
</html>