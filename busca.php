<?php
include("_cabecalho.php");

$conn = conecta();
$pesquisa = "";
$parametros = [];

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $pesquisa = trim($_GET['search']);
    // Caso use PostgreSQL use ILIKE. Se usar MySQL, altere ILIKE para LIKE.
    $sql = "SELECT * FROM produto WHERE nome ILIKE :termo AND excluido = FALSE";
    $parametros = [':termo' => '%' . $pesquisa . '%'];
} else {
    $sql = "SELECT * FROM produto WHERE excluido = FALSE";
}

// Executa a consulta
$stmt = ExecutaSQL($conn, $sql, $parametros);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="container-produtos">
    <h2>
        <?php if (!empty($pesquisa)): ?>
            Resultados da busca por: "<em><?= htmlspecialchars($pesquisa) ?></em>"
        <?php else: ?>
            Todos os Produtos
        <?php endif; ?>
    </h2>

    <div class="grid-produtos">
        <?php if (count($produtos) > 0): ?>
            <?php foreach ($produtos as $prod): ?>
                <div class="card-produto">
                    <img src="<?= htmlspecialchars($prod['imagem'] ?? 'Imagens/produto-default.png') ?>" alt="<?= htmlspecialchars($prod['nome']) ?>">
                    <h3><?= htmlspecialchars($prod['nome']) ?></h3>
                    <p class="preco">R$ <?= number_format($prod['preco'], 2, ',', '.') ?></p>
                    <a href="paginaProduto.php?id=<?= $prod['id_produto'] ?>" class="btn-detalhes">Ver detalhes</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto foi encontrado com a pesquisa realizada.</p>
        <?php endif; ?>
    </div>
</main>

<?php 
include("_rodape.php"); 
?>