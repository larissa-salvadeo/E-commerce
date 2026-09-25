<?php

include("util.php");
include("_cabecalho.php");

?>

<main id="main-recuperacao">

    <div class="recuperacao-container">

        <form
            class="recuperacao-form"
            action=""
            method="POST"
        >

            <h1>Esqueci minha senha</h1>

            <p>
                Digite o e-mail cadastrado na sua conta
                para receber o link de recuperação.
            </p>

            <input
                type="email"
                name="email"
                placeholder="E-mail"
                required
            >

            <input
                type="submit"
                value="Enviar link"
            >


            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $conn = conecta();

                $email = $_POST['email'];

                $sql = "
                    SELECT nome, email
                    FROM usuario
                    WHERE email = :email
                    AND excluido = FALSE
                ";

                $select = $conn->prepare($sql);

                $select->bindParam(
                    ':email',
                    $email
                );

                $select->execute();

                $linha = $select->fetch(
                    PDO::FETCH_ASSOC
                );


                if (!$linha) {

                    echo "
                        <div class='mensagem-recuperacao'>
                            <b>E-mail não cadastrado.</b>
                        </div>
                    ";

                } else {

                    $token = bin2hex(
                        random_bytes(32)
                    );

                    $_SESSION['sessaoToken'] = $token;

                    $_SESSION['sessaoEmailRecuperacao'] =
                        $email;


                    $link =
                        $_SESSION['sessaoSite'] .
                        "/redefinir.php?token=" .
                        urlencode($token);


                    $html = "
                        <h3>Redefinir sua senha</h3>

                        <p>
                            Olá, {$linha['nome']}!
                        </p>

                        <p>
                            Você solicitou a recuperação
                            da sua senha.
                        </p>

                        <p>
                            Clique no link abaixo para
                            redefinir sua senha:
                        </p>

                        <p>
                            <a href='$link'>
                                Redefinir minha senha
                            </a>
                        </p>

                        <p>
                            Se você não solicitou a recuperação,
                            ignore este e-mail.
                        </p>
                    ";


                    $enviado = EnviaEmail(
                        $email,
                        'Recupere a sua senha do ecommerce',
                        $html
                    );


                    if ($enviado) {

                        echo "
                            <div class='mensagem-recuperacao'>
                                <b>
                                    E-mail enviado com sucesso!
                                </b>

                                <br>

                                Verifique sua caixa de entrada
                                ou a pasta de spam.
                            </div>
                        ";

                    } else {

                        echo "
                            <div class='mensagem-recuperacao'>
                                <b>
                                    Erro ao enviar o e-mail.
                                </b>
                            </div>
                        ";
                    }
                }
            }

            ?>

        </form>

    </div>

</main>

<?php

include "_rodape.php";

?>