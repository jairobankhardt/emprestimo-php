<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section class="bloco_conteudo">
            <p><h3>Cadastro</h3></p>
            <form name="form_cad_pessoa" method="post" action="cadastrar_pessoa.php">
                <p><input type="text" name="nome" placeholder="Seu nome" size="30" required></p>
                <p><input type="email" name="email" placeholder="Seu email" size="30" required></p>
                <p><input type="tel" name="telefone" placeholder="Seu telefone (xx) xxxxx-xxxx" size="30" required></p>
                <p><input type="text" name="endereco" placeholder="Seu endereço completo" size="30" required></p>
                <p><input type="password" name="senha" placeholder="Digite uma senha" size="30" required></p>
                <p><input type="submit" name="enviar" value="Enviar"></p>
            </form>
        </section>
        <p>Já possui cadastro? <a href="login.php">Faça já o seu login.</a></p>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>