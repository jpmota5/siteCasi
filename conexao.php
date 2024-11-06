<?php
$host = 'localhost'; // Ou 127.0.0.1
$user = 'root'; // Usuário padrão do MySQL no XAMPP
$pass = ''; // Senha padrão é vazia
$dbname = 'casi';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Conexão falhou: ' . $conn->connect_error);
}

//echo 'Conectado com sucesso';
?>
