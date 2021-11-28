<?php
session_start();
$id = $_SESSION['id_usuario'];

// Cadastro da coisa
if (isset($_POST['enviar'])) {
    $nome = trim($_POST['nome']);
    $categoria = trim($_POST['categoria']);
    try {
        require_once("conecta_bd.php");
        $sql = "INSERT INTO coisas (nome_coisa, categoria, usuario) 
             VALUES ('$nome','$categoria', '$id')";
        $PDO->exec($sql);
        header("Location:minhas_coisas.php?sucesso=1");
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Update da coisa
if (isset($_POST['alterar'])) {
    $nome = trim($_POST['nome']);
    $categoria = trim($_POST['categoria']);
    $id = $_POST['id'];
    try {
        require_once("conecta_bd.php");
        $sql = "UPDATE coisas SET 
             nome_coisa = '$nome',
             categoria = '$categoria'
             WHERE id_coisa= '$id'";
        $altera = $PDO->prepare($sql);
        $altera->execute();
        header("Location:minhas_coisas.php?sucesso=1");
    } catch(PDOException $e) {
         echo "Erro: " . $e->getMessage();
    }
}

//Delete da coisa
if (isset($_GET['apagar'])) {
    try {
        require_once("conecta_bd.php");
        $id = $_GET['apagar'];
        $sql = "DELETE FROM coisas WHERE id_coisa='$id'";
        $PDO->exec($sql);
        // deletar também da tabela de empréstimo
        $sql = "DELETE FROM emprestimo WHERE item='$id'";
        $PDO->exec($sql);
        header("Location:minhas_coisas.php?sucesso=1");
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Fazer emprestimo
if (isset($_POST['fazer_emprestimo'])) {
    $id_coisa = trim($_POST['coisa']);
    $data_combinada = trim($_POST['data_combinada']);
    $data_emprestimo = trim($_POST['data_emprestimo']);
    try {
        require_once("conecta_bd.php");
        $sql = "INSERT INTO emprestimo (item, usuario, data_emprestimo, data_combinada) 
             VALUES ('$id_coisa','$id', '$data_emprestimo', '$data_combinada')";
        $PDO->exec($sql);
        header("Location:minhas_coisas.php?sucesso_emp=1");
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// Fazer emprestimo
if (isset($_GET['devolver'])) {
    $id_emprestimo = $_GET['devolver'];
    $hoje = date('Y-m-d');
    try {
        require_once("conecta_bd.php");
        $sql = "UPDATE emprestimo SET 
            data_devolvido = '$hoje'
            WHERE id_emprestimo = '$id_emprestimo'";
        $PDO->exec($sql);
        header("Location:minhas_coisas.php?sucesso_dev=1");
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

echo "<session id='falha'>Ops, acho que você entrou aqui por engano ou algo não deu certo.</session>";
?>
