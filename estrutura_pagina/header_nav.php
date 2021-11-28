<body>
    <header>
        <h1>Coisarada</h1>
        <p>Sistema de Empréstimo</p>
    </header>
    <nav id="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php
            if (isset($_SESSION['id_usuario'])) {
            ?>
                <li><a href="perfil.php">Meu perfil</a></li>
                <li><a href="minhas_coisas.php">Minhas coisas</a></li>
                <li><a href="sair.php">Sair</a></li>
            <?php
            } else {
            ?>
                <li><a href="cadastro_usuario.php">Cadastro</a></li>
                <li><a href="login.php">Login</a></li>
            <?php
            }
            ?>
        </ul>
    </nav>