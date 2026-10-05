<?php
    session_start();
    include("util.php");

    // Só aceita POST de usuário logado
    if (!isset($_SESSION['sessionConectado-Lumiere']) || $_SESSION['sessionConectado-Lumiere'] !== TRUE
        || $_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: index.php");
        exit;
    }

    $conn = conecta();

    $imagemPadrao = 'Imagens/usuario.png';

    $id       = $_SESSION['sessionId-Lumiere'];
    $nome     = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);

    // ---------- Validações ----------
    if ($nome === '' || $telefone === '') {
        header("Location: paginaUsuario.php?msg=" . urlencode("Preencha nome e telefone"));
        exit;
    }

    // Telefone: só números, parênteses, espaço, + e - (10 ou 11 dígitos)
    $digitos = preg_replace('/\D/', '', $telefone);
    if (!preg_match('/^[0-9()\s+-]+$/', $telefone) || strlen($digitos) < 10 || strlen($digitos) > 11) {
        header("Location: paginaUsuario.php?msg=" . urlencode("Telefone inválido. Use DDD + número"));
        exit;
    }

    // ---------- Imagem ----------
    // Por padrão mantém a imagem atual
    $imagemAntiga = isset($_SESSION['sessionImagem-Lumiere']) ? $_SESSION['sessionImagem-Lumiere'] : $imagemPadrao;
    $imagem = $imagemAntiga;

    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {

        $permitidos = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array(mime_content_type($_FILES['imagem']['tmp_name']), $permitidos)) {
            header("Location: paginaUsuario.php?msg=" . urlencode("Envie uma imagem JPG, PNG ou WEBP"));
            exit;
        }

        if ($_FILES['imagem']['size'] > 3 * 1024 * 1024) {
            header("Location: paginaUsuario.php?msg=" . urlencode("A imagem deve ter no máximo 3 MB"));
            exit;
        }

        // Mesma função e mesma pasta usadas no cadastrar.php
        $novaImagem = salvaUpload($conn, $_FILES, 'imagem');

        if ($novaImagem == null) {
            header("Location: paginaUsuario.php?msg=" . urlencode("Não foi possível salvar a imagem"));
            exit;
        }

        $imagem = $novaImagem;
    }

    // ---------- Salva no banco ----------
    try {
        $varSQL = "UPDATE usuario SET nome = :nome, telefone = :telefone, imagem = :imagem WHERE id_usuario = :id";
        $update = $conn->prepare($varSQL);
        $update->bindParam(':nome', $nome);
        $update->bindParam(':telefone', $telefone);
        $update->bindParam(':imagem', $imagem);
        $update->bindParam(':id', $id);
        $update->execute();
    } catch (PDOException $e) {
        // Se falhou, remove a imagem nova para não deixar arquivo solto
        if ($imagem !== $imagemAntiga && file_exists($imagem)) {
            unlink($imagem);
        }
        header("Location: paginaUsuario.php?msg=" . urlencode("Erro ao salvar os dados. Tente novamente"));
        exit;
    }

    // Apaga a foto antiga do servidor (nunca a imagem padrão)
    if ($imagem !== $imagemAntiga && $imagemAntiga !== $imagemPadrao && file_exists($imagemAntiga)) {
        unlink($imagemAntiga);
    }

    // Atualiza a sessão para o restante do site refletir a mudança
    $_SESSION['sessionNome-Lumiere']   = $nome;
    $_SESSION['sessionImagem-Lumiere'] = $imagem;

    header("Location: paginaUsuario.php?msg=" . urlencode("Dados atualizados com sucesso"));
    exit;
?>
