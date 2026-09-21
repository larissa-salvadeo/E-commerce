<?php 
 /*//// PARA ENVIO DE EMAILS PHPMAILER //////
  require __DIR__.'/PHPMailer/PHPMailer/src/PHPMailer.php';
  require __DIR__.'/PHPMailer/PHPMailer/src/SMTP.php';
  # use "use" after include or require
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  ////////////////////////////////////////////

      //////////////////////////////////////////////////////////////// 
  // Envio de emails
  // Marcelo C Peres 2023
  /* Exemplo: 
     if ( EnviaEmail ('fulano@fulano','Feliz Aniversario',
                      '<html><body>Feliz niver</body></html>') 
     {
      echo 'enviado com sucesso';
     }
  */   
     
  ////////////////////////////////////////////////////////////////
  /*function EnviaEmail ( $pEmailDestino, $pAssunto, $pHtml, 
                        $pUsuario = "seu_email_aqui", 
                        $pSenha = "sua_senha_aqui", 
                        $pSMTP = "smtp.gmail.com" )   
  {   
      
   try {
 
     //cria instancia de phpmailer
     echo "<br>Tentando enviar para $pEmailDestino...";
     $mail = new PHPMailer(); 
     $mail->IsSMTP();  
  
     // servidor smtp
     $mail->Host = $pSMTP;
     $mail->SMTPAuth = true;      // requer autenticacao com o servidor                         
     $mail->SMTPSecure = 'tls';                            
      
     $mail-> SMTPOptions = array (
       'ssl' => array (
       'verificar_peer' => false,
       'verify_peer_name' => false,
       'allow_self_signed' => true ) );
      
     $mail->Port = 587;      
      
     $mail->Username = $pUsuario; 
     $mail->Password = $pSenha; 
     $mail->From = $pUsuario; 
     $mail->FromName = "Suporte de senhas"; 
  
     $mail->AddAddress($pEmailDestino, "Usuario"); 
     $mail->IsHTML(true); 
     $mail->Subject = $pAssunto; 
     $mail->Body = $pHtml;
     $enviado = $mail->Send(); 
       
     if (!$enviado) {
        echo "<br>Erro: " . $mail->ErrorInfo;
     } else {
        echo "<br><b>Enviado!</b>";
     }
     return $enviado;         
      
   } catch (phpmailerException $e) {
     echo $e->errorMessage(); // erros do phpmailer
   } catch (Exception $e) {
     echo $e->getMessage();  // erros da aplicacao - gerais
   }      
  }
    */
    function conecta($paramString = ""){
        if($paramString == ""){
            $string_conexao = "pgsql:host=localhost; port=5432;
            dbname=usuario; user=postgres; password=postgres";
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
            $arquivoNovo = "imgs/$nomeUnico.$ext";
            try {
               if (move_uploaded_file($paramFiles[$paramCampo]['tmp_name'],$arquivoNovo)) {
                   return $arquivoNovo;
               } 
            } catch (PDOException $e) {
               return null;
            }     
        }
    }

    function SaiSeHacker(){
        $autorizadoAdmin = ((isset($_SESSION['sessaoAdmin'])) and ($_SESSION['sessaoAdmin'] == true));
        if (!$autorizadoAdmin) {
            header ("location: /index.php");
            exit;
        }
    }

    function LogaAutomatico ($paramLogin, $paramSenha){
        $_SESSION['sessaoConectado'] = ValidaLogin($paramLogin, $paramSenha, $nome, $foto, $eh_admin);
        $_SESSION['sessaoAdmin'] = $eh_admin;
        if ( $_SESSION['sessaoConectado'] ) {
            DefineCookie('loginCookie', $login, 60);
            $_SESSION['sessaoLogin'] = $login;
            $_SESSION['sessaoNome'] = $nome;
            $_SESSION['sessaoFoto'] = $foto;
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