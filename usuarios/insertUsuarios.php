<?php
include("../util.php");
$conn = conecta();
include "../_cabecalho.php";
//SaiseHacker();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $telefone = $_POST['telefone'];

    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Verifica se o email já existe
    $sql = "SELECT email FROM usuario WHERE email = :email";

    $select = $conn->prepare($sql);
    $select->bindParam(":email", $email);
    $select->execute();

    if ($select->fetch()){
    ?>
    <script>
        alert("Email já cadastrado!");
        window.location.href = "usuarios.php"; 
    </script>
    <?php
    exit;
}

    // Cadastra o usuário
    $varSQL = "INSERT INTO usuario (nome, email, senha, telefone)
               VALUES (:nome, :email, :senha, :telefone)";

    $insert = $conn->prepare($varSQL);

    $insert->bindParam(":nome", $nome);
    $insert->bindParam(":email", $email);
    $insert->bindParam(":senha", $senha_hash);
    $insert->bindParam(":telefone", $telefone);

    if($insert->execute()){
        $idUsuario = $conn->lastInsertId();

        $imagem = "/Imagens/usuario.png";

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
            $imagem = salvaUpload($conn, $_FILES, 'imagem');
        }

        if ($imagem != null) {

            $sqlImagem = "UPDATE usuario SET imagem = :imagem WHERE id_usuario = :id_usuario";

            $update = $conn->prepare($sqlImagem);

            $update->bindParam(":imagem", $imagem);
            $update->bindParam(":id_usuario", $idUsuario);

            $update->execute();
        }
    }    
    
    header("Location: usuarios.php");
    exit;
}
?>