<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section>
            <?php
            if (isset($_POST['enviar'])) {
                $email = trim($_POST['email']);
                $senha = sha1(trim($_POST['senha']));
                
                require_once "conecta_bd.php";
                try {
                    // Seleciona o usuário
                    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
                    $query = $PDO->prepare($sql);
                    $query->execute();
                    $resultado = $query->fetch(PDO::FETCH_ASSOC);
                    if ($resultado) {
                        // Inicializa variáveis da sessão
                        $_SESSION["id_usuario"] = $resultado["id_usuario"];
                        $_SESSION["nome"] = $resultado["nome"];
                        header("Location: index.php");
                    } else {
                       ?>
                        <section id="falha">
                            E-mail ou senha inválidos.
                        </section>
                        <p>&nbsp;</p><p>&nbsp;</p>
                        <p><a href="login.php">Tente novamente.</a></p>
                        <?php
                    }                     
                } catch(PDOException $e) {
                    echo "Erro: " . $e->getMessage();
                }
            } else {
                echo "<session id='falha'>Ops, acho que você entrou aqui por engano.</session>";
            }
            ?>
        </section>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>