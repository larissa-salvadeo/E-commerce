<?php
include("util.php");
$_SESSION["raiz"] = "/loja2b/";
include("_cabecalho.php");
$_SESSION["sessaoSite"]="https://eq.projetoscti.com.br". $_SESSION["raiz"]; ?>
<!------MAIN------>
    <main>
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
            <a href="catAmb.php"><img src="Imagens/Ambiente.png" alt="Categoria Ambiente"></a>
            <div class="texto">ambiente</div>
            <button class="verMais">ver mais</button>
        </section>
        <section id="catEst"> 
            <a href="catEst.php"><img src="Imagens/Estudos.png" alt="Categoria Estudo"></a>
            <div class="texto">estudo</div>
            <button class="verMais">ver mais</button>
        </section>

        <!------------VÍDEO------------>
        <figure>
            <video autoplay muted playsinline controls width="100%" loop>
                <source src="Imagens/Video.mp4" type="video/mp4">
            </video>
        </figure>
    </main>
    <?php include("_rodape.php"); ?>