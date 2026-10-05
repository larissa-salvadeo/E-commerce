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
?> 

<main class="pdp-container"> 
    <div class="pdp-gallery"> 
        <div class="pdp-main-image-box"> 
            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($nome) ?>" class="pdp-main-image" id="pdpMainPreview"> 
        </div> 
        <div class="pdp-thumbnails-box"> 
            <ul class="pdp-thumbnails-list"> 
                <li class="pdp-thumb-item pdp-thumb-active"> 
                    <img src="<?= htmlspecialchars($imagem) ?>" alt="Vela - Vista Principal" class="pdp-thumb-img"> 
                </li> 
                <li class="pdp-thumb-item"> 
                    <img src="<?= htmlspecialchars($imagem) ?>" alt="Vela - Vista Secundária" class="pdp-thumb-img"> 
                </li> 
            </ul> 
        </div> 
    </div> 
    
    <div class="pdp-info"> 
        <h1 class="pdp-title"><?= htmlspecialchars($nome) ?></h1> 
        <p class="pdp-description"><?= nl2br(htmlspecialchars($descricao)) ?></p> 
        <div class="pdp-price-box"> 
            <span class="pdp-price">R$ <?= $valor_unitario ?></span> 
        </div> 
        <div class="pdp-actions"> 
            <a href="carrinho.php?add=<?= $id_produto ?>" class="pdp-btn pdp-btn-cart" id="pdpAddBtn"> 
                <i class="fi fi-rr-shopping-cart"></i> Adicionar ao carrinho 
            </a> 
        </div> 
    </div> 
</main> 

<?php include("_rodape.php"); ?>
