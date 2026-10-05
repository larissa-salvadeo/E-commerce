<?php 
include("util.php");
include("_cabecalho.php"); ?>    
<!------MAIN------>    
<h1>Em desenvolvimento</h1>
<?php include("_rodape.php"); ?>

<!--CÓDIGO PARA QUANDO O BANCO DE DADOS JÁ ESTIVER COM OS PRODUTOS CADASTRADOS -->
<?php /* 
    include("_cabecalho.php");

    $sql = "SELECT id_produto, nome, descricao, categoria, valor_unitario, imagem 
            FROM produto 
            WHERE excluido = FALSE AND categoria = :categoria";

    $select = $conn->prepare($sql);
    $categoria = 'ambiente';
    $select->bindParam(':categoria', $categoria);
    $select->execute();

    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);*/
?>
<!--
<main class="produtos">
    <div class="wrapperCat">
        </*?php foreach ($produtos as $novo): ?>
            <div class="single-card">
                <a href="paginaProduto.php?id=</*?= $novo['id_produto'] ?>">
                    <div class="img-area">
                        <img src="</*?= $novo['imagem'] ?>" alt="</*?= $novo['nome'] ?>">
                    </div>
                </a>
                <div class="info">
                    <h3></*?=$novo['nome'] ?></h3>
                    <p class="price">R$ </*?= number_format($novo['valor_unitario'], 2, ',', '.') ?></p>
                    <p></*?=$novo['descricao'] ?></p>
                    <a href="carrinho.php?id=</*?= $novo['id_produto'] ?>" class="carrinho">
                        <i class="fi fi-rr-shopping-cart"></i>
                    </a>
                </div>
            </div>
        </*?php endforeach; ?>
    </div>
</main>

</*?php include("_rodape.php"); ?>