<?php 
    include ("util.php");
    include("_cabecalho.php");

    $sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem 
            FROM produto 
            WHERE excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->execute();

    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);

?>
<main class="produtos">          
    <div class="wrapper">
        <?php foreach ($produtos as $produto): ?>
            <?php 
                if ($produto['id_produto'] == 1 || $produto['id_produto'] == 2) { 
                    $categ = "Estudo"; 
                } else { 
                    $categ = "Ambiente"; 
                } 
            ?>
            <div class="single-card">
                <a href="paginaProduto.php?id=<?= $produto['id_produto'] ?>">
                    <div class="img-area">
                        <img src="<?= $produto['imagem']?>" alt="<?= $produto['nome'] ?>">
                        <button class="categ"><?=$categ ?></button>
                    </div>
                </a>
                <div class="info">
                    <h3><?=$produto['nome']?></h3>
                    <p class="price">R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?></p>
                    <p><?= $produto['descricao']?></p>
                    <a href="paginaProduto.php?add=<?= $produto['id_produto'] ?>" class="carrinho">
                         <button type="button" class="btn-detalhes">Ver detalhes</button>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>   
</main>

<?php include("_rodape.php"); ?>