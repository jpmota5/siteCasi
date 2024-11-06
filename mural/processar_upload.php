<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casi";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $conn->real_escape_string($_POST['descricao']);
    
    // Diretório de upload
    $diretorio = '../uploads/';
    
    // Verifica se o diretório de upload existe, se não, cria
    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }
    
    $imagem = $_FILES['imagem'];
    $nomeImagem = time() . '_' . basename($imagem['name']);
    $caminhoCompleto = $diretorio . $nomeImagem;
    
    // Verifica se o upload foi bem-sucedido
    if (move_uploaded_file($imagem['tmp_name'], $caminhoCompleto)) {
        // Insere os dados no banco de dados
        $sql = "INSERT INTO mural (imagem, descricao) VALUES ('$nomeImagem', '$descricao')";
        if ($conn->query($sql) === TRUE) {
            $mensagem = "Upload realizado com sucesso!";
        } else {
            $mensagem = "Erro ao salvar no banco de dados: " . $conn->error;
        }
    } else {
        $mensagem = "Falha no upload da imagem.";
    }
}

$conn->close();
?>

<!-- Exibe o popup com a mensagem e redireciona para o mural -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="2;url=mural.php">
    <title>Confirmação</title>
    <script>
        window.onload = function() {
            // Exibe a mensagem de confirmação ou erro em um popup
            alert("<?php echo $mensagem; ?>");
            
            // Redireciona para a página de mural após 2 segundos
            setTimeout(function() {
                window.location.href = "mural.php";
            }, 2000);
        }
    </script>
</head>
<body>
</body>
</html>
