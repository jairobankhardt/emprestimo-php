<?php
include "estrutura_pagina/head.php";
include "estrutura_pagina/header_nav.php";
?>
    <main>
        <section class="bloco_conteudo">
            <p><h3>Login</h3></p>
            <form name="form_login" method="post" action="logar.php"> 
                <p><input type="text" name="email" placeholder="Digite seu e-mail" size="30" required></p>
                <p><input type="password" name="senha" placeholder="Digite sua senha" size="30" required></p>
                <p><input type="submit" name="enviar" value="Enviar"></p>
            </form>
        </section>
        <p>Ainda não possui cadastro? <a href="cadastro_usuario.php">Faça já o seu aqui.</a></p>
    </main>
<?php
include "estrutura_pagina/footer.php";
?>