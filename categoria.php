<?php 
    include("util.php");
    include("_cabecalho.php");

    // Textos e imagens de cada categoria
    $categorias = [
        'ambiente' => [
            'nome'  => 'Ambiente',
            'imgBanner'  => 'Imagens/categAmb.jpg',
            'frase' => 'Aromas que transformam o seu espaço em um abrigo.',
        ],
        'estudo' => [
            'nome'  => 'Estudo',
            'imgBanner'  => 'Imagens/categEst.jpg',
            'frase' => 'Aromas que acalmam a mente e despertam o foco.',
        ],
    ];

    $notasPorAroma = [
        'cerejeira' => ['Floral', 'Suave', 'Calmante'],
        'baunilha'  => ['Doce', 'Cremoso', 'Acolhedor'],
        'manga'     => ['Frutal', 'Floral', 'Doce'],
        'bambu'     => ['Verde', 'Fresco', 'Amadeirado'],
    ];

    $slug = $_GET['cat'] ?? 'ambiente';
    if (!isset($categorias[$slug])) {
        $slug = 'ambiente';
    }
    $cat = $categorias[$slug];

    $outraSlug = ($slug === 'ambiente') ? 'estudo' : 'ambiente';
    $outra     = $categorias[$outraSlug];

    $sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem 
            FROM produto 
            WHERE excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->execute();

    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="cat-page">

    <!-- Banner-->
    <div class="banner">
        <div class="bannerBg" id="heroBg">
            <img src="<?= htmlspecialchars($cat['imgBanner'])?>" alt="Imagem de Vela">
        </div>
        <div class="banner-conteudo">
            <div class="migalha">Produtos / <?= htmlspecialchars($cat['nome']) ?></div>
            <h1><?= htmlspecialchars($cat['nome']) ?></h1>
            <p><?= htmlspecialchars($cat['frase']) ?></p>
            <a href="#produtosCateg" class="descer">Conheça as velas</a>
        </div>
    </div>

    <!-- PRODUTOS -->
    <section id="produtosCateg">
        <div class="titulo-secao reveal">
            <span>Velas Aromáticas</span>
            <h2>Velas para <?= htmlspecialchars(strtolower($cat['nome'])) ?></h2>
            <div class="fioCateg"></div>
        </div>
    
        <div class="grade">
            <?php $contador = 0; ?>
            <?php foreach ($produtos as $produto): ?>
                <?php 
                    // Mesma regra que você já usa no produtos.php
                    if ($produto['id_produto'] == 1 || $produto['id_produto'] == 2) { 
                        $categ = "estudo"; 
                    } else { 
                        $categ = "ambiente"; 
                    } 

                    // Pula as velas que não são desta categoria
                    if ($categ !== $slug) { 
                        continue; 
                    }
                    $contador++;

                    // Procura as notas pelo nome da vela
                    $notas = [];
                    foreach ($notasPorAroma as $aroma => $lista) {
                        if (stripos($produto['nome'], $aroma) !== false) {
                            $notas = $lista;
                            break;
                        }
                    }
                ?>
                <article class="card reveal <?= $contador % 2 == 0 ? 'd2' : '' ?>">
                    <a href="paginaProduto.php?id=<?= $produto['id_produto'] ?>">
                        <div class="foto">
                            <span class="selo"><?= htmlspecialchars($cat['nome']) ?></span>
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        </div>
                    </a>
                    <div class="info">
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>
                        <p class="descricao"><?= htmlspecialchars($produto['descricao']) ?></p>

                        <?php if ($notas): ?>
                            <div class="notas">
                                <?php foreach ($notas as $nota): ?>
                                    <span class="nota"><?= htmlspecialchars($nota) ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p class="preco">R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?></p>

                        <a href="paginaProduto.php?id=<?= $produto['id_produto'] ?>" class="btn">Ver detalhes</a>
                    </div>
                    
                </article>
            <?php endforeach; ?>

            <?php if ($contador == 0): ?>
                <p class="vazio">Nenhum produto nesta categoria por enquanto.</p>
            <?php endif; ?>
            
        </div>
        
    </section>
    <div class="fioCateg"></div>

    <!-- OUTRA CATEGORIA -->
    <section id="outraCateg">
        <div class="outra reveal">
            <div class="txt">
                <span class="chamada">Continue explorando</span>
                <h3>Que tal conhecer a linha <?= htmlspecialchars(strtolower($outra['nome'])) ?>?</h3>
                <a href="categoria.php?cat=<?= $outraSlug ?>" id="outraLink">Ver mais</a>
            </div>
        </div>
    </section>

</main>

<script src="categoria.js"></script>

<?php include("_rodape.php"); ?>