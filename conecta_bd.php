<?php
define("DSN", "mysql");
define("BD_SERVIDOR", "localhost");
define("BD_USUARIO", "root");
define("BD_SENHA", "");
define("BD_TABELA", "coisarada");

try
{
    $PDO = new PDO( DSN . ':host=' . BD_SERVIDOR . ';dbname=' . BD_TABELA, BD_USUARIO, BD_SENHA );
}
catch ( PDOException $e )
{
    echo 'Erro ao conectar com o Banco de Dados: ' . $e->getMessage();
}

?>

