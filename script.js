/* CARROSSEL */
let slideIndex = 0;
const track = document.getElementById("track");
const slides = document.getElementsByClassName("mySlides");
const dots = document.getElementsByClassName("dot");

function showSlides() {
    if (!track || slides.length === 0) return;

    track.style.transform = `translateX(-${slideIndex * 100}%)`;

    for (let i = 0; i < dots.length; i++) {
        dots[i].classList.remove("active");
    }

    if (dots[slideIndex]) {
        dots[slideIndex].classList.add("active");
    }

    slideIndex++;

    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }

    setTimeout(showSlides, 4000);
}

if (track) {
    showSlides();
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