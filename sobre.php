<?php
    include("util.php");
    $_SESSION["raiz"] = "/loja2b/";
    include("_cabecalho.php");
    $_SESSION["sessaoSite"]="https://eq.projetoscti.com.br". $_SESSION["raiz"]; 
?>
    <!------MAIN------>
    <main class="sobre">
        <!------------QUEM SOMOS?------------>
        <div class="quem">
            <img src="Imagens/Sobre2.png" alt="Imagem - Quem somos" class="quem-somos">
            <section id="texto-quem">
                <h1 id="titulo-quem"><b>Quem somos?</b></h1><br>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis inventore incidunt magni itaque accusamus excepturi possimus. Porro, veniam. Suscipit illo natus dolor assumenda recusandae tenetur delectus aut totam cumque ipsa. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto molestias, voluptas delectus ipsum dolorem quos temporibus consequatur magni explicabo itaque a eaque amet tempora dignissimos, asperiores nam. Ex, optio impedit!LoremLor  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis saepe corrupti cumque natus magnam? Beatae officiis, quasi sapiente iure porro maxime, voluptas provident corporis voluptatum ea error earum inventore.</p>                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis inventore incidunt magni itaque accusamus excepturi possimus. Porro, veniam. Suscipit illo natus dolor assumenda recusandae tenetur delectus aut totam cumque ipsa. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Iusto molestias, voluptas delectus ipsum dolorem quos temporibus consequatur magni explicabo itaque a eaque amet tempora dignissimos, asperiores nam. Ex, optio impedit!LoremLor  Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptas veritatis saepe corrupti cumque natus magnam? Beatae officiis, quasi sapiente iure porro maxime, voluptas provident corporis voluptatum ea error earum inventore.</p>
            </section>
            <section id="img-quem">
                <img src="Imagens/devs.png" alt="Desenvolvedores">
            </section>
        </div><br><br>
        <!------------NOSSA MISSÃO, VISÃO E VALORES------------>
        <img src="Imagens/Sobre2.png" alt="Imagem - Missão, Visão e Valores" class="img-mvv">
        <div class="mvv">
            <h1 id="titulo-mvv"><b>Nossa missão, visão e valores</b></h1><br>
            <section id="missao">
                <h1><b>Missão</b></h1><br>
                <p>Proporcionar momentos de conforto, tranquilidade e concentração por meio de velas aromáticas que transformam ambientes de estudo e convivência em espaços mais agradáveis e acolhedores.</p><br>
            </section>
            <section id="visao">
                <h1><b>Visão</b></h1><br>
                <p>Oferecer velas aromáticas criativas e de qualidade, capazes de proporcionar ambientes aconchegantes e contribuir para a concentração e o bem-estar das pessoas.</p><br>
            </section>
            <section id="valores">
                <h1><b>Valores</b></h1><br>
                <ul>
                    <li>Bem-estar: buscamos tornar os momentos do dia mais leves e agradáveis.</li>
                    <li>Criatividade: valorizamos combinações de aromas e ideias que tornam cada ambiente especial.</li>
                    <li>Qualidade: prezamos pela qualidade dos nossos produtos e pela satisfação dos clientes.</li>
                    <li>Responsabilidade: buscamos escolhas mais conscientes na produção e nos materiais utilizados.</li>
                    <li>Aconchego: acreditamos que pequenos detalhes podem transformar um espaço.</li>
                    <li>Foco e tranquilidade: incentivamos ambientes que favoreçam concentração, relaxamento e produtividade.</li>
                    <li>Cuidado: colocamos atenção em cada etapa, desde a criação até a experiência do cliente.</li>
                </ul><br>
            </section>
        </div>
        <!------------CONHEÇA OS DESENVOLVEDORES------------>
        <div class="desenvolvedores"> 

    <h1 id="titulo-devs"><b>Conheça os Desenvolvedores</b></h1> 

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