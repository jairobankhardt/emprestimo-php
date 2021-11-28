<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <?php include "conecta_bd.php";    
        // Mensagem de sucesso
        if (isset($_GET['sucesso'])) {
        ?>
            <section id="sucesso">
                Item cadastrado, alterado ou deletado com sucesso.
            </section>
        <?php
        }
        // Mensagem de sucesso de emprestimo
        if (isset($_GET['sucesso_emp'])) {
        ?>
            <section id="sucesso">
                Coisa emprestada com sucesso.
            </section>
            <p>&nbsp;</p>
            <p>Quer fazer mais um empréstimo?</p>
            <p><a href="index.php">Vá para a página inicial.</a></p>
        <?php
        }
        // Mensagem de sucesso de devolução
        if (isset($_GET['sucesso_dev'])) {
        ?>
            <section id="sucesso">
                Coisa devolvida com sucesso.
            </section>
            <p>&nbsp;</p>
            <p>Quer fazer um empréstimo?</p>
            <p><a href="index.php">Vá para a página inicial.</a></p>
        <?php
        }

        // Para editar o cadastro de um item
        if (isset($_GET['editar'])) {
            try {
                // Seleciona o usuário
                $sql = "SELECT * FROM coisas WHERE id_coisa = '$_GET[editar]'";
                $query = $PDO->prepare($sql);
                $query->execute();
                $resultado = $query->fetch(PDO::FETCH_ASSOC);
                ?>
                <section class="bloco_conteudo">
                    <p><h3>Alterar coisa</h3></p>
                    <form name="form_upt_coisa" method="post" action="cadastrar_coisa.php">
                        <p><input type="text" name="nome" value="<?php echo $resultado['nome_coisa']; ?>" placeholder="Nome da coisa" size="30" required></p>
                        <p><input type="text" name="categoria" value="<?php echo $resultado['categoria']; ?>" placeholder="Categoria (livro, eletrônico, etc.)" size="30" required></p>
                        <p><input type="submit" name="alterar" value="Alterar"></p>
                        <input type="hidden" name="id" value="<?php echo $resultado['id_coisa']; ?>">
                    </form>
                    </section>
                <?php
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
        }
        ?>


        <section class="bloco_conteudo">
            <p><h3>Meus empréstimos</h3></p>
            <?php
            try {
                // Seleciona empréstimos atuais do usuário logado
                $sql = "SELECT * FROM emprestimo 
                        WHERE usuario = '$_SESSION[id_usuario]' 
                        AND data_devolvido = '0000-00-00' 
                        ORDER BY data_emprestimo";
                $query = $PDO->prepare($sql);
                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
                if ($resultado) {
                    ?>
                    <table class="tabela_exibicao">
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th style="width:100px">Data Empréstimo</th>
                            <th style="width:100px">Data Combinada</th>
                            <th style="width:100px">Devolver</th>
                        </tr>
                    <?php
                    foreach ($resultado as $item) {
                        $id_coisa = $item['item'];
                        // Resgata dados do item
                        $sql_coisa = "SELECT * FROM coisas WHERE id_coisa = '$id_coisa'";
                        $query_coisa = $PDO->prepare($sql_coisa);
                        $query_coisa->execute();
                        $coisa = $query_coisa->fetch(PDO::FETCH_ASSOC);
                        // Formata data
                        $data_emp = new DateTime($item['data_emprestimo']);
                        $data_emprestimo = $data_emp->format('d/m/Y');
                        ?>
                        <tr>
                            <td><?php echo $coisa['nome_coisa']; ?></td>
                            <td><?php echo $coisa['categoria']; ?></td>
                            <td><?php echo $data_emprestimo; ?></td>
                            <td><?php echo $item['data_combinada'] == "0000-00-00" ? "-" : $item['data_combinada']; ?></td>
                            <td><a href="cadastrar_coisa.php?devolver=<?php echo $item['id_emprestimo']; ?>">Devolver</a?</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>
                    <?php
                } else {
                    echo "<p>Você não tem empréstimos.</p>";
                }
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </section>

        <section class="bloco_conteudo">
            <p><h3>Minhas coisas</h3></p>
            <?php
            try {
                // Seleciona itens do usuario logado
                $sql = "SELECT * FROM coisas WHERE usuario = '$_SESSION[id_usuario]'";
                $query = $PDO->prepare($sql);
                $query->execute();
                $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
                if ($resultado) {
                    ?>
                    <table class="tabela_exibicao">
                        <tr>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th style="width:50px">Editar</th>
                            <th style="width:56px">Deletar</th>
                        </tr>
                    <?php
                    foreach ($resultado as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['nome_coisa'] ?></td>
                            <td><?php echo $item['categoria'] ?></td>
                            <td><a href="?editar=<?php echo $item['id_coisa']; ?>">Editar</a></td>
                            <td><a href="cadastrar_coisa.php?apagar=<?php echo $item['id_coisa']; ?>">Deletar</a?</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table>
                    <?php
                } else {
                    echo "<p>Você ainda não cadastrou nenhuma coisa.</p>";
                }
            } catch(PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </section>

        <section class="bloco_conteudo">
            <p><h3>Cadastrar coisa</h3></p>
            <form name="form_cad_coisa" method="post" action="cadastrar_coisa.php">
                <p><input type="text" name="nome" placeholder="Nome da coisa" size="30" required></p>
                <p><input type="text" name="categoria" placeholder="Categoria (livro, eletrônico, etc.)" size="30" required></p>
                <p><input type="submit" name="enviar" value="Enviar"></p>
            </form>
        </section>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>