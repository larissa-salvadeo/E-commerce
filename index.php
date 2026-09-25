
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
        </div>

        <div class="dots-container">
            <span class="dot"></span> 
            <span class="dot"></span> 
            <span class="dot"></span> 
        </div>

        <!------------CATEGORIAS------------>
        <section id="catAmb"> 
            <a href="catAmb.php"><img src="Imagens/Ambiente.png" alt="Categoria Ambiente"></a>
        </section>
        <section id="catEst"> 
            <a href="catEst.php"><img src="Imagens/Estudos.png" alt="Categoria Estudo"></a>
        </section>

        <!------------VÍDEO------------>
        <figure>
            <video autoplay muted playsinline controls width="100%" loop>
                <source src="Imagens/Video.mp4" type="video/mp4">
            </video>
        </figure>
    </main>
    <?php include("_rodape.php"); ?>