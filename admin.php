<?php 
include("util.php");
include("_cabecalho.php"); 
SaiseHacker();
?>    

<main class="main-gerenciamento">

    <div class="gerenciamento-container">

        <div class="gerenciamento-titulo">
            <h1>Gerenciamento</h1>
            <p>Gerencie os usuários, produtos e entradas do sistema.</p>
        </div>

        <div class="cards-gerenciamento">

            <a href="usuarios/usuarios.php" class="card-gerenciamento">
                <div class="icone-gerenciamento">
                    <i class="fi fi-rr-users"></i>
                </div>

                <div class="conteudo-card">
                    <h2>Usuários</h2>
                    <p>Gerencie as contas cadastradas no sistema.</p>
                </div>

                <span class="seta-card">
                    <i class="fi fi-rr-arrow-right"></i>
                </span>
            </a>

            <a href="produtos/produtosCrud.php" class="card-gerenciamento">
                <div class="icone-gerenciamento">
                    <i class="fi fi-rr-box"></i>
                </div>

                <div class="conteudo-card">
                    <h2>Produtos</h2>
                    <p>Cadastre, altere e gerencie os produtos.</p>
                </div>

                <span class="seta-card">
                    <i class="fi fi-rr-arrow-right"></i>
                </span>
            </a>

            <a href="entradas/entradas.php" class="card-gerenciamento">
                <div class="icone-gerenciamento">
                    <i class="fi fi-rr-shopping-cart"></i>
                </div>

                <div class="conteudo-card">
                    <h2>Entradas</h2>
                    <p>Controle as entradas e movimentações do estoque.</p>
                </div>

                <span class="seta-card">
                    <i class="fi fi-rr-arrow-right"></i>
                </span>
            </a>

        </div>

    </div>

</main>

<?php include("_rodape.php"); ?>