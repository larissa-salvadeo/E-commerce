<?php include("_cabecalho.php"); ?>          
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