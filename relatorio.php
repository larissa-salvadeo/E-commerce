<?php 
require_once "vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

include ("util.php");
?>

<center><h1>Monitor de vendas</h1></center>  
<form action='' method='post'>
    Data inicial<br>
    <input type='date' name='datai' value='<?= date('Y-m-d') ?>'><br><br>
    Data final<br>
    <input type='date' name='dataf' value='<?= date('Y-m-d') ?>'><br><br>
    <input type='checkbox' name="cancelados" value="checked" checked>
    <label for="cancelados">Omitir cancelados</label><br><br>
    <input type='submit' value='Gerar PDF'><br>  
</form>

<?php
if ($_POST) {

    ob_start();

    $conn = conecta();

    $datai = $_POST['datai'];
    $dataf = $_POST['dataf'];
    $cancelados = $_POST['cancelados'] ?? '';

    $sql = "SELECT id_compra, status, data, usuario.nome 
            FROM compra 
            LEFT JOIN usuario ON compra.fk_usuario = usuario.id_usuario
            WHERE data BETWEEN :datai AND :dataf " . 
            ($cancelados == "checked" ? " AND status != 'cancelado' " : "") . 
            " ORDER BY data DESC";

    $select = $conn->prepare($sql);
    $select->bindParam(':datai', $datai);
    $select->bindParam(':dataf', $dataf);
    $select->execute();

    $datai_f = date('d/m/Y', strtotime($datai));
    $dataf_f = date('d/m/Y', strtotime($dataf));
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        h3 { margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #588a5bff; padding: 5px; text-align: left; }
        th { background-color: #588a5bff; }
        .text-right { text-align: right; }
        .header-compra { background-color: #8cad91; font-weight: bold; }
    </style>
</head>
<body>
    <h3>Período de <?= $datai_f ?> a <?= $dataf_f ?></h3>
    <table>
        <thead>
            <tr>
                <th style="width: 40px;">Id</th>
                <th style="width: 80px;">Status</th>
                <th style="width: 60px;">Data</th>
                <th>Usuário / Produto</th>
                <th class="text-right" style="width: 40px;">Qtd</th>
                <th class="text-right" style="width: 70px;">Unit</th>
                <th class="text-right" style="width: 70px;">Subtotal</th>                      
                <th class="text-right" style="width: 70px;">Total</th>                      
            </tr>
        </thead>
        <tbody>
        <?php
        while ($linha = $select->fetch()) {
            $id_compra = $linha['id_compra'];
            $status    = $linha['status'];
            $data      = date('d/m/Y', strtotime($linha['data']));
            $nome      = $linha['nome'];
        ?>
            <tr class="header-compra">
                <td class="text-right"><?= $id_compra ?></td>
                <td><?= htmlspecialchars($status) ?></td>
                <td><?= $data ?></td>
                <td colspan="5"><?= htmlspecialchars($nome ?? 'N/A') ?></td>
            </tr>

            <?php
            $sqlItens = "SELECT compra_produto.fk_produto, produto.nome, compra_produto.quantidade, 
                                compra_produto.valor_unitario, 
                                (compra_produto.valor_unitario * compra_produto.quantidade) AS sub
                         FROM compra_produto 
                         INNER JOIN produto ON compra_produto.fk_produto = produto.id_produto
                         WHERE compra_produto.fk_compra = :id_compra 
                         ORDER BY produto.nome";

            $selectItens = $conn->prepare($sqlItens);
            $selectItens->bindParam(':id_compra', $id_compra);
            $selectItens->execute();
            
            $tot = 0;

            while ($linhaItens = $selectItens->fetch()) {
                $nome_prod      = $linhaItens['nome'];  
                $quantidade     = $linhaItens['quantidade'];  
                $valor_unitario = number_format($linhaItens['valor_unitario'], 2, ',', '.');  
                $sub_valor      = $linhaItens['sub'];
                $sub            = number_format($sub_valor, 2, ',', '.'); 
                $tot           += $sub_valor;
            ?>
                <tr>
                    <td colspan="3"></td>
                    <td><b><?= htmlspecialchars($nome_prod) ?></b></td>
                    <td class="text-right"><?= $quantidade ?></td>                    
                    <td class="text-right"><?= $valor_unitario ?></td>
                    <td class="text-right"><?= $sub ?></td>
                    <td></td>
                </tr>
            <?php } ?>
            
            <tr>
                <td colspan="7" class="text-right"><b>Total:</b></td>
                <td class="text-right"><b>R$ <?= number_format($tot, 2, ',', '.') ?></b></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php
    $html = ob_get_clean();

    $options = new Options();
    $options->set('isRemoteEnabled', true);
    
    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    if (ob_get_length()) ob_end_clean();
    $dompdf->stream("relatorio_vendas.pdf", ["Attachment" => true]);
    exit;
}
?>