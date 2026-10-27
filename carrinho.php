
<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include("util.php");
include("carrinho_util.php");
include("_cabecalho.php");

$conn = conecta();

$conectado = !empty($_SESSION['sessionConectado-Lumiere']) && !empty($_SESSION['sessionLogin-Lumiere']);

$login = $_SESSION['sessionLogin-Lumiere'] ?? '';

$id_usuario = null;

if ($conectado) {
    $id_usuario = $_SESSION['sessionId-Lumiere'] ?? null;

    if (empty($id_usuario)) {
        $sql = "SELECT id_usuario FROM usuario
            WHERE email = :email AND excluido = FALSE
            LIMIT 1
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $login]);

        $resultado = $stmt->fetchColumn();

        if ($resultado !== false) {
            $id_usuario = $resultado;
        }
    }
}

$operacao = $_GET['operacao'] ?? '';

$id_produto = filter_input(INPUT_GET, 'id_produto', FILTER_VALIDATE_INT);

$mensagem = '';
$erro = '';

$id_compra = 0;
$statusCompra = '';

$pedidoVisualizacao = filter_input(INPUT_GET, 'pedido', FILTER_VALIDATE_INT);

$visualizandoPedidoFinalizado = isset($_GET['reservado']) || isset($_GET['cancelado']);

if ($visualizandoPedidoFinalizado && $pedidoVisualizacao && $pedidoVisualizacao > 0) {
    $sql = "SELECT id_compra, status FROM compra
        WHERE id_compra = :id_compra AND (sessao = :sessao OR fk_usuario = :id_usuario)
        LIMIT 1
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':id_compra' => $pedidoVisualizacao,
        ':sessao' => session_id(),
        ':id_usuario' => $id_usuario
    ]);

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pedido && in_array($pedido['status'], ['reservado', 'cancelado'], true)) {
        $id_compra = (int) $pedido['id_compra'];
        $statusCompra = $pedido['status'];
    } else {
        $visualizandoPedidoFinalizado = false;
    }
}

if (!$visualizandoPedidoFinalizado) {
    carrinhoCria($conn, $id_compra, $statusCompra);
}

$id_compra = (int) $id_compra;

if ($operacao === 'incluir') {

    if ($statusCompra !== 'carrinho') {
        $erro = 'Este pedido não está aberto para alterações.';

    } elseif (!$id_produto || $id_produto <= 0) {
        $erro = 'Produto inválido.';

    } else {

        // 1. Busca o produto e seu preço
        $sql = "SELECT id_produto, valor_unitario
                FROM produto
                WHERE id_produto = :id_produto
                AND excluido = FALSE";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_produto' => $id_produto]);

        $produto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            $erro = 'Produto não encontrado ou indisponível.';

        } else {
            $sql = "SELECT qtde_estoque
                    FROM vw_estoque
                    WHERE id_produto = :id_produto";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_produto' => $id_produto]);

            $resultadoEstoque = $stmt->fetchColumn();
            $qtdEstoque = ($resultadoEstoque === false) ? 0 : $resultadoEstoque;

            $sql = "SELECT quantidade
                    FROM compra_produto
                    WHERE fk_compra = :id_compra
                    AND fk_produto = :id_produto";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_compra' => $id_compra, ':id_produto' => $id_produto]);

            $quantidadeAtual = $stmt->fetchColumn();

            $qtdCarrinho = ($quantidadeAtual === false) ? 0 : $quantidadeAtual;

            if ($qtdCarrinho >= $qtdEstoque) {
                $erro = 'Estoque insuficiente';

            } else {
                if ($quantidadeAtual !== false) {

                    $sql = "UPDATE compra_produto
                            SET quantidade = quantidade + 1
                            WHERE fk_compra = :id_compra
                            AND fk_produto = :id_produto";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute([':id_compra' => $id_compra, ':id_produto' => $id_produto]);
                } else {

                    $sql = "INSERT INTO compra_produto (quantidade, valor_unitario, fk_produto, fk_compra)
                            VALUES (1, :valor, :id_produto, :id_compra)";

                    $stmt = $conn->prepare($sql);
                    $stmt->execute([
                        ':valor' => $produto['valor_unitario'],
                        ':id_produto' => $id_produto,
                        ':id_compra' => $id_compra
                    ]);
                }
                header("Location: carrinho.php?adicionado=1");
                exit;
            }
        }
    }
}



if ($operacao === 'diminuir') {

    if ($statusCompra !== 'carrinho') {
        $erro = 'Este pedido não está aberto para alterações.';

    } elseif (!$id_produto || $id_produto <= 0) {
        $erro = 'Produto inválido.';

    } else {
        $sql = "SELECT quantidade FROM compra_produto
            WHERE fk_compra = :id_compra AND fk_produto = :id_produto
        ";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id_compra' => $id_compra,
            ':id_produto' => $id_produto
        ]);

        $quantidade = $stmt->fetchColumn();

        if ($quantidade !== false) {
            if ((int) $quantidade > 1) {
                $sql = "UPDATE compra_produto SET quantidade = quantidade - 1
                    WHERE fk_compra = :id_compra AND fk_produto = :id_produto";
            } else {
                $sql = "DELETE FROM compra_produto WHERE fk_compra = :id_compra AND fk_produto = :id_produto";
            }

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':id_compra' => $id_compra,
                ':id_produto' => $id_produto
            ]);
        }

        header("Location: carrinho.php");
        exit;
    }
}


if ($operacao === 'excluir') {

    if ($statusCompra !== 'carrinho') {
        $erro = 'Este pedido não está aberto para alterações.';

    } elseif (!$id_produto || $id_produto <= 0) {
        $erro = 'Produto inválido.';

    } else {
        $sql = "DELETE FROM compra_produto WHERE fk_compra = :id_compra AND fk_produto = :id_produto";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id_compra' => $id_compra,
            ':id_produto' => $id_produto
        ]);

        header("Location: carrinho.php?excluido=1");
        exit;
    }
}


if ($operacao === 'cancelar') {

    if ($statusCompra !== 'carrinho') {
        $erro = 'Este pedido não está aberto para cancelamento.';

    } else {
        try {
            $conn->beginTransaction();

            $sql = "
                DELETE FROM compra_produto
                WHERE fk_compra = :id_compra
            ";

            $stmt = $conn->prepare($sql);
            $stmt->execute([':id_compra' => $id_compra]);

            $sql = "
                UPDATE compra
                SET status = 'cancelado'
                WHERE id_compra = :id_compra
                  AND sessao = :sessao
                  AND status = 'carrinho'
            ";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':id_compra' => $id_compra,
                ':sessao' => session_id()
            ]);

            if ($stmt->rowCount() !== 1) {
                throw new RuntimeException(
                    'O pedido não pôde ser cancelado.'
                );
            }

            $conn->commit();

            header(
                "Location: carrinho.php?cancelado=1&pedido=" .
                $id_compra
            );
            exit;

        } catch (Throwable $e) {
            if ($conn->inTransaction()) {
                $conn->rollBack();
            }

            $erro = 'Não foi possível cancelar o carrinho.';
        }
    }
}


if ($operacao === 'fechar') {

    if (!$conectado || empty($id_usuario)) {
        header("Location: login.php");
        exit;
    }

    if ($statusCompra !== 'carrinho') {
        $erro = 'Este pedido não está aberto para reserva.';

    } else {
        $sql = "
            SELECT COUNT(*)
            FROM compra_produto
            WHERE fk_compra = :id_compra
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':id_compra' => $id_compra]);

        $quantidadeProdutos = (int) $stmt->fetchColumn();

        if ($quantidadeProdutos <= 0) {
            $erro = 'Adicione pelo menos um produto antes de reservar.';

        } else {
            $sql = "
                UPDATE compra
                SET status = 'reservado',
                    fk_usuario = :id_usuario
                WHERE id_compra = :id_compra
                  AND sessao = :sessao
                  AND status = 'carrinho'
            ";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':id_usuario' => (int) $id_usuario,
                ':id_compra' => $id_compra,
                ':sessao' => session_id()
            ]);

            if ($stmt->rowCount() === 1) {
                header(
                    "Location: carrinho.php?reservado=1&pedido=" .
                    $id_compra
                );
                exit;

            } else {
                $erro = 'Não foi possível reservar o pedido. Atualize a página e tente novamente.';
            }
        }
    }
}


if (isset($_GET['reservado']) && $statusCompra === 'reservado'
) {
    $mensagem = 'Pedido reservado com sucesso!';
}
?>

<main class="pagina-carrinho">

    <section class="conteudo-carrinho">

        <h1>Meu carrinho</h1>
        
        <?php if ($erro !== ''): ?>
            <div class="mensagem-erro">
                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>

        <?php
        AtualizaGride(
            $conn,
            $id_compra,
            $statusCompra
        );
        ?>

    </section>


    <!-- POP-UP: PEDIDO RESERVADO -->
    <div id="popupPedidoReservado" class="popup-reserva-overlay">
        <div class="popup-reserva-card">

            <button type="button" class="popup-reserva-fechar" aria-label="Fechar pop-up">&times;</button>

            <div class="popup-reserva-sucesso">
                <span>&#10003;</span>
            </div>

            <h2>Pedido Reservado!</h2>

            <p class="popup-reserva-descricao">
                Sua reserva foi realizada com sucesso.
            </p>

            <div class="popup-reserva-detalhes">

                <div class="popup-reserva-item">
                    <div class="popup-reserva-icone">&#128205;</div>
                    <div>
                        <h3>Local de Pagamento e Retirada</h3>
                        <p>SALA 6 - Localizada no último bloco</p>
                        <a href="https://www.ubieventos.com.br/viewMap/32o-semana-do-colegio-2026/?local=33" target="_blank" style="color: #007bff; text-decoration: underline;">Ver localização</a>
                    </div>
                </div>

                <div class="popup-reserva-item">
                    <div class="popup-reserva-icone">&#128197;</div>
                    <div>
                        <h3>Retirada do pedido</h3>
                        <p>Até o dia 23/10/2026. Horário: 7:00 ao 12:15</p>
                    </div>
                </div>

                <div class="popup-reserva-item">
                    <div class="popup-reserva-icone">⚠️</div>
                    <div>
                        <h3>ATENÇÃO</h3>
                        <p>O produto estará sujeito a esgotamento caso seja retirado muito tempo após a reserva</p>
                    </div>
                </div>
            </div>

            <button type="button" class="popup-reserva-botao">Entendi</button>

            <p class="popup-reserva-rodape">
                Obrigado por escolher a Lumière!
            </p>

        </div>
    </div>
        
</main>

<?php include("_rodape.php"); ?>