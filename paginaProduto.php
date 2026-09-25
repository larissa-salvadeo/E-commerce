<?php 
include("util.php");
include("_cabecalho.php"); ?>          

<!------MAIN------>
<main class="pdp-container">
            <!-- Galeria de Imagens (Esquerda) -->
            <div class="pdp-gallery">
                <div class="pdp-main-image-box">
                    <img src="Imagens/frente.avif" alt="Vela Aromática Cherry Blossom" class="pdp-main-image" id="pdpMainPreview">
                </div>
                
                <div class="pdp-thumbnails-box">
                    <ul class="pdp-thumbnails-list">
                        <li class="pdp-thumb-item pdp-thumb-active">
                            <img src="Imagens/frente.avif" alt="Vela - Frente" class="pdp-thumb-img">
                        </li>
                        <li class="pdp-thumb-item">
                            <img src="Imagens/tras.avif" alt="Vela - Verso" class="pdp-thumb-img">
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Informações do Produto (Direita) -->
            <div class="pdp-info">
                <h1 class="pdp-title">Vela Aromática Cherry Blossom</h1>
                <p class="pdp-description">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur, iure non. Perferendis sed corrupti adipisci possimus qui ex reiciendis odit rem? Molestias ab laborum explicabo impedit quae iure aperiam reiciendis.
                </p>
                
                <div class="pdp-price-box">
                    <span class="pdp-price">R$ 16,90</span>
                </div>

                <div class="pdp-actions">
                    <button type="button" class="pdp-btn pdp-btn-buy" id="pdpBuyBtn">Comprar Agora</button>
                    <button type="button" class="pdp-btn pdp-btn-cart" id="pdpAddBtn">
                       <i class="fi fi-rr-shopping-cart">   </i>
                        Adicionar ao carrinho
                    </button>
                </div>
            </div>
        
    </main>
<?php include("_rodape.php"); ?>

<!--CÓDIGO PARA QUANDO O BANCO DE DADOS JÁ ESTIVER COM OS PRODUTOS CADASTRADOS -->
<!--
</*?php 
    include("_cabecalho.php");

    $id_produto = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    //Validação para caso o id venha negativo
    if ($id_produto <= 0) {
        header("Location: produtos.php");
        exit;
    }

    $sql = "SELECT id_produto, nome, descricao, categoria, valor_unitario, imagem 
            FROM produto 
            WHERE id_produto = :id_produto AND excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->bindParam(':id_produto', $id_produto);
    $select->execute();

    $linha = $select->fetch(PDO::FETCH_ASSOC);

    // Se não encontrar nenhum produto ativo com o ID informado
    if (!$produto) {
        echo "<main class='pdp-container'><p>Produto não encontrado.</p></main>";
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
            <img src="</*?= $imagem ?>" alt="</*?= $nome ?>" class="pdp-main-image" id="pdpMainPreview">
        </div>
        
        <div class="pdp-thumbnails-box">
            <ul class="pdp-thumbnails-list">
                <li class="pdp-thumb-item pdp-thumb-active">
                    <img src="COLOCAR IMAGEM ÚNICA PARA TODAS AS VELAS" alt="Vela - Topo" class="pdp-thumb-img">
                </li>
                <li class="pdp-thumb-item">
                    <img src="COLOCAR IMAGEM ÚNICA PARA TODAS AS VELAS" alt="Vela - Inferior" class="pdp-thumb-img">
                </li>
            </ul>
        </div>
    </div>

    <div class="pdp-info">
        <h1 class="pdp-title"></*?=$nome?></h1>
        <p class="pdp-description"></*?=$descricao?></p>
        <div class="pdp-price-box">
            <span class="pdp-price">R$</*?=$valor_unitario?></span>
        </div>
        <div class="pdp-actions">
            <a href="AINDA SEM PÁGINA?id=</*?=$id_produto?>" class="pdp-btn pdp-btn-buy" id="pdpBuyBtn">Comprar Agora</a>
            <a href="carrinho.php?add=</*?=$id_produto?>" class="pdp-btn pdp-btn-cart" id="pdpAddBtn">
               <i class="fi fi-rr-shopping-cart"></i>
               Adicionar ao carrinho
            </a>
        </div>
    </div>
</main>

<?php include("_rodape.php"); ?>
-->