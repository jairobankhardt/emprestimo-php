<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section>
            <?php
            if (isset($_SESSION['id_usuario'])) {
                echo "<p>O que você está <strike>pensando</strike> emprestando, " . $_SESSION['nome'] . "?</p>";
                echo "<p>&nbsp;</p>";
            }
            require_once "conecta_bd.php";
            $coisas_disponiveis = array(); // coleção que irá receber os itens disponíveis
            $coisas_emprestadas = array(); // coleção que irá receber os itens emprestados
            try {
                //Resgata a lista de itens em ordem alfabética
                $sql = "SELECT * FROM coisas ORDER BY nome_coisa";
                $query = $PDO->prepare($sql);
                $query->execute();
                $itens = $query->fetchAll(PDO::FETCH_ASSOC);

                // Preenche as coleções de coisas
                if ($itens) {
                    // Percorre a lista de itens
                    foreach ($itens as $item) {
                        $id_item = $item['id_coisa'];
                        $sql = "SELECT * FROM emprestimo WHERE item = '$id_item'";
                        $query = $PDO->prepare($sql);
                        $query->execute();
                        $emprestimo = $query->fetchAll(PDO::FETCH_ASSOC);
                        // Verifica empréstimo do item
                        if (!$emprestimo) {
                            // O item não está na tabela de empréstimo, então o item está disponível
                            array_push($coisas_disponiveis, $item);
                        } else {
                            // Seleciona o último empréstimo do item ordenado pelo id
                            // pois os empréstimos anteriores deste item
                            // com certeza já foram devolvidos.
                            $sql_emp = "SELECT id_emprestimo, data_emprestimo, data_combinada, data_devolvido, usuario as usu_emp 
                                        FROM emprestimo 
                                        WHERE item = '$id_item' 
                                        ORDER BY id_emprestimo DESC LIMIT 1";
                            $query_emp = $PDO->prepare($sql_emp);
                            $query_emp->execute();
                            $maior_data = $query_emp->fetch(PDO::FETCH_ASSOC);
                            // O item foi emprestado mas já foi devolvido, portanto está disponível
                            if ($maior_data['data_devolvido'] <> "0000-00-00") {
                                array_push($coisas_disponiveis, $item);
                            } else {
                                // O item está emprestado
                                // Nesta coleção há os dados do item e datas do empréstimo
                                $dados_emprestimo = array_merge($item, $maior_data);
                                array_push($coisas_emprestadas, $dados_emprestimo);
                            }
                        }
                    }
                }

            } catch(PDOException $e) {
                echo "Erro em buscar itens: " . $e->getMessage();
            }
            ?>
        </section>
        
        <!— LISTA DE COISAS DISPONÍVEIS —>
        <section class="bloco_conteudo">
            <h3>Coisas disponíveis para empréstimo</h3>
            <?php
            if (!$coisas_disponiveis) {
                echo "<p>Não há itens disponíveis.</p>";
            } else { 
                ?>
                <table class="tabela_exibicao">
                    <tr>
                        <th>Coisa</th>
                        <th>Categoria</th>
                        <th>Dono</th>
                        <?php
                        // A coluna para emprestar o item só será exibida
                        // para usuários logados.
                        if (isset($_SESSION['id_usuario'])) {
                            echo '<th style="width:80px">Emprestar</th>';
                        }
                        ?>
                    </tr>
                <?php
                // Resgata coleção com os itens disponíveis para empréstimo
                foreach ($coisas_disponiveis as $disponivel) {
                    // Busca o usuário que cadastrou o item
                    $id_dono = $disponivel['usuario'];
                    $sql_dono = "SELECT * FROM usuarios WHERE id_usuario = '$id_dono'";
                    $query_dono = $PDO->prepare($sql_dono);
                    $query_dono->execute();
                    $dono = $query_dono->fetch(PDO::FETCH_ASSOC);
                    $nome_dono = explode(" ", $dono['nome']);
                    $primeiro_nome = $nome_dono[0];
                    ?>
                    <tr>
                        <td><?php echo $disponivel['nome_coisa'] ?></td>
                        <td><?php echo $disponivel['categoria'] ?></td>
                        <td><a href="usuario.php?usuario=<?php echo $id_dono; ?>"><?php echo $primeiro_nome ?></a></td>
                        <?php
                        // A coluna para emprestar o item só será exibida
                        // para usuários logados.
                        if (isset($_SESSION['id_usuario'])) { ?>
                            <td><a href="emprestar.php?item=<?php echo $disponivel['id_coisa'] ?>">Emprestar</a></td>
                        <?php } ?>
                    </tr>
                <?php
                }
                ?>
                </table>
                <?php
            }
            ?>
        </section>

        <!— LISTA DE COISAS EMPRESTADAS —>
        <section class="bloco_conteudo">
            <h3>Coisas já emprestadas</h3>
            <?php
            if (!$coisas_emprestadas) {
                echo "<p>Não há itens emprestados.</p>";
            } else { 
                ?>
                <table class="tabela_exibicao">
                    <tr>
                        <th>Coisa</th>
                        <th>Categoria</th>
                        <th>Quem Emprestou</th>
                        <th style="width:100px">Data Empréstimo</th>
                        <th style="width:100px">Data Combinada</th>
                    </tr>
                <?php
                // Resgata coleção com os itens emprestados
                foreach ($coisas_emprestadas as $emprestado) {
                    // Busca o usuário que cadastrou o item
                    $id_usuemp = $emprestado['usu_emp'];
                    $sql_usuemp = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuemp'";
                    $query_usuemp = $PDO->prepare($sql_usuemp);
                    $query_usuemp->execute();
                    $usuemp = $query_usuemp->fetch(PDO::FETCH_ASSOC);
                    $nome_usuemp = explode(" ", $usuemp['nome']);
                    $primeiro_nome = $nome_usuemp[0];
                    // Formata as datas
                    $data_emp = new DateTime($emprestado['data_emprestimo']);
                    $data_emprestimo = $data_emp->format('d/m/Y');
                    $data_comb = new DateTime($emprestado['data_combinada']);
                    $data_combinada =  $emprestado['data_combinada'] == '0000-00-00' ? "-" : $data_comb->format('d/m/Y');
                    // Estilo da linha da tabela conforme status do empréstimo
                    $cor_vencido = "rgb(250, 222, 215)"; // vermelho claro
                    $cor_semvencimento = "rgb(255, 248, 221)"; // amarelo claro
                    $cor_noprazo = "rgb(224, 255, 220)"; // verde claro
                    $hoje = date("Y-m-d");
                    if ($emprestado['data_combinada'] == '0000-00-00') {
                        $cor_fundo = $cor_semvencimento;
                    } elseif ($hoje > $emprestado['data_combinada']) {
                        $cor_fundo = $cor_vencido;
                    } else {
                        $cor_fundo = $cor_noprazo;
                    }
                    ?>
                    <tr style="background-color: <?php echo $cor_fundo; ?>;">
                        <td><?php echo $emprestado['nome_coisa'] ?></td>
                        <td><?php echo $emprestado['categoria'] ?></td>
                        <td><a href="usuario.php?usuario=<?php echo $emprestado['usuario']; ?>"><?php echo $primeiro_nome ?></a></td>
                        <td><?php echo $data_emprestimo ?></td>
                        <td><?php echo $data_combinada ?></td>
                    </tr>
                <?php
                }
                ?>
                </table>
                <?php
            }
            ?>
        </section>
        <p><a href='historico_emprestimo.php'>Ver histórico de todos os empréstimos</a></p>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>