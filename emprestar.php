<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <?php
        require_once "conecta_bd.php";

        // Alterar dados
        if (isset($_GET['alterar'])) {
            $id = $_SESSION['id_usuario'];
            $nome = trim($_POST['nome']);
            $email = trim($_POST['email']);
            $telefone = trim($_POST['telefone']);
            $endereco = trim($_POST['endereco']);
            if (isset($_POST['senha'])) {
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

        // Apagar cadastro
        if (isset($_POST['deletar'])) {
            try {
                $id = $_SESSION['id_usuario'];
                $sql = "DELETE FROM usuarios WHERE id_usuario='$id'";
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

        <section class="bloco_conteudo">
        <?php
        if (isset($_GET['item'])) {
            // Resgatando os dados para o formulário.
            try {
                // Seleciona item
                $sql = "SELECT * FROM coisas WHERE id_coisa = $_GET[item]";
                $query = $PDO->prepare($sql);
                $query->execute();
                $item = $query->fetch(PDO::FETCH_ASSOC);
                ?>
                <p><h3>Coisa que será emprestada para</h3></p>
                <p><h3><?php echo $_SESSION['nome']; ?></h3></p>
                <P>&nbsp;</P>
                <p>Coisa: <?php echo $item['nome_coisa']; ?></p>
                <p>Categoria: <?php echo $item['categoria']; ?></p>
                <p>Emprestando hoje: <?php echo date('d/m/Y'); ?></p>

                <form name="form_emprestimo" method="post" action="cadastrar_coisa.php">
                    <p>Em que data pretende devolver? (opcional): <input type="date" name="data_combinada"></p>
                    <P>&nbsp;</P>
                    <p><input type="submit" name="fazer_emprestimo" value="Clique aqui fazer o empréstimo deste item."></p>
                    <input type="hidden" name="coisa" value="<?php echo $item['id_coisa'] ?>" >
                    <input type="hidden" name="data_emprestimo" value="<?php echo date('Y-m-d'); ?>">
                </form>
                <?php
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        ?>
        </section>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>