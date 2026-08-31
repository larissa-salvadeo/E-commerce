<?php

session_start();

include("../util.php");

$conn = conecta();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $varSQL = "SELECT nome, email, senha 
               FROM usuario 
               WHERE email = :usuario 
               AND excluido = FALSE";

    $select = $conn->prepare($varSQL);

    $select->bindParam(':usuario', $usuario);

    $select->execute();

    $linha = $select->fetch(PDO::FETCH_ASSOC);

    if (!$linha) {

        header("Location: ../index.php?login=erro&msg=Usuario%20nao%20encontrado");
        exit;

    }

    if (!password_verify($senha, $linha['senha'])) {

        header("Location: ../index.php?login=erro&msg=Senha%20incorreta");
        exit;
    }

    // Login correto
    $_SESSION['sessionConectado'] = TRUE;
    $_SESSION['sessionLogin'] = $linha['email'];
    $_SESSION['sessionNome'] = $linha['nome'];

    setcookie(
        "usuarioLogado",
        $linha['email'],
        time() + (30 * 24 * 60 * 60),
        "/"
    );

    header("Location: ../index.php?login=sucesso");
    exit;
}
?>