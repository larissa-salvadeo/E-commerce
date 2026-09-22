<?php

// PHPMailer
require_once __DIR__ . '/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/PHPMailer/src/SMTP.php';

// Inicia a sessão somente se ainda não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Endereço do site
$_SESSION['sessaoSite'] = "http://localhost/E-commerce";

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
        if(isset( $paramFiles[$paramCampo])) {
            $ext = pathinfo($paramFiles[$paramCampo]['name'],PATHINFO_EXTENSION);
            $nomeUnico = uniqid();
            $arquivoFisico = __DIR__ . "/Imagens/$nomeUnico.$ext";
            $arquivoNovo = "../Imagens/$nomeUnico.$ext";
            if (move_uploaded_file($paramFiles[$paramCampo]['tmp_name'],$arquivoFisico)) {
                return "Imagens/$nomeUnico.$ext";;
            }    
        }
        return null;
    }

    function ExecutaSQL($Conn, $sql, $parametros = []) {
        $stmt = $Conn->prepare($sql);
        $stmt->execute($parametros);
        return $stmt;
    }
    
    function SaiSeHacker(){
        $autorizadoAdmin = ((isset($_SESSION['sessionAdmin'])) and ($_SESSION['sessionAdmin'] == true));
        if (!$autorizadoAdmin) {
            header ("location: /index.php");
            exit;
        }
    }

    function LogaAutomatico ($paramLogin, $paramSenha){
        $_SESSION['sessionConectado'] = ValidaLogin($paramLogin, $paramSenha, $nome, $foto, $eh_admin);
        $_SESSION['sessionAdmin'] = $eh_admin;
        if ( $_SESSION['sessionConectado'] ) {
            DefineCookie('loginCookie', $login, 60);
            $_SESSION['sessionLogin'] = $login;
            $_SESSION['sessionNome'] = $nome;
            $_SESSION['sessionFoto'] = $foto;
            header('Location: /index.php');
        }
    }

    function Raiz() {
        return str_replace('\\','/',$_SERVER['DOCUMENT_ROOT']);
    }

    function ImagemJaExiste ($paramImagem){
        $caminhoFisico = Raiz()."/$paramImagem";
        return file_exists($caminhoFisico);
    }
?>