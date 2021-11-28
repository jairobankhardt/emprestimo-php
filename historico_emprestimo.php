<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section class="bloco_conteudo">
            <p><h3>Histórico de empréstimos</h3></p>
            <section style="text-align: right;">
                <p><a href="javascript:void(0)" onClick="history.go(-1); return false;">Voltar</a></p>
            </section>
        <?php
        require_once "conecta_bd.php";

        try {
            // Seleciona emprestimos
            $sql = "SELECT * FROM emprestimo";
            $query = $PDO->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            if ($resultado) {
                ?>
                <table class="tabela_exibicao">
                    <tr>
                        <th>Coisa</th>
                        <th>Categoria</th>
                        <th>Quem emprestou</th>
                        <th style="width:100px">Data Empréstimo</th>
                        <th style="width:100px">Data Combinada</th>
                        <th style="width:100px">Data Devolução</th>
                    </tr>
                <?php
                foreach ($resultado as $linha) {
                    // Busca o usuário que emprestou o item
                    $id_usuario = $linha['usuario'];
                    $sql_usuario  = "SELECT * FROM usuarios WHERE id_usuario = '$id_usuario '";
                    $query_usuario  = $PDO->prepare($sql_usuario );
                    $query_usuario ->execute();
                    $usuario  = $query_usuario->fetch(PDO::FETCH_ASSOC);
                    $nome_usuario  = explode(" ", $usuario ['nome']);
                    $primeiro_nome = $nome_usuario [0];
                    //Busca coisas 
                    $id_coisa = $linha['item'];
                    $sql_coisa = "SELECT * FROM coisas WHERE id_coisa = '$id_coisa'";
                    $query_coisa = $PDO->prepare($sql_coisa);
                    $query_coisa->execute();
                    $coisas = $query_coisa->fetch(PDO::FETCH_ASSOC);
                    // Formata as datas
                    $data_emp = new DateTime($linha['data_emprestimo']);
                    $data_emprestimo = $data_emp->format('d/m/Y');
                    $data_comb = new DateTime($linha['data_combinada']);
                    $data_combinada =  $linha['data_combinada'] == '0000-00-00' ? "-" : $data_comb->format('d/m/Y');
                    $data_dev = new DateTime($linha['data_devolvido']);
                    $data_devolvido =  $linha['data_devolvido'] == '0000-00-00' ? "-" : $data_dev->format('d/m/Y');
                    // Estilo da linha da tabela conforme status do empréstimo
                    $cor_vencido = "rgb(250, 222, 215)";
                    $cor_semvencimento = "rgb(255, 248, 221)";
                    $cor_noprazo = "rgb(224, 255, 220)";
                    $hoje = date("Y-m-d");
                    if ($linha['data_combinada'] == '0000-00-00') {
                        $cor_fundo = $cor_semvencimento;
                    } elseif ($hoje > $linha['data_combinada']) {
                        $cor_fundo = $cor_vencido;
                    } else {
                        $cor_fundo = $cor_noprazo;
                    }

                    ?>
                    <tr style="background-color: <?php echo $cor_fundo; ?>;">
                        <td><?php echo $coisas['nome_coisa'] ?></td>
                        <td><?php echo $coisas['categoria'] ?></td>
                        <td><a href="usuario.php?usuario=<?php echo $id_usuario; ?>"><?php echo $primeiro_nome ?></a></td>
                        <td><?php echo $data_emprestimo ?></td>
                        <td><?php echo $data_combinada ?></td>
                        <td><?php echo $data_devolvido ?></td>
                    </tr>
                <?php
                }
                ?>
                </table>
            <?php
            }
            else {
                echo "<p>Não há empréstimos até o momento.</p>";
            }
        } catch(PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
        ?>
            <p>&nbsp;</p><p>&nbsp;</p>
            <p><input type="button" value="Voltar" onClick="history.go(-1)"></p>
        </section>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>