<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section>
            <?php
            if (isset($_POST['enviar'])) {
                $nome = trim($_POST['nome']);
                $email = trim($_POST['email']);
                $telefone = trim($_POST['telefone']);
                $endereco = trim($_POST['endereco']);
                $senha = sha1(trim($_POST['senha']));

                try {
                    require_once("conecta_bd.php");
                    $sql = "INSERT INTO usuarios (nome, email, telefone, endereco, senha) 
                        VALUES ('$nome','$email','$telefone','$endereco','$senha')";
                    $PDO->exec($sql);
                    ?>
                    <section id="sucesso">
                        Cadastro efetuado com sucesso.
                    </section>
                    <p>&nbsp;</p><p>&nbsp;</p>
                    <p><a href="login.php">Faça seu login.</a></p>
                    <?php
                } catch(PDOException $e) {
                    ?>
                    <section id="falha">
                        Erro no cadastro. Talvez já exista um cadastro com este e-mail (<?php echo $email?>).
                    </section>
                    <p>&nbsp;</p><p>&nbsp;</p>
                    <p><a href="cadastro_usuario.php">Tente novamente.</a></p>
                <?php
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