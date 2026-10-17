<?php
include("util.php");
include("_cabecalho.php");

$conn = conecta();

$notasPorAroma = [
    'cerejeira' => ['Floral', 'Suave', 'Calmante'],
    'baunilha'  => ['Doce', 'Cremoso', 'Acolhedor'],
    'manga'     => ['Frutal', 'Floral', 'Doce'],
    'bambu'     => ['Verde', 'Fresco', 'Amadeirado'],
];

$pesquisa   = trim($_GET['search'] ?? '');
$parametros = [];

$sql = "SELECT id_produto, nome, descricao, valor_unitario, imagem
        FROM produto
        WHERE excluido = FALSE";

if ($pesquisa !== '') {
    $sql .= " AND nome ILIKE :termo";
    $parametros[':termo'] = '%' . $pesquisa . '%';
}

$sql .= " ORDER BY nome";

$stmt     = ExecutaSQL($conn, $sql, $parametros);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total    = count($produtos);
?>

<main class="cat-page">

    <section id="produtosCateg">
        <div class="titulo-secao reveal">
            <span>Velas Aromáticas</span>
            <?php if ($pesquisa !== ''): ?>
                <h2>Resultados para "<?= htmlspecialchars($pesquisa) ?>"</h2>
            <?php else: ?>
                <h2>Catálogo</h2>
            <?php endif; ?>
            <div class="fioCateg"></div>
        </div>

        <div class="grade">
            <?php $contador = 0; ?>
            <?php foreach ($produtos as $produto): ?>
                <?php
                    $contador++;

                    $nomeCateg = in_array($produto['id_produto'], [1, 2]) ? 'Estudo' : 'Ambiente';

                    $notas = [];
                    foreach ($notasPorAroma as $aroma => $lista) {
                        if (stripos($produto['nome'], $aroma) !== false) {
                            $notas = $lista;
                            break;
                        }
                    }

                    $imagem = $produto['imagem'] ?: 'Imagens/produto-default.png';
                ?>
                <article class="card reveal <?= $contador % 2 == 0 ? 'd2' : '' ?>">
                    <a href="paginaProduto.php?id=<?= $produto['id_produto'] ?>">
                        <div class="foto">
                            <span class="selo"><?= htmlspecialchars($nomeCateg) ?></span>
                            <img src="<?= htmlspecialchars($imagem) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
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
        </div>
            <?php if ($contador == 0): ?>
                <p class="vazio">
                    <?= $pesquisa !== ''
                        ? 'Nenhum produto foi encontrado com a pesquisa realizada.'
                        : 'Nenhum produto cadastrado por enquanto.' ?>
                </p>
            <?php endif; ?>
        <br>
        <div class="fioCateg"></div>
    </section>

</main>

<script src="categoria.js"></script>

<?php include("_rodape.php"); ?>