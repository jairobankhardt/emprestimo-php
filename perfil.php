<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <?php
        require_once "conecta_bd.php";

        // Alterar dados do usuario logado
        if (isset($_POST['alterar'])) {
            $id = $_SESSION['id_usuario'];
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $telefone = trim($_POST['telefone']);
            $endereco = trim($_POST['endereco']);
            $senha = trim($_POST['senha']);
            if ($senha <> "") {
                $senha = sha1(trim($_POST['senha']));
            } else {
                $senha = trim($_POST['senha_antiga']);
            }
            try {
                $sql = "UPDATE usuarios SET 
                    nome = '$nome',
                    email = '$email',
                    telefone = '$telefone',
                    endereco = '$endereco',
                    senha = '$senha' 
                    WHERE id_usuario = '$id'";
                $altera = $PDO->prepare($sql);
                $altera->execute();
                ?>
                <section id="sucesso">
                    Cadastro alterado com sucesso.
                </section>
                <p>&nbsp;</p><p>&nbsp;</p>
            <?php
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }

        // Apagar cadastro do usuario logado
        if (isset($_POST['deletar'])) {
            try {
                $id = $_SESSION['id_usuario'];
                $sql = "DELETE FROM usuarios WHERE id_usuario='$id'";
                $PDO->exec($sql);
                // Apagar empréstimos do usuário
                $sql = "DELETE FROM emprestimo WHERE usuario='$id'";
                $PDO->exec($sql);
                // Apagar itens do usuário
                $sql = "DELETE FROM coisas WHERE usuario='$id'";
                $PDO->exec($sql);
                ?>
                <section id="sucesso">
                    Cadastro deletado com sucesso.
                </section>
                <p>&nbsp;</p><p>&nbsp;</p>
                <?php
                session_unset();
                session_destroy();
                header("Location:index.php");
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        ?>

        <!— EXIBIÇÃO DOS DADOS, INTERAÇÃO COM O USUÁRIO —>
        <p>Estes são os seus dados.</p>
        <p>Para alterá-los bastar modificar os campos e clicar no botão [Alterar Cadastro]. </p>
        <?php
        // Resgatando os dados para o formulário.
        try {
            // Seleciona o usuário
            $sql = "SELECT * FROM usuarios WHERE id_usuario = '$_SESSION[id_usuario]'";
            $query = $PDO->prepare($sql);
            $query->execute();
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        ?>
        <section class="bloco_conteudo">
            <form name="form_upd_pessoa" method="post" action="">
                <p><h3>Meu cadastro</h3></p>
                <p><input type="text" name="nome" value="<?php echo $resultado['nome'] ?>" placeholder="Seu nome" size="30" required></p>
                <p><input type="email" name="email" value="<?php echo $resultado['email'] ?>" placeholder="Seu email" size="30" required></p>
                <p><input type="tel" name="telefone" value="<?php echo $resultado['telefone'] ?>" placeholder="Seu telefone (xx) xxxxx-xxxx" size="30" required></p>
                <p><input type="text" name="endereco" value="<?php echo $resultado['endereco'] ?>" placeholder="Seu endereço completo" size="30" required></p>
                <p><input type="password" name="senha" placeholder="Digite uma nova senha" size="30" value=""></p>
                <p><input type="submit" name="alterar" value="Alterar Cadastro"></p>
                <input type="hidden" name="senha_antiga" value="<?php echo $resultado['senha']; ?>" size="40">
            </form>
        </section>
        <p>Quer apagar seu cadastro? Clique botão abaixo.</p></br>
        <form name="form_del_pessoa" method="post" action="">
            <input type="submit" name="deletar" value="Deletar Cadastro">
        </form>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>