let slideIndex = 0;

const track = document.getElementById("track");
const slides = document.getElementsByClassName("mySlides");
const dots = document.getElementsByClassName("dot");

function showSlides() {
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

showSlides();


const body = document.querySelector("body");
const navHeader = document.querySelector(".navheader");
const menuBtn = document.querySelector(".menu-btn");
const cancelBtn = document.querySelector(".cancel-btn");

// Abrir Menu Mobile
menuBtn.onclick = () => {
    navHeader.classList.add("show");
    menuBtn.classList.add("hide");
    body.classList.add("disabled");
};

// Fechar Menu Mobile
cancelBtn.onclick = () => {
    body.classList.remove("disabled");
    navHeader.classList.remove("show");
    menuBtn.classList.remove("hide");
};