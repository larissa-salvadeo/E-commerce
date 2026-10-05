<?php

 function carrinhoCria($paramConn, &$paramIdCompra, &$paramStatusCompra) 
 {
   // existe alguma registro compra associada ao session_id ??
   // ou seja é a primeira vez que abre o carrinho ?
   $session_id = session_id();
   $existe = intval ( ValorSQL($paramConn," select count(*) from compra 
                                            where sessao = '$session_id' ") );

   if ( $existe > 0 ) {   

      // retorna id de compra
      $paramIdCompra = intval ( ValorSQL($paramConn," select id_compra from compra
                                                  where sessao = '$session_id' and
                                                  status='carrinho' "));
      // obtem o status dessa compra, se criou agora, entao eh "Pendente"
      $paramStatusCompra = ValorSQL($paramConn, " select status from compra 
                                             where id_compra = $paramIdCompra ");   
                                          
   } else {
      
      $paramStatusCompra = 'carrinho';

      if ( isset( $_SESSION ['sessaoLogin'] ) and 
         ( $_SESSION ['sessaoLogin'] != "" ) ) {
           $login = $_SESSION ['sessaoLogin'];
           $id_usuario = ValorSQL($paramConn, " select id_usuario from usuario 
                                                where email = '$login' " );
           $paramIdCompra = intval ( ValorSQL($paramConn," select id_compra from compra
                                                  where fk_usuario = $id_usuario and
                                                  status='carrinho' "));
     
      } else {
         // SE NAO EXISTE, CRIA REGISTRO DE COMPRA
         $dataHoje = date('Y/m/d');
         // cria um registro de compras sem usuario
         ExecutaSQL($paramConn," insert into compra (data, status, sessao) 
                                 values ('$dataHoje', '$paramStatusCompra', '$session_id') ");
         // recupera o id de compra  
         $paramIdCompra = $paramConn->lastInsertId();
      }       
   } 

   //// se estiver logado/conectado atualiza o  /////
   //// campo fk_usuario na compra com id_usuario ///
   if ( isset( $_SESSION ['sessaoLogin'] ) and 
      ( $_SESSION ['sessaoLogin'] != "" ) ) {
         $login = $_SESSION ['sessaoLogin'];
         $id_usuario = ValorSQL($paramConn, " select id_usuario from usuario 
                                              where email = '$login' " );
         ExecutaSQL($paramConn, "update compra 
                                  set fk_usuario = $id_usuario 
                                where 
                                 fk_usuario is null and 
                                 id_compra = $id_compra"); 
   }
  
 }
 
 function AtualizaGride( $paramConn, $paramIdCompra, $paramStatusCompra ) 
 {
      // faz a selecao pra montar a tabela
      $sql = " select produto.id_produto, 
                     produto.descricao as descprod, 
                     compra_produto.quantidade, 
                     compra_produto.valor_unitario, 
                     compra_produto.valor_unitario * compra_produto.quantidade as sub, 
                     produto.imagem   
               from produto 
                     inner join compra_produto on 
                     produto.id_produto = compra_produto.fk_produto 
               where compra_produto.fk_compra = $paramIdCompra  
               order by produto.descricao ";
      ?>

      <center><h1>Compras</h1></center>
      <table id='tabela'>
            <tr>
                  <th>Item</th>
                  <th></th>
                  <th>Produto</th>
                  <th>Qtd</th>
                  <th>$ unit</th>
                  <th>$ sub</th>
                  <th></th><th></th>
            </tr>
      <?php
                  
      $select = $paramConn->query($sql);
         
      // cria table com itens no carrinho e seus subtotais
      $item = 0;

      while ( $linha = $select->fetch() ) {
            $item++;
            $id_produto    = $linha['id_produto']; 
            $descProd      = $linha['descprod'];
            $quant         = $linha['quantidade'];
            $vunit         = $linha['valor_unitario'];
            $sub           = $linha['sub'];
            $arq_foto      = $linha['imagem'];

            // caminho da foto e criacao do html p mesclar na td
             // cria html com foto ou sem foto

            $htmlFoto = ( ImagemJaExiste( $arq_foto ) ? 
                        "<img src='$arq_foto' width=30>" : 
                        "<img src='/imagens/semimg.jpg' width=30>" );
            ?>

            <tr>
                  <td align='right'><?= $item ?></td>
                  <td><?= $htmlFoto ?></td>
                  <td><?= $descProd ?></td>
                  <td align='right'><?= $quant ?></td>
                  <td align='right'>R$ <?= number_format($vunit,2) ?></td>
                  <td align='right'>R$ <?= number_format($sub,2) ?></td>
                  <td><a href='/carrinho.php?operacao=incluir&id_produto=<?= $id_produto ?>'>
                  Incluir</a></td>
                  <td><a href='/carrinho.php?operacao=excluir&id_produto=<?= $id_produto ?>'>
                  Excluir</a></td>
            </tr>
            
            <?php   
      }
      
      $_SESSION['sessaoQtItens'] = $item;
      
      echo "</table>";
      
      // calcula o total e mostra junto com o status da compra     
      $total = ValorSQL($paramConn," select sum(valor_unitario * quantidade)  
                                     from compra_produto 
                                     where fk_compra = $paramIdCompra ");
                                    
      $total += 0; // atribuir zero caso $total = '' (carrinho vazio)                           
      echo "Status da compra: <b>$paramStatusCompra</b><br>
            Total: <b>R$ ".number_format($total,2)."</b>
            <br><br>";         

      // fecha compra apenas se logado, carrinho com pelo menos 1 item
      if ( ( $total > 0 ) and ( isset( $_SESSION ['sessaoLogin'] ) ) and  
           ( $paramStatusCompra == 'carrinho' ) ) {

            $_SESSION['sessaoTotal'] = $total;
            echo "<a href='carrinho.php?operacao=cancelar&id_produto=0'>
                  Esvaziar e cancelar</a><br><br>";                  
            echo "<a href='carrinho.php?operacao=fechar&id_produto=0'>
                  Fechar e RESERVAR !</a>";                  
      } else {
            if ( $total > 0 ) { // se tiver algum item no carrinho
               echo "Para fechar o carrinho e reservar seu produto, clique no login";
            }            
      }  
      return $total;
 }

?>