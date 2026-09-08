<?php 
  /*  //// PARA ENVIO DE EMAILS PHPMAILER //////
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
        if ( isset( $paramFiles[$paramCampo] ) ) {
                $novoId   = $paramConn->lastInsertId();
                $ext = pathinfo($paramFiles[$paramCampo]['name'], PATHINFO_EXTENSION);
                $arquivoNovo = "Imagens/$novoId.$ext";
                try {
                    if (move_uploaded_file($paramFiles[$paramCampo]['tmp_name'], $arquivoNovo)) {
                        echo "<br>Arquivo $arquivoNovo criado com sucesso.\n";
                    } 
                } 
                catch (PDOException $e) {
                    echo "Erro, verifique o arquivo se a pasta imagens existe";
                }     
            }
    }

    function salvaUploadId($paramConn, $paramFiles, $paramCampo, $paramId)
    {
        if (isset($paramFiles[$paramCampo]) && $paramFiles[$paramCampo]['error'] == 0) {

            $ext = pathinfo($paramFiles[$paramCampo]['name'], PATHINFO_EXTENSION);

            $arquivoNovo = "../Imagens/" . $paramId . "." . $ext;

            try {

                if (move_uploaded_file($paramFiles[$paramCampo]['tmp_name'], $arquivoNovo)) {
                    return true;
                } else {
                    return false;
                }

            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }

?>