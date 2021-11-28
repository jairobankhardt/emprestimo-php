<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section class="bloco_conteudo">
            <p><h3>Informações do usuário</h3></p>
            <p>&nbsp;</p>
        <?php
        if (isset($_GET['usuario'])) {
            require_once "conecta_bd.php";
            $id_usuario = $_GET['usuario'];
            try {
                // Seleciona o usuário
                $sql = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'";
                $query = $PDO->prepare($sql);
                $query->execute();
                $resultado = $query->fetch(PDO::FETCH_ASSOC);
                ?>
                <p><?php echo $resultado['nome']; ?></p>
                <p><?php echo $resultado['email']; ?></p>
                <p><?php echo $resultado['telefone']; ?></p>
                <p><?php echo $resultado['endereco']; ?></p>
                <p>&nbsp;</p>
                <p><input type="button" value="Voltar" onClick="history.go(-1)"></p>
                <?php
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </section>
        <?php
        } else {
            echo "<session id='falha'>Ops, acho que você entrou aqui por engano.</session>";
        }
        ?>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>