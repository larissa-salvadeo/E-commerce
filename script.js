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

/* ABRIR LOGIN PELO CARRINHO */

const abrirLoginCarrinho = document.getElementById('abrirLoginCarrinho');

if (abrirLoginCarrinho && modal) {
    abrirLoginCarrinho.addEventListener('click', (e) => {
        e.preventDefault();

        // Garante que apareça o painel de login, não o de cadastro
        if (container) {
            container.classList.remove('right-panel-active');
        }

        // Abre o modal existente
        modal.style.display = 'flex';
    });
}

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

//Esqueci e Redefinir - Seta de voltar
const params = new URLSearchParams(window.location.search);

if (modal && params.get('login') === '1') {
    modal.style.display = 'flex';
    if (container) container.classList.remove('right-panel-active'); // garante o painel "Entrar"

    // limpa o ?login=1 da URL para não reabrir ao recarregar
    history.replaceState(null, '', window.location.pathname);
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
else if (login === 'erro' || cadastro === 'erro') {
   modal.style.display = 'flex';

    if (login === 'erro') {
        // Mostra o lado do login
        containerLogin.classList.remove('right-panel-active');

        const erroLogin = document.getElementById('erroLogin');

        if (erroLogin) {
            if (msg === 'Senha incorreta') {
                erroLogin.textContent = 'Senha incorreta! Tente novamente.';
            }
            else if (msg === 'Usuario nao encontrado') {
                erroLogin.textContent = 'E-mail não cadastrado!';
            }
            else {
                erroLogin.textContent = 'Ocorreu um erro no login.';
            }

            erroLogin.style.display = 'block';
            erroLogin.style.color = 'white';
        }
    }

    if (cadastro === 'erro') {
        // Mostra o lado do cadastro
        containerLogin.classList.add('right-panel-active');

        const erroCadastro = document.getElementById('erroCadastro');

        if (erroCadastro) {
            if (msg === 'email_ja_cadastrado') {
                erroCadastro.textContent = 'Este e-mail já está cadastrado!';
            }
            else if (msg === 'conta_excluida') {
                erroCadastro.textContent = 'Este e-mail pertence a uma conta excluída.';
            }
            else {
                erroCadastro.textContent = 'Não foi possível realizar o cadastro.';
            }

            erroCadastro.style.display = 'block';
            erroCadastro.style.color = 'white';
        }
    }

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



/* PÁGINA DO USUÁRIO - EDITAR DADOS */
(function () {
    var popup = document.querySelector(".editarPopup");
    if (!popup) return;

    var form = popup.querySelector("form");
    var inputArquivo = document.getElementById("imagemEditar");
    var previa = document.getElementById("previaImagem");
    var srcOriginal = previa ? previa.getAttribute("src") : "";
    var textoLabel = popup.querySelector(".arquivo-texto");
    var labelArquivo = textoLabel ? textoLabel.closest(".arquivo-label") : null;

    function fechar() {
        popup.classList.remove("mostrar");
        form.reset();
        if (previa) previa.src = srcOriginal;
        if (textoLabel) textoLabel.textContent = "Escolher imagem";
        if (labelArquivo) labelArquivo.classList.remove("selecionado");
    }

    window.editarUser = function () {
        if (popup.classList.contains("mostrar")) {
            fechar();
        } else {
            popup.classList.add("mostrar");
        }
    };

    popup.addEventListener("click", function (e) {
        if (e.target === popup) fechar();
    });

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape" && popup.classList.contains("mostrar")) {
            // se a câmera estiver aberta, o Esc fecha só a câmera
            var cam = document.getElementById("cameraBox");
            if (cam && !cam.hidden) return;
            fechar();
        }
    });

    if (inputArquivo && previa) {
        inputArquivo.addEventListener("change", function () {
            if (inputArquivo.files && inputArquivo.files[0]) {
                previa.src = URL.createObjectURL(inputArquivo.files[0]);
            }
        });
    }
})();

/*  ARQUICO DE FOTO*/
/*Input type file - arquivo de foto */
document.querySelectorAll('.campo-arquivo input[type="file"]').forEach(input => {
    input.addEventListener('change', () => {
        const label = input.nextElementSibling;
        const texto = label.querySelector('.arquivo-texto');

        if (input.files.length > 0) {
            texto.textContent = input.files[0].name;
            label.classList.add('selecionado');
        } else {
            texto.textContent = 'Escolher imagem';
            label.classList.remove('selecionado');
        }
    });
});

/*ABRIR CAMERA EM COMPUTADOR*/
/* ABRIR CAMERA EM COMPUTADOR (cadastro e edição) */
(function () {
    const cameraBox    = document.getElementById('cameraBox');
    const cameraVideo  = document.getElementById('cameraVideo');
    const cameraCanvas = document.getElementById('cameraCanvas');
    const btnCapturar  = document.getElementById('btnCapturar');
    const btnCancelar  = document.getElementById('btnCancelarCamera');

    if (!cameraBox || !cameraVideo || !cameraCanvas || !btnCapturar || !btnCancelar) return;

    let cameraStream = null;
    let cameraAberta = false;
    let inputAtual   = null; // input de arquivo que vai receber a foto

    // descobre uma vez se existe câmera
    const temCamera = (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices)
        ? navigator.mediaDevices.enumerateDevices()
            .then(d => d.some(x => x.kind === 'videoinput'))
            .catch(() => false)
        : Promise.resolve(false);

    function fecharCamera() {
        if (cameraStream) {
            cameraStream.getTracks().forEach(t => t.stop());
            cameraStream = null;
        }
        cameraVideo.srcObject = null;
        cameraBox.hidden = true;
        inputAtual = null;
        setTimeout(() => { cameraAberta = false; }, 400);
    }

    document.querySelectorAll('.campo-arquivo').forEach(campo => {
        const fileInput = campo.querySelector('input[type="file"]');
        const btnCamera = campo.querySelector('.btn-camera');
        if (!fileInput || !btnCamera) return;

        temCamera.then(ok => { if (ok) btnCamera.hidden = false; });

        // enquanto a câmera estiver aberta, o seletor de arquivos não abre
        fileInput.addEventListener('click', (e) => {
            if (cameraAberta) e.preventDefault();
        });

        btnCamera.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (cameraAberta) return;

            cameraAberta = true;
            inputAtual = fileInput;
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user' },
                    audio: false
                });
                cameraVideo.srcObject = cameraStream;
                cameraBox.hidden = false;
            } catch (erro) {
                cameraAberta = false;
                inputAtual = null;

                let msg = 'Não foi possível acessar a câmera.';
                if (erro.name === 'NotAllowedError') {
                    msg = 'A permissão da câmera está bloqueada. Clique no ícone à esquerda da URL, permita a câmera e recarregue a página.';
                } else if (erro.name === 'NotFoundError') {
                    msg = 'Nenhuma câmera foi encontrada neste computador.';
                } else if (erro.name === 'NotReadableError') {
                    msg = 'A câmera está sendo usada por outro programa. Feche-o e tente novamente.';
                }
                alert(msg);
                console.error(erro);
            }
        });
    });

    btnCapturar.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        if (!inputAtual) return;

        cameraCanvas.width  = cameraVideo.videoWidth;
        cameraCanvas.height = cameraVideo.videoHeight;
        cameraCanvas.getContext('2d').drawImage(cameraVideo, 0, 0);

        const destino = inputAtual; // guarda antes de fechar a câmera
        cameraCanvas.toBlob(blob => {
            if (!blob) { fecharCamera(); return; }
            const arquivo = new File([blob], 'foto-' + Date.now() + '.jpg', { type: 'image/jpeg' });

            const dt = new DataTransfer();
            dt.items.add(arquivo);
            destino.files = dt.files;

            // atualiza o nome no label e a prévia
            destino.dispatchEvent(new Event('change', { bubbles: true }));

            fecharCamera();
        }, 'image/jpeg', 0.9);
    });

    btnCancelar.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        fecharCamera();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !cameraBox.hidden) fecharCamera();
    });
})();

/*PÁGINA DE CATEGORIA*/

// Parallax do hero
const heroBg = document.getElementById("heroBg");
addEventListener("scroll", () => {
  heroBg.style.transform = `translateY(${scrollY * 0.25}px)`;
}, { passive:true });

// Scroll reveal
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add("revelado");
      obs.unobserve(e.target);
    }
  });
}, { threshold:.15 });

document.querySelectorAll(".reveal").forEach(el => obs.observe(el));


/*POP-UP RESERVA*/
document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popupPedidoReservado');

    // Executa somente nas páginas que possuem o pop-up.
    if (!popup) {
        return;
    }

    const botaoFechar = popup.querySelector('.popup-reserva-fechar');
    const botaoEntendi = popup.querySelector('.popup-reserva-botao');

    const parametros = new URLSearchParams(window.location.search);

    // Abre somente depois de uma reserva confirmada pelo PHP.
    if (parametros.get('reservado') === '1') {
        popup.style.display = 'flex';
    }

    // Fecha pelo X.
    if (botaoFechar) {
        botaoFechar.addEventListener('click', function () {
            popup.style.display = 'none';
        });
    }

    // Fecha pelo botão Entendi.
    if (botaoEntendi) {
        botaoEntendi.addEventListener('click', function () {
            popup.style.display = 'none';
        });
    }

});



document.addEventListener('DOMContentLoaded', () => {
    const containerLogin = document.getElementById('container-login');
    const abaEntrar = document.getElementById('abaEntrar');
    const abaCadastrar = document.getElementById('abaCadastrar');

    // Clique na aba Cadastrar
    if (abaCadastrar) {
        abaCadastrar.addEventListener('click', () => {
            containerLogin.classList.add('right-panel-active');
            abaCadastrar.classList.add('ativa');
            abaEntrar.classList.remove('ativa');
        });
    }

    // Clique na aba Entrar
    if (abaEntrar) {
        abaEntrar.addEventListener('click', () => {
            containerLogin.classList.remove('right-panel-active');
            abaEntrar.classList.add('ativa');
            abaCadastrar.classList.remove('ativa');
        });
    }
});


/*Telefone*/
const telefone = document.getElementById("telefone"); 
telefone.addEventListener("input", function () {
    let valor = telefone.value.replace(/\D/g, "");
    valor = valor.replace(/(\d{2})(\d)/, "($1) $2");
    valor = valor.replace(/(\d{5})(\d)/, "$1-$2");

    telefone.value = valor;
});

/*Validação de tamanho*/
document.getElementById('imagem').addEventListener('change', function() {
  const arquivo = this.files[0];
  const mensagemErro = document.getElementById('erroTamanho');
  const btnEnviar = document.getElementById('btnEnviar');

  // 1. Define o limite de tamanho em Megabytes (mude o valor abaixo se precisar)
  const LIMITE_MB = 0.5; 
  const LIMITE_BYTES = LIMITE_MB * 1024 * 1024;

  // Reseta os estados de erro e botão
  mensagemErro.style.display = 'none';
  btnEnviar.disabled = false;

  if (arquivo) {
    // 2. Verifica se o tamanho do arquivo passou do limite
    if (arquivo.size > LIMITE_BYTES) {
      mensagemErro.textContent = `A imagem é muito pesada! O tamanho máximo é de ${LIMITE_MB}MB.`;
      mensagemErro.style.display = 'block';
      
      this.value = ''; // Limpa o campo para o usuário não conseguir enviar
      btnEnviar.disabled = true; // Bloqueia o botão de envio por segurança
    }
  }
});