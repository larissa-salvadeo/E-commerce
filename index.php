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
                    <picture>
                        <img src="Imagens/carrossel/velasCarrossel.webp" alt="Slide 1">
                    </picture>               
                </div>

                <div class="mySlides">
                    <picture>
                        <source media="(max-width: 768px)" srcset="Imagens/carrossel/bambu.webp">
                        <img src="Imagens/carrossel/bambu.jpg" alt="Slide 2">
                    </picture>     
                </div>

                <div class="mySlides">
                   <picture>
                        <source media="(max-width: 768px)" srcset="Imagens/carrossel/flordecerejeira.webp">
                        <img src="Imagens/carrossel/florCerejeira.jpg" alt="Slide 3">
                    </picture>     
                </div>

                <div class="mySlides">
                    <picture>
                        <source media="(max-width: 768px)" srcset="Imagens/carrossel/baunilha.webp">
                        <img src="Imagens/carrossel/baunilha.jpg" alt="Slide 4">
                    </picture>     
                </div>

                <div class="mySlides">
                    <picture>
                        <source media="(max-width: 768px)" srcset="Imagens/carrossel/manga.webp">
                        <img src="Imagens/carrossel/manga.jpg" alt="Slide 5">
                    </picture>     
                </div>
            </div>
            
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <div class="dots-container">
            <span class="dot" onclick="currentSlide(0)"></span> 
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span> 
            
        </div>
        <!------------CATEGORIAS------------>
        <section id="catAmb"> 
            <img src="Imagens/categAmb.png" alt="Categoria Ambiente">
            <div class="texto">ambiente</div>
            <a href="categoria.php?cat=ambiente" class="verMais" >ver mais</a>
        </section>
        <section id="catEst"> 
            <img src="Imagens/categEst.png" alt="Categoria Estudo">
            <div class="texto">estudo</div>
            <a href="categoria.php?cat=estudo" class="verMais">ver mais</a>
        </section>

        <!------------VÍDEO------------>
        <figure>
            <iframe src="https://www.youtube.com/embed/wWH5MnRoKQo?si=NOn_vXTl3T4d_zeT" title="Velas Aromáticas Lumière" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </figure>
    </main>
    <?php include("_rodape.php"); ?>