/*ROLAGEM DO HEADER*/
(function () {
    var header = document.querySelector("header");
    if (!header) return;
 
    function atualizarHeader() {
        header.classList.toggle("rolou", window.scrollY > 20);
    }
 
    window.addEventListener("scroll", atualizarHeader, { passive: true });
    atualizarHeader(); // caso a página já abra rolada
})();
 



/* CARROSSEL */

let slideIndex = 0;
let timer; 
const track = document.getElementById("track");
const slides = document.getElementsByClassName("mySlides");
const dots = document.getElementsByClassName("dot");

if (track) {
    showSlides();
}

function plusSlides(n) {
    clearTimeout(timer);
    slideIndex += n;
    showSlides();
}

function currentSlide(n) {
    clearTimeout(timer);
    slideIndex = n;
    showSlides();
}

function showSlides() {
    if (!track || slides.length === 0) return;

    if (slideIndex >= slides.length) { slideIndex = 0; }
    if (slideIndex < 0) { slideIndex = slides.length - 1; }

    track.style.transform = `translateX(-${slideIndex * 100}%)`;

    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }
    if (dots[slideIndex]) {
        dots[slideIndex].classList.add("active");
    }

    timer = setTimeout(function() {
        plusSlides(1);
    }, 4000);
}


/* MENU MOBILE */
const body = document.querySelector("body");
const navHeader = document.querySelector(".navheader");
const menuBtn = document.querySelector(".menu-btn");
const cancelBtn = document.querySelector(".cancel-btn");

if (menuBtn && cancelBtn) {
    menuBtn.onclick = () => {
        navHeader.classList.add("show");
        menuBtn.classList.add("hide");
        body.classList.add("disabled");
    };

    cancelBtn.onclick = () => {
        body.classList.remove("disabled");
        navHeader.classList.remove("show");
        menuBtn.classList.remove("hide");
    };
}


/* LOGIN E MODAL */
const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container-login');

if (signUpButton && signInButton && container) {
    signUpButton.addEventListener('click', () => container.classList.add("right-panel-active"));
    signInButton.addEventListener('click', () => container.classList.remove("right-panel-active"));
}

const modal = document.getElementById('modalLogin');
const openBtn = document.getElementById('openModalBtn');
const closeBtn = document.getElementById('closeModalBtn');

if (modal && openBtn && closeBtn) {
    openBtn.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'flex';
    });

    closeBtn.addEventListener('click', () => modal.style.display = 'none');

    window.addEventListener('click', (event) => {
        if (event.target === modal) modal.style.display = 'none';
    });
}

// MENSAGEM DE SUCESSO

const mensagemLogin = document.getElementById('mensagemLogin');
const containerLogin = document.getElementById('container-login');

const urlParams = new URLSearchParams(window.location.search);

const login = urlParams.get('login');
const cadastro = urlParams.get('cadastro');
const nome = urlParams.get('nome');
const msg = urlParams.get('msg');


if (login === 'sucesso' || cadastro === 'sucesso') {

    containerLogin.style.display = 'none';
    mensagemLogin.style.display = 'flex';

    if (login === 'sucesso') {

        mensagemLogin.innerHTML = `
            <h2>Bem-vindo(a), ${nome}!</h2>
        `;

    } 
    else {
        mensagemLogin.innerHTML = `
            <h2>Bem-vindo(a), ${nome}!</h2>
            <p>Sua conta foi criada com sucesso.</p>
        `;
    }

    // Abre o pop-up
    modal.style.display = 'flex';

    // Fecha automaticamente depois de 3 segundos
    setTimeout(() => {

        modal.style.display = 'none';
        containerLogin.style.display = 'flex';
        mensagemLogin.style.display = 'none';

    }, 3000);


    // Limpa os parâmetros da URL
    window.history.replaceState(
        {},
        document.title,
        window.location.pathname
    );
}

/* POP-UP DO USUÁRIO */

const abrirUsuario = document.getElementById('abrirUsuario');
const modalUsuario = document.getElementById('modalUsuario');
const fecharUsuario = document.getElementById('fecharUsuario');

if (abrirUsuario && modalUsuario && fecharUsuario) {

    // Abrir o pop-up
    abrirUsuario.addEventListener('click', (e) => {

        e.preventDefault();

        modalUsuario.style.display = 'flex';

    });

    // Fechar pelo X
    fecharUsuario.addEventListener('click', () => {

        modalUsuario.style.display = 'none';

    });

    // Fechar clicando fora do pop-up
    window.addEventListener('click', (event) => {

        if (event.target === modalUsuario) {

            modalUsuario.style.display = 'none';

        }

    });

}



//PÁGINA DE PRODUTO
document.addEventListener('DOMContentLoaded', () => {
    const mainImage = document.getElementById('pdpMainPreview');
    const thumbItems = document.querySelectorAll('.pdp-thumb-item');

    thumbItems.forEach(item => {
        item.addEventListener('click', () => {
            // Remove a classe ativa de todas as miniaturas
            thumbItems.forEach(thumb => thumb.classList.remove('pdp-thumb-active'));
            
            // Adiciona a classe ativa no item clicado
            item.classList.add('pdp-thumb-active');
            
            // Pega a imagem de dentro da miniatura clicada e atualiza a foto principal
            const newSrc = item.querySelector('.pdp-thumb-img').getAttribute('src');
            if (mainImage && newSrc) {
                mainImage.setAttribute('src', newSrc);
            }
        });
    });
});


/*Página do Usuário*/
// Tudo fica dentro de uma função para não conflitar com variáveis do script.js
// (duas variáveis com o mesmo nome em arquivos diferentes causam erro)
(function () {
    var popup = document.querySelector(".editarPopup");
    var form = popup ? popup.querySelector("form") : null;
    var inputArquivo = document.getElementById("arquivo-upload");
    var previa = document.getElementById("previaImagem");
    var srcOriginal = previa ? previa.getAttribute("src") : "";

    // Fecha o popup e descarta o que não foi salvo
    function fechar() {
        popup.classList.remove("mostrar");
        form.reset();
        previa.src = srcOriginal;
    }

    // Chamada pelo onclick do botão "Editar" e pela setinha de voltar
    window.editarUser = function () {
        if (popup.classList.contains("mostrar")) {
            fechar();
        } else {
            popup.classList.add("mostrar");
        }
    };

    if (!popup) return;

    // Fecha ao clicar fora do bloco
    popup.addEventListener("click", function (e) {
        if (e.target === popup) {
            fechar();
        }
    });

    // Fecha com Esc
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && popup.classList.contains("mostrar")) {
            fechar();
        }
    });

    // Prévia da foto escolhida
    if (inputArquivo && previa) {
        inputArquivo.addEventListener("change", function () {
            if (inputArquivo.files && inputArquivo.files[0]) {
                previa.src = URL.createObjectURL(inputArquivo.files[0]);
            }
        });
    }
})();