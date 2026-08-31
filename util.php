<?php 

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
            $arquivoNovo = "imagens/$novoId.$ext";
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
    // ISSET verifica se a variável existe
    if ( isset( $paramFiles[$paramCampo] ) ) {
        $novoId = $paramId;
        $ext = pathinfo($paramFiles[$paramCampo]['name'], PATHINFO_EXTENSION);
        $arquivoNovo = "imagens/$novoId.$ext";
        
        try {
            if (move_uploaded_file($paramFiles[$paramCampo]['tmp_name'], $arquivoNovo)) {
                echo "<br>Arquivo $arquivoNovo atualizado com sucesso.\n";
            } 
        } catch (Exception $e) { 
            echo "Erro, verifique se a pasta imagens existe e tem permissão de escrita.";
        }     
    }
}

?>