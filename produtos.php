
<?php 
    include("util.php");
    include("_cabecalho.php");

    $notasPorAroma = [
        'cerejeira' => ['Floral', 'Suave', 'Calmante'],
        'baunilha'  => ['Doce', 'Cremoso', 'Acolhedor'],
        'manga'     => ['Frutal', 'Floral', 'Doce'],
        'bambu'     => ['Sereno', 'Fresco', 'Amadeirado'],
    ];

    $sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem 
            FROM produto 
            WHERE excluido = FALSE";

    $select = $conn->prepare($sql);
    $select->execute();

    $produtos = $select->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="cat-page">

    <!-- PRODUTOS -->
    <section id="produtosCateg">
        <div class="titulo-secao reveal">
            <span>Velas Aromáticas</span>
            <h2>Catálogo</h2>
            <div class="fioCateg"></div>
        </div>

        <div class="grade">
            <?php $contador = 0; ?>
            <?php foreach ($produtos as $produto): ?>
                <?php 
                    $contador++;

                    // Categoria de cada vela (usada só no selo da foto)
                    if ($produto['id_produto'] == 1 || $produto['id_produto'] == 2) { 
                        $nomeCateg = "Estudo"; 
                    } else { 
                        $nomeCateg = "Ambiente"; 
                    } 

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
                            <span class="selo"><?= htmlspecialchars($nomeCateg) ?></span>
                            <img src="<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
                        </div>
                    </a>
                    <div class="info">
                        <h3><?= htmlspecialchars($produto['nome']) ?></h3>

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
                <p class="vazio">Nenhum produto cadastrado por enquanto.</p>
            <?php endif; ?>
        </div><br>
        <div class="fioCateg"></div>
    </section>
    
</main>

<script src="categoria.js"></script>

<?php include("_rodape.php"); ?>