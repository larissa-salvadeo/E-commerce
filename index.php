<?php
include("util.php");
$_SESSION["raiz"] = "/loja2b/";
include("_cabecalho.php");
$_SESSION["sessaoSite"]="https://eq.projetoscti.com.br". $_SESSION["raiz"]; ?>
<!------MAIN------>
    <main class="index">
        <!------------CARROSSEL------------>
        <div class="slideshow-container">
            <div class="slides-track" id="track">
                <div class="mySlides">
                    <img src="Imagens/Slide1.png" alt="Slide 1">
                </div>

                <div class="mySlides">
                    <img src="Imagens/Slide2.png" alt="Slide 2">
                </div>

                <div class="mySlides">
                    <img src="Imagens/Slide3.png" alt="Slide 3">
                </div>
            </div>
            
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <div class="dots-container">
            <span class="dot" onclick="currentSlide(0)"></span> 
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
        </div>
        <!------------CATEGORIAS------------>
        <section id="catAmb"> 
            <img src="Imagens/Ambiente.png" alt="Categoria Ambiente">
            <div class="texto">ambiente</div>
            <a href="catAmb.php" class="verMais" >ver mais</a>
        </section>
        <section id="catEst"> 
            <img src="Imagens/Estudos.png" alt="Categoria Estudo">
            <div class="texto">estudo</div>
            <a href="catEst.php" class="verMais">ver mais</a>
        </section>

        <!------------VÍDEO------------>
        <figure>
            <video autoplay muted playsinline controls width="100%" loop>
                <source src="Imagens/Video.mp4" type="video/mp4">
            </video>
        </figure>
    </main>
    <?php include("_rodape.php"); ?>