<?php
 include "util.php";
 include "_cabecalho.php";
 include "carrinho_util.php";

 $conn = conecta();  

 carrinhoCria($conn, $id_compra, $statusCompra);

 if ( $_GET ) { 
    $operacao = $_GET['operacao'];
    $id_produto = $_GET['id_produto'];
 
    $quantidade = intval (ValorSQL($conn, "SELECT quantidade FROM compra_produto WHERE fk_produto = $id_produto and fk_compra = $id_compra"));  

    if ($operacao == 'incluir') {
       if ($quantidade == 0) {
           $valor_unitario = intval ( ValorSQL($conn," select valor_unitario 
                  from produto where id_produto = $id_produto " ) );          

           ExecutaSQL($conn,
                    " insert into compra_produto 
                      (fk_produto,fk_compra,quantidade,valor_unitario) 
                      values ($id_produto, $id_compra, 1, $valor_unitario) "); 
       } else {
         ExecutaSQL($conn,
                     " update compra_produto 
                         set quantidade = quantidade + 1 
                       where 
                         fk_produto = $id_produto and 
                         fk_compra  = $id_compra ");                      
       }
       $total = AtualizaGride( $conn, $id_compra, $statusCompra );

    } else 
    if ($operacao == 'excluir') {
       if ($quantidade <= 1) { 
          ExecutaSQL($conn," delete from 
                                 compra_produto 
                             where 
                                 fk_produto = $id_produto and 
                                 fk_compra  = $id_compra ");         
       } else {
          ExecutaSQL($conn," update compra_produto 
                                 set quantidade = quantidade - 1 
                             where 
                                 fk_produto = $id_produto and 
                                 fk_compra  = $id_compra ");       
       }
       $total = AtualizaGride( $conn, $id_compra, $statusCompra );

    } else 

    ////////////////////////////////////////////////////////////
    // se o carrinho foi chamado DELE PRÓPRIO
    // opcoes do get : 'FECHAR', 'CANCELAR'
    ////////////////////////////////////////////////////////////

    if ( $operacao == 'fechar' ) {
       
       $total = AtualizaGride( $conn, $id_compra, $statusCompra );
       
       ExecutaSQL($conn," update compra
                             set status = 'reservado'
                          where                               
                             id_compra  = $id_compra ");  

       ?>
         <br><b>Id Compra: <?= $id_compra ?>
         <br>Total: R$ <?= number_format($total,2) ?></b>
         <br>
         Sua compra está reservada !!!!!
         <br>
         <a href='/logout.php'>Clique para encerrar !</a>
       <?php
    } else 
    if ( $operacao == 'cancelar' ) {
       ExecutaSQL($conn," update compra
                             set status = 'cancelado'
                          where                               
                             id_compra  = $id_compra ");  
      ?>
         <br><br>
         Sua compra foi CANCELADA !
         <a href='/logout.php'>Clique para encerrar !</a>         
      <?php
    }

    $operacao = ""; // apaga a variavel operacao pra nao repetir 
   
 } else {
   // se chamou o link carrinho pela home
   $total = AtualizaGride( $conn, $id_compra, $statusCompra );
 }
 
 include "_rodape.php)";
?>