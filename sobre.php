<?php
    include("util.php");
    $_SESSION["raiz"] = "/loja2b/";
    include("_cabecalho.php");
    $_SESSION["sessaoSite"]="https://eq.projetoscti.com.br". $_SESSION["raiz"]; 
?>
    <!------MAIN------>
    <main class="sobre">
        <!------------Sobre a Lumière?------------>
        <div class="img-sobre">
            <h1 class="titulo-img">Sobre a Lumière</h1>
            <img src="Imagens/Sobre.jpg" alt="Imagem - Missão, Visão e Valores" >
        </div>
        <div class="quem" id="linkQuem">
            <div id="texto-quem">
                <h2>Nossa História</h2>
                <div class="fioHis"></div>
                <p>A Lumière nasceu no Colégio CTI com o propósito de transformar a rotina de estudos e descanso em momentos de mais equilíbrio, foco e bem-estar através da aromaterapia. Produzidas artesanalmente com cera vegetal e essências marcantes, nossas velas contam com quatro fragrâncias exclusivas, desenvolvidas especialmente para estimular a concentração durante o aprendizado ou proporcionar o relaxamento necessário para desacelerar. Criado para a Semana do Colégio CTI, nosso projeto une o empreendedorismo jovem e o carinho do feito à mão, convidando você a iluminar o seu espaço e renovar as suas energias!</p>
            </div>
            <div id="img-quem">
                <img src="Imagens/equipe.png" alt="Desenvolvedores">
            </div>
        </div>
        <!------------NOSSA MISSÃO, VISÃO E VALORES------------>
        
        <div class="mvv" id="linkMvv">
            <div id="missao">
                <h1>Missão</h1>
                <div class="fioMvv"></div>
                <p>Proporcionar momentos de conforto, tranquilidade e concentração por meio de velas aromáticas que transformam ambientes de estudo e convivência em espaços mais agradáveis e acolhedores.</p><br>
            </div>
            <div id="visao">
                <h1>Visão</h1>
                <div class="fioMvv"></div>
                <p>Oferecer velas aromáticas criativas e de qualidade, capazes de proporcionar ambientes aconchegantes e contribuir para a concentração e o bem-estar das pessoas.</p><br>
            </div>
            <div id="valores">
                <h1>Valores</h1>
                <div class="fioV"></div>
                <ul>
                    <li><b>Bem-estar:</b> buscamos tornar os momentos do dia mais leves e agradáveis.</li>
                    <li><b>Criatividade:</b> valorizamos combinações de aromas e ideias que tornam cada ambiente especial.</li>
                    <li><b>Qualidade:</b> prezamos pela qualidade dos nossos produtos e pela satisfação dos clientes.</li>
                    <li><b>Responsabilidade:</b> buscamos escolhas mais conscientes na produção e nos materiais utilizados.</li>
                    <li><b>Aconchego:</b> acreditamos que pequenos detalhes podem transformar um espaço.</li>
                    <li><b>Foco e tranquilidade:</b> incentivamos ambientes que favoreçam concentração, relaxamento e produtividade.</li>
                    <li><b>Cuidado: </b>colocamos atenção em cada etapa, desde a criação até a experiência do cliente.</li>
                </ul>
            </div>
        </div>
        <!------------CONHEÇA OS DESENVOLVEDORES------------>
        
        <div class="desenvolvedores" id="linkDev"> 

            <h1 id="titulo-devs">Conheça os Desenvolvedores</h1> 
            <div class="fioDev"></div>
            <div class="lista-devs">
                <section id="dev1">  
                    <img src="Imagens/dev1.png" alt="Desenvolvedor 1"> 
                    <h3>Ana Júlia Pereira da Silva Leal</h3> 
                </section> 

                <section id="dev2">  
                    <img src="Imagens/dev2.png" alt="Desenvolvedor 2"> 
                    <h3>Julia Gonçalves de Souza Campos</h3> 
                </section> 

                <section id="dev3"> 
                    <img src="Imagens/dev3.png" alt="Desenvolvedor 3"> 
                    <h3>Larissa Salvadeo Santana</h3> 
                </section> 

                <section id="dev4">  
                    <img src="Imagens/dev4.png" alt="Desenvolvedor 4"> 
                    <h3>Pietra Borgo Bernardi</h3> 
                </section>     

                <section id="dev5">  
                    <img src="Imagens/dev5.png" alt="Desenvolvedor 5"> 
                    <h3>Thales Navarro Neves</h3> 
                </section>
            </div>
        </div>
    </main>
    
    <?php include("_rodape.php");?>