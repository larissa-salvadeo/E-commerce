<?php

// PHPMailer
require_once __DIR__ . '/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/PHPMailer/src/SMTP.php';

// Inicia a sessão somente se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Endereço do site
$_SESSION['sessaoSite'] = "https://eq.projetoscti.com.br/loja2b";

function EnviaEmail(
    $pEmailDestino,
    $pAssunto,
    $pHtml,
    $pUsuario = "lumiere.velasaromaticascti@gmail.com",
    $pSenha = "gfdixdcxgczrymqs",
    $pSMTP = "smtp.gmail.com"
) {
    try {

        $mail = new PHPMailer();

        // Configuração SMTP
        $mail->SMTPDebug = 0;
        $mail->IsSMTP();

        $mail->Host = $pSMTP;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Conta Gmail
        $mail->Username = $pUsuario;
        $mail->Password = $pSenha;

        // Remetente
        $mail->From = $pUsuario;
        $mail->FromName = "Suporte de senhas";

        // Destinatário
        $mail->AddAddress($pEmailDestino, "Usuario");

        // Mensagem
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $pAssunto;
        $mail->Body = $pHtml;

        // Envia
        return $mail->Send();

    } catch (Exception $e) {

        return false;
    }
}

    function conecta($paramString = ""){
        if($paramString == ""){
            $string_conexao = "pgsql:host=projetoscti.com.br; port=54432;
            dbname=loja2b; user=loja2b; password=J1ZZ7iuMVcK0E2fA";


        }
        else{
            $string_conexao = $paramString;
        }
        try {
            $c = new PDO($string_conexao);
        } 
        catch (PDOException $e) { 
            echo "Não conectado";
            exit;
        }
        return $c;
    }

   function salvaUpload($paramConn, $paramFiles, $paramCampo)
{
    if (
        !isset($paramFiles[$paramCampo]) ||
        $paramFiles[$paramCampo]['error'] !== UPLOAD_ERR_OK
    ) {
        return null;
    }

    $arquivo = $paramFiles[$paramCampo];

    // Limite de 2 MB
    if ($arquivo['size'] > 2 * 1024 * 1024) {
        return null;
    }

    // Verifica se é realmente uma imagem
    $infoImagem = getimagesize($arquivo['tmp_name']);

    if ($infoImagem === false) {
        return null;
    }

    // Permite somente estes tipos
    $tiposPermitidos = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/gif'  => 'gif',
        'image/webp' => 'webp'
    ];

    $mime = $infoImagem['mime'];

    if (!isset($tiposPermitidos[$mime])) {
        return null;
    }

    $extensao = $tiposPermitidos[$mime];

    // Nome gerado pelo servidor
    $nomeUnico = bin2hex(random_bytes(16));

    $arquivoFisico = __DIR__ . "/Imagens/$nomeUnico.$extensao";

    if (move_uploaded_file(
        $arquivo['tmp_name'],
        $arquivoFisico
    )) {
        return "Imagens/$nomeUnico.$extensao";
    }

    return null;
}

    function ExecutaSQL($Conn, $sql, $parametros = []) {
        $stmt = $Conn->prepare($sql);
        $stmt->execute($parametros);
        return $stmt;
    }
    
    function SaiSeHacker(){
        $autorizadoAdmin = ((isset($_SESSION['sessionAdmin-Lumiere'])) and ($_SESSION['sessionAdmin-Lumiere'] == true));
        if (!$autorizadoAdmin) {
            header ("Location: ../index.php");
            exit;
        }
    }

    function LogaAutomatico ($paramLogin, $paramSenha){
        $_SESSION['sessionConectado-Lumiere'] = ValidaLogin($paramLogin, $paramSenha, $nome, $foto, $eh_admin);
        $_SESSION['sessionAdmin-Lumiere'] = $eh_admin;
        if ( $_SESSION['sessionConectado-Lumiere'] ) {
            DefineCookie('loginCookie', $login, 60);
            $_SESSION['sessionLogin-Lumiere'] = $login;
            $_SESSION['sessionNome-Lumiere'] = $nome;
            $_SESSION['sessionFoto-Lumiere'] = $foto;
            header('Location: index.php');
        }
    }

    function Raiz() {
        return str_replace('\\','/', $_SERVER['DOCUMENT_ROOT']).$_SESSION['raiz'];
    }

    function ImagemJaExiste ($paramImagem){
        $caminhoFisico = Raiz()."/$paramImagem";
        return file_exists($caminhoFisico);
    }

    function ValorSQL( $pConn, $pSQL ) 
  {
   $linha = $pConn->query($pSQL)->fetch();
   if ( $linha ) { 
       return $linha[0]; // equivale a retornar o valor do campo
   } else { 
       return "0"; 
   }
  }
?>