<?php 
    include("util.php"); 
    include("_cabecalho.php"); 

    $id_produto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id_produto <= 0) {
        header("Location: produtos.php");
        exit;
    }

    $sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem FROM produto WHERE id_produto = :id_produto AND excluido = FALSE";
    $select = $conn->prepare($sql);
    $select->bindParam(':id_produto', $id_produto, PDO::PARAM_INT);
    $select->execute();
    $linha = $select->fetch(PDO::FETCH_ASSOC);

    if (!$linha) {
        echo '<main class="pdp-container"><p>Produto não encontrado.</p></main>';
        include("_rodape.php");
        exit;
    }

    $nome = $linha['nome'];
    $descricao = $linha['descricao'];
    $valor_unitario = number_format($linha['valor_unitario'], 2, ',', '.');
    $imagem = $linha['imagem'];

    $varSQL =  "SELECT p.id_produto, p.nome, p.descricao, p.valor_unitario, p.imagem, v.qtde_estoque FROM produto p 
            LEFT JOIN vw_estoque v ON p.id_produto = v.id_produto WHERE p.id_produto = :id_produto AND p.excluido = FALSE";
    $selectQtd = $conn->prepare($varSQL);
    $selectQtd->bindParam(':id_produto', $id_produto);
    $selectQtd->execute();
    
    $estoque = $selectQtd->fetch(PDO::FETCH_ASSOC);
    
    $qtd_estoque = $estoque['qtde_estoque'] ?? 0;
    $disponivel = $qtd_estoque > 0;
?> 

<main class="pdp-container"> 
    <div class="pdp-gallery"> 
        <div class="pdp-main-image-box"> 
            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>" class="pdp-main-image" id="pdpMainPreview"> 
        </div> 
    </div> 
    
    <div class="pdp-info"> 
        <h1 class="pdp-title"><?= htmlspecialchars($nome) ?></h1> 
        <p class="pdp-description"><?= nl2br(htmlspecialchars($descricao)) ?></p> 
        <div class="pdp-price-box"> 
            <span class="pdp-price">R$ <?= $valor_unitario ?></span> 
        </div> 
        <b><p class="estoque">Estoque disponível: <?= $qtd_estoque ?></p></b>
        <div class="pdp-actions"> 
            
            <?php if ($disponivel): ?>

            <a href="carrinho.php?operacao=incluir&id_produto=<?= $id_produto ?>" class="pdp-btn pdp-btn-cart" id="pdpAddBtn">
                Adicionar ao carrinho
                <i class="fi fi-rr-shopping-cart"></i>
            </a>

            <?php else: ?>

            <a href="produtos.php" class="pdp-btn pdp-btn-cart" id="pdpAddBtn" style="background-color: #c55151; cursor: not-allowed;" disabled>
                Produto Indisponível
            </a>

            <?php endif; ?>

        </div> 
    </div> 
</main> 
<?php include("_rodape.php"); ?>