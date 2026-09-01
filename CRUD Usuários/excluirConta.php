<?php

session_start();
include("../util.php");

$conn = conecta();

if (
    !isset($_SESSION['sessionConectado']) ||
    $_SESSION['sessionConectado'] !== TRUE ||
    !isset($_SESSION['sessionId'])
) {
    header("Location: ../index.php");
    exit;
}

$id_usuario = $_SESSION['sessionId'];

$sql = "UPDATE usuario
        SET excluido = TRUE,
            data_exclusao = CURRENT_TIMESTAMP
        WHERE id_usuario = :id_usuario";

$update = $conn->prepare($sql);
$update->bindParam(':id_usuario', $id_usuario);
$update->execute();

session_unset();
session_destroy();

setcookie("usuarioLogado", "", time() - 3600, "/");

header("Location: ../index.php?conta=excluida");
exit;

?>