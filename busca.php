<?php
include("util.php");
include("_cabecalho.php");

$conn = conecta();
$pesquisa = "";
$parametros = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $pesquisa = trim($_GET['search']);
    $sql = "SELECT * FROM produto WHERE nome ILIKE :termo AND excluido = FALSE";
    $parametros = [':termo' => '%' . $pesquisa . '%'];
} else {
    $sql = "SELECT * FROM produto WHERE excluido = FALSE";
}

// Executa a consulta
$stmt = ExecutaSQL($conn, $sql, $parametros);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="produtos">
    <div class="wrapper">
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $prod): ?>
                <a href="paginaProduto.php" class="single-card">
                    <div class="img-area">
                        <img src="<?= htmlspecialchars($prod['imagem'] ?? 'Imagens/produto-default.png') ?>" alt="<?= htmlspecialchars($prod['nome']) ?>">
                        <button class="categ">Estudo</button>
                    </div>
                    <div class="info">
                        <h3><?= htmlspecialchars($prod['nome']) ?></h3>
                        <p class="price">R$ <?= number_format($prod['valor_unitario'], 2, ',', '.') ?></p>
                        <button type="button" class="btn-detalhes">Ver detalhes</button>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto foi encontrado com a pesquisa realizada.</p>
        <?php endif; ?>
    </div>


    
</main>

<?php 
include("_rodape.php"); 
?>