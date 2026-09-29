<?php

session_start();
include("util.php");

$conn = conecta();

if (
    !isset($_SESSION['sessionConectado-Lumiere']) ||
    $_SESSION['sessionConectado-Lumiere'] !== TRUE ||
    !isset($_SESSION['sessionId-Lumiere'])
) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['sessionId-Lumiere'];

$sql = "UPDATE usuario
        SET excluido = TRUE,
            data_exclusao = CURRENT_TIMESTAMP
        WHERE id_usuario = :id_usuario";

$update = $conn->prepare($sql);
$update->bindParam(':id_usuario', $id_usuario);
$update->execute();

session_unset();
session_destroy();

setcookie("usuarioLogado-Lumiere", "", time() - 3600, "/");

header("Location: index.php?conta=excluida");
exit;

?>