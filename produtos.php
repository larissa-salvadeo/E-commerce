<?php 
include("util.php");
include("_cabecalho.php"); ?>     

    <!------MAIN------>
    <main class="produtos">          
        <div class="wrapper">
            <a href="paginaProduto.php" class="single-card">
                <div class="img-area">
                    <img src="Imagens/exemplo.jpeg" alt="Vela Aromática Cherry Blossom">
                </div>
                <div class="info">
                    <h3>Vela Aromática Cherry Blossom 70ml</h3>
                    <p class="price">R$ 16,90</p>
                    <p>Cheiro Maravilhoso</p>
                    <div class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </div>
                </div>
            </a>
            <a href="paginaProduto.php" class="single-card">
                <div class="img-area">
                    <img src="Imagens/exemplo.jpeg" alt="Vela Aromática Cherry Blossom">
                </div>
                <div class="info">
                    <h3>Vela Aromática Cherry Blossom 70ml</h3>
                    <p class="price">R$ 16,90</p>
                    <p>Cheiro Maravilhoso</p>
                    <div class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </div>
                </div>
            </a>
            <a href="paginaProduto.php" class="single-card">
                <div class="img-area">
                    <img src="Imagens/exemplo.jpeg" alt="Vela Aromática Cherry Blossom">
                </div>
                <div class="info">
                    <h3>Vela Aromática Cherry Blossom 70ml</h3>
                    <p class="price">R$ 16,90</p>
                    <p>Cheiro Maravilhoso</p>
                    <div class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </div>
                </div>
            </a>
            <a href="paginaProduto.php" class="single-card">
                <div class="img-area">
                    <img src="Imagens/exemplo.jpeg" alt="Vela Aromática Cherry Blossom">
                </div>
                <div class="info">
                    <h3>Vela Aromática Cherry Blossom 70ml</h3>
                    <p class="price">R$ 16,90</p>
                    <p>Cheiro Maravilhoso</p>
                    <div class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </div>
                </div>
            </a>
        </div>
    </main>

<?php include("_rodape.php"); ?>

<!--CÓDIGO PARA QUANDO O BANCO DE DADOS JÁ ESTIVER COM OS PRODUTOS CADASTRADOS -->
</*?php 
    include("_cabecalho.php");

    $sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem 
            FROM produto 
            WHERE excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->execute();

    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);
?>
<!--
<main class="produtos">          
    <div class="wrapper">
        </*?php foreach ($produtos as $produto): ?>
            <div class="single-card">
                <a href="paginaProduto.php?id=</*?= $produto['id_produto'] ?>">
                    <div class="img-area">
                        <img src="</*?= $produto['imagem']?>" alt="</*?= $produto['nome'] ?>">
                    </div>
                </a>
                <div class="info">
                    <h3></*?=$produto['nome']?></h3>
                    <p class="price">R$ </*?= number_format($produto['valor_unitario'], 2, ',', '.') ?></p>
                    <p></*?= $produto['descricao']?></p>
                    <a href="carrinho.php?add=</*?= $produto['id_produto'] ?>" class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </*?php endforeach; ?>
    </div>   
</main>
 -->
</*?php include("_rodape.php"); ?>