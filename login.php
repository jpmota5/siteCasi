<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario = $_POST['email']; 
    $senha = $_POST['senha'];   

    
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND senha = ?");
    $stmt->bind_param("ss", $usuario, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        
        header("Location: index.html");
        exit();
    } else {
        
        echo "<script>
                alert('Usuário ou senha incorretos.');
                window.location.href = 'tela_de_login.html';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
