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

/* MENSAGENS DE LOGIN E CADASTRO */

const mensagemLogin = document.getElementById("mensagemLogin");

const parametros = new URLSearchParams(window.location.search);

const cadastro = parametros.get("cadastro");
const login = parametros.get("login");
const msg = parametros.get("msg");

if (modal && mensagemLogin) {

    // CADASTRO REALIZADO
    if (cadastro === "sucesso") {

        modal.style.display = "flex";

        mensagemLogin.textContent = "Cadastro realizado com sucesso!";
        mensagemLogin.className = "mensagem sucesso";

    }

    // ERRO NO CADASTRO
    else if (cadastro === "erro") {

        modal.style.display = "flex";

        mensagemLogin.textContent = msg || "Erro ao realizar o cadastro!";
        mensagemLogin.className = "mensagem erro";

    }

    // LOGIN REALIZADO
    else if (login === "sucesso") {

        modal.style.display = "flex";

        mensagemLogin.textContent = "Login realizado com sucesso!";
        mensagemLogin.className = "mensagem sucesso";

    }

    // ERRO NO LOGIN
    else if (login === "erro") {

        modal.style.display = "flex";

        mensagemLogin.textContent = msg || "Erro ao realizar o login!";
        mensagemLogin.className = "mensagem erro";

    }
}