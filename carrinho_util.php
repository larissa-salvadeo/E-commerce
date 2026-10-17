
<?php

function carrinhoCria($paramConn, &$paramIdCompra, &$paramStatusCompra)
{
    $paramIdCompra = 0;
    $paramStatusCompra = '';

    $session_id = session_id();

    $login = $_SESSION['sessionLogin-Lumiere'] ?? '';

    $conectado = !empty($_SESSION['sessionConectado-Lumiere']) && !empty($login);

    $id_usuario = null;

    // Busca o usuário conectado pelo e-mail.
    if ($conectado) {
        $sqlUsuario = "SELECT id_usuario FROM usuario
                        WHERE email = :email AND excluido = FALSE
                        LIMIT 1";

        $stmtUsuario = $paramConn->prepare($sqlUsuario);
        $stmtUsuario->execute([':email' => $login]);

        $resultadoUsuario = $stmtUsuario->fetchColumn();

        if ($resultadoUsuario !== false) {
            $id_usuario = $resultadoUsuario;
        }
    }

    $sql = "SELECT id_compra, status FROM compra
        WHERE sessao = :sessao AND status = 'carrinho'
        ORDER BY id_compra DESC
        LIMIT 1";

    $stmt = $paramConn->prepare($sql);
    $stmt->execute([':sessao' => $session_id]);

    $compra = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$compra && $id_usuario !== null) {
        $sql = "SELECT id_compra, status FROM compra
                WHERE fk_usuario = :id_usuario
                AND status = 'carrinho'
                ORDER BY id_compra DESC
                LIMIT 1";

        $stmt = $paramConn->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);

        $compra = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($compra) {
            $sql = "UPDATE compra SET sessao = :sessao
                    WHERE id_compra = :id_compra AND status = 'carrinho'";

            $stmt = $paramConn->prepare($sql);
            $stmt->execute([
                ':sessao' => $session_id,
                ':id_compra' => $compra['id_compra']
            ]);
        }
    }

    if ($compra) {
        $paramIdCompra = $compra['id_compra'];
        $paramStatusCompra = $compra['status'];

    } else {
        $sql = "INSERT INTO compra (data, status, sessao, fk_usuario)
            VALUES (CURRENT_TIMESTAMP, 'carrinho', :sessao, :id_usuario)
            RETURNING id_compra";

        $stmt = $paramConn->prepare($sql);

        $stmt->execute([
            ':sessao' => $session_id,
            ':id_usuario' => $id_usuario
        ]);

        $paramIdCompra = $stmt->fetchColumn();
        $paramStatusCompra = 'carrinho';
    }

    if ($id_usuario !== null && $paramIdCompra > 0) {
        $sql = "UPDATE compra SET fk_usuario = :id_usuario
            WHERE id_compra = :id_compra AND status = 'carrinho' AND fk_usuario IS NULL";

        $stmt = $paramConn->prepare($sql);
        $stmt->execute([
            ':id_usuario' => $id_usuario,
            ':id_compra' => $paramIdCompra
        ]);
    }
}

function AtualizaGride($paramConn, $paramIdCompra, $paramStatusCompra)
{
    $paramIdCompra = $paramIdCompra;
    $paramStatusCompra = ($paramStatusCompra ?? '');

    if ($paramIdCompra <= 0) {
        echo '<div class="carrinho-vazio">';
        echo '<h3>Não foi possível localizar o pedido.</h3>';
        echo '</div>';
        return 0;
    }

    
    $sql = "SELECT
                p.id_produto,
                p.nome,
                p.descricao,
                p.imagem,
                cp.quantidade,
                cp.valor_unitario,
                cp.quantidade * cp.valor_unitario AS subtotal
            FROM compra_produto cp
            INNER JOIN produto p
                ON p.id_produto = cp.fk_produto
            WHERE cp.fk_compra = :id_compra
            ORDER BY p.nome";

    $stmt = $paramConn->prepare($sql);
    $stmt->execute([':id_compra' => $paramIdCompra]);

    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);


    
    $sqlTotal = "SELECT valor_total_compra
                FROM vw_valor_total_compra
                WHERE id_compra = :id_compra";

    $stmtTotal = $paramConn->prepare($sqlTotal);
    $stmtTotal->execute([':id_compra' => $paramIdCompra]);

    $resultadoTotal = $stmtTotal->fetchColumn();
    $totalCompra = ($resultadoTotal === false) ? 0 : (float) $resultadoTotal;


    $quantidadeTotal = 0;

    $podeAlterar = ($paramStatusCompra === 'carrinho');

    $conectado = !empty($_SESSION['sessionConectado-Lumiere']) && !empty($_SESSION['sessionLogin-Lumiere']);

    echo '<div class="carrinho-layout">';

    echo '<section class="carrinho-lista">';

    echo '<div class="carrinho-lista-cabecalho">';
    echo '<h2>Produtos do carrinho</h2>';
    echo '<span>' . count($produtos) . ' item(ns)</span>';
    echo '</div>';

    if (empty($produtos)) {
        echo '<div class="carrinho-vazio">';

        echo '<div class="carrinho-vazio-icone">';
        echo '<i class="fi fi-rr-shopping-cart"></i>';
        echo '</div>';

        echo '<h3>Seu carrinho está vazio</h3>';

        echo '<p>Encontre suas velas favoritas</p>';

        echo '<a href="produtos.php" class="botao-continuar">';
        echo 'Explorar produtos';
        echo '</a>';

        echo '</div>';
    }

    foreach ($produtos as $linha) {
        $id_produto = $linha['id_produto'];

        $nome = htmlspecialchars($linha['nome'], ENT_QUOTES, 'UTF-8');

        $descricao = htmlspecialchars(($linha['descricao'] ?? ''), ENT_QUOTES, 'UTF-8');

        $quantidade = (int) $linha['quantidade'];
        $valorUnitario = (float) $linha['valor_unitario'];
        $subtotal = (float) $linha['subtotal'];
        $imagem = $linha['imagem'] ?? '';

        $quantidadeTotal += $quantidade;

        echo '<article class="carrinho-produto">';

        // Imagem.
        echo '<div class="carrinho-produto-imagem">';

        if (!empty($imagem)) {
            echo '<img src=" '.htmlspecialchars($imagem, ENT_QUOTES, 'UTF-8') .' " alt="'.$nome.'">';
        } else {
            echo '<div class="carrinho-sem-imagem">';
            echo '<i class="fi fi-rr-picture"></i>';
            echo '</div>';
        }

        echo '</div>';

        // Informações do produto.
        echo '<div class="carrinho-produto-info">';

        echo '<h3>' . $nome . '</h3>';

        if ($descricao !== '') {
            echo '<p class="carrinho-produto-descricao">';
            echo $descricao;
            echo '</p>';
        }

        echo '<p class="carrinho-produto-unitario">';
        echo 'R$ ' . number_format($valorUnitario, 2, ',', '.') . ' por unidade';
        echo '</p>';

        if ($podeAlterar) {
            echo '<div class="carrinho-produto-acoes">';

            echo '<div class="carrinho-quantidade">';

            echo '<a href="carrinho.php?operacao=diminuir&id_produto=' .
                $id_produto .
                '" aria-label="Diminuir quantidade">−</a>';

            echo '<span>' . $quantidade . '</span>';

            echo '<a href="carrinho.php?operacao=incluir&id_produto=' .
                $id_produto .
                '" aria-label="Aumentar quantidade">+</a>';

            echo '</div>';

            echo '<a class="carrinho-remover" href="carrinho.php?operacao=excluir&id_produto='.$id_produto.'"">';

            echo '<i class="fi fi-rr-trash"></i> Excluir';
            echo '</a>';

            echo '</div>';

        } else {
            echo '<p class="carrinho-quantidade-reservada">';
            echo 'Quantidade: ' . $quantidade;
            echo '</p>';
        }

        echo '</div>';

        // Subtotal.
        echo '<div class="carrinho-produto-subtotal">';
        echo '<span>Subtotal</span>';
        echo '<strong>R$ ' .
            number_format($subtotal, 2, ',', '.') .
            '</strong>';
        echo '</div>';

        echo '</article>';
    }

    echo '</section>';

    /*RESUMO DO PEDIDO*/
    echo '<aside class="carrinho-resumo">';

    echo '<h2>Resumo do pedido</h2>';

    echo '<div class="carrinho-resumo-linha">';
    echo '<span>Quantidade de produtos</span>';
    echo '<span>' . $quantidadeTotal . '</span>';
    echo '</div>';

    echo '<div class="carrinho-resumo-linha">';
    echo '<span>Subtotal</span>';
    echo '<span>R$ ' . number_format($totalCompra, 2, ',', '.') . '</span>';
    echo '</div>';

    echo '<div class="carrinho-resumo-total">';
    echo '<span>Total</span>';
    echo '<strong>R$ ' . number_format($totalCompra, 2, ',', '.') . '</strong>';
    echo '</div>';

    if ($podeAlterar && $totalCompra > 0) {
        if ($conectado) {
            echo '<a class="carrinho-finalizar" ';
            echo 'href="carrinho.php?operacao=fechar">';
            echo 'Fechar e reservar';
            echo '</a>';
        } else {
        echo '<a class="carrinho-finalizar" href="#" id="abrirLoginCarrinho">';
        echo 'Fechar e reservar';
        echo '</a>';
}

        echo '<a class="carrinho-cancelar" ';
        echo 'href="carrinho.php?operacao=cancelar" >';
        echo 'Esvaziar carrinho';
        echo '</a>';
    }

    if ($paramStatusCompra === 'reservado') {
        echo '<p class="carrinho-status">';
        echo 'Pedido reservado com sucesso.';
        echo '</p>';
        

    } elseif ($paramStatusCompra === 'cancelado') {
        echo '<p class="carrinho-status">';
        echo 'Este pedido foi cancelado.';
        echo '</p>';
    }

    echo '<a class="carrinho-continuar" href="produtos.php">';
    echo '← Continuar comprando';
    echo '</a>';

    echo '</aside>';

    echo '</div>';

    $_SESSION['sessaoQtItens'] = $quantidadeTotal;
    $_SESSION['sessaoTotal'] = $totalCompra;

    return $totalCompra;
}
?>