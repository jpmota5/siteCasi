<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Coleta os dados do formulário
$nome = $_POST['nome'] ?? ''; // Adiciona um valor padrão se a chave não existir
$endereco = $_POST['endereco'] ?? ''; // Corrigido para 'endereco'
$responsavel = $_POST['responsavel'] ?? '';
$contato1 = $_POST['contato1'] ?? '';
$contato2 = $_POST['contato2'] ?? '';
$turno = $_POST['turno'] ?? '';
$dia = $_POST['dia'] ?? '';
$data_nascimento = $_POST['data_nascimento'] ?? '';

// Prepara a consulta SQL para inserção
$sql = "INSERT INTO criancas (nome, endereco, responsavel, contato1, contato2, turno, dia, data_nascimento)
VALUES ('$nome', '$endereco', '$responsavel', '$contato1', '$contato2', '$turno', '$dia', '$data_nascimento')";

if ($conn->query($sql) === TRUE) {
    $message = "Cadastro realizado com sucesso!";
} else {
    $message = "Erro: " . $sql . "<br>" . $conn->error;
}

// Fecha a conexão
$conn->close();

// Exibe o pop-up com a mensagem
echo "<script type='text/javascript'>
        alert('$message');
        window.location.href = 'visualizar_criancas.php'; 
      </script>";
?>
