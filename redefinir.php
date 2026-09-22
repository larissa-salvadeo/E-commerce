<?php

include "util.php";
include "_cabecalho.php";

?>

<main id="main-recuperacao">

    <div class="recuperacao-container">

        <form
            class="recuperacao-form"
            action=""
            method="POST"
        >

            <h1>Redefinir senha</h1>

            <p>
                Digite sua nova senha e confirme
                para finalizar a recuperação.
            </p>

            <input
                type="password"
                name="senha1"
                placeholder="Nova senha"
                required
            >

            <input
                type="password"
                name="senha2"
                placeholder="Confirme a nova senha"
                required
            >

            <input
                type="submit"
                value="Alterar senha"
            >


            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $conn = conecta();

                $senha1 = $_POST['senha1'];
                $senha2 = $_POST['senha2'];

                $token = $_GET['token'] ?? '';


                if (
                    !isset($_SESSION['sessaoToken']) ||
                    !isset($_SESSION['sessaoEmailRecuperacao'])
                ) {

                    echo "
                        <div class='mensagem-recuperacao'>
                            <b>
                                Solicitação de recuperação inválida.
                            </b>
                        </div>
                    ";

                } elseif (
                    $token !== $_SESSION['sessaoToken']
                ) {

                    echo "
                        <div class='mensagem-recuperacao'>
                            <b>Token inválido!</b>
                        </div>
                    ";

                } else {

                    $email =
                        $_SESSION['sessaoEmailRecuperacao'];


                    if ($senha1 !== $senha2) {

                        echo "
                            <div class='mensagem-recuperacao'>
                                <b>
                                    As senhas estão diferentes.
                                </b>
                            </div>
                        ";

                    } else {

                        $novaSenhaCripto =
                            password_hash(
                                $senha1,
                                PASSWORD_DEFAULT
                            );


                        $sql = "
                            UPDATE usuario
                            SET senha = :senha
                            WHERE email = :email
                            AND excluido = FALSE
                        ";


                        $update = $conn->prepare($sql);


                        $update->bindParam(
                            ':senha',
                            $novaSenhaCripto
                        );


                        $update->bindParam(
                            ':email',
                            $email
                        );


                        $update->execute();


                        if ($update->rowCount() > 0) {

                            echo "
                                <div class='mensagem-recuperacao'>

                                    <b>
                                        Senha alterada com sucesso!
                                    </b>

                                    <br>

                                    <a
                                        href='index.php'
                                        class='voltar-login'
                                    >
                                        Voltar para o login
                                    </a>

                                </div>
                            ";


                            unset(
                                $_SESSION['sessaoToken']
                            );

                            unset(
                                $_SESSION['sessaoEmailRecuperacao']
                            );

                        } else {

                            echo "
                                <div class='mensagem-recuperacao'>
                                    <b>
                                        Não foi possível alterar
                                        a senha.
                                    </b>
                                </div>
                            ";
                        }
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