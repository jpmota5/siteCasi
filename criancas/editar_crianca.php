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

// Obtém o ID da criança a ser editada
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$crianca = null; // Inicializa a variável

if ($id > 0) {
    // Consulta para obter os dados da criança
    $sql = "SELECT * FROM criancas WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $crianca = $result->fetch_assoc();
        $stmt->close();
    } else {
        die("Erro ao preparar a consulta: " . $conn->error);
    }
    
    if (!$crianca) {
        die("Criança não encontrada.");
    }
} else {
    die("ID da criança não especificado ou inválido.");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Criança</title>
    <style>
       *{
            padding: 0%;
            margin: 0%;
        }
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("../cadastro2.png");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat; 
            width: 100vw;
            height: 100vh;
            overflow: hidden; 
        }
        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 128, 0, 0.7);
            padding: 20px;
            border-radius: 20px;
            width: 35%;
            color: white;
        }
        fieldset{
            border: 3px solid white;
            padding: 10px;
        }
        legend{
            font-size: large;
            border: 1px solid green;
            padding: 10px;
            text-align: center;
            background-color: rgba(0, 128, 0, 0.7);
            border-radius: 8px;
            color: white;
        }
        .inputBox{
            position:relative;
        }
        .inputUser{
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 95%;
            letter-spacing: 2px;
        }
        .labelInput{
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5px;
        }
        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput{
            top: -20px;
            font-size: 14px;
            color: black;
        }
        #data_nascimento, select {
            border: none;
            padding: 7px;
            border-radius: 10px;
            outline: none;
            background-color: #fff;
        }
        .form-container {
            text-align: center;
        }
        #submit{
            background-color: #008000;
            width: 60%;
            border: none;
            padding: 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 15px;
            color: white;
            margin: 0 auto;
            display: block;
        }
        #submit:hover{
            background-color:#2e8b57;
            cursor: pointer;
        }
        .flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px; 
        }
        .flex-item {
            flex: 1;
            min-width: 0; 
        }

        #view_button {
            background-color: #008000;
            border: none;
            padding: 15px;
            font-size: 15px;
            cursor: pointer;
            border-radius: 15px;
            color: white;
            position: absolute;
            top: 20px;
            right: 20px;
            text-align: center;
            text-decoration: none;
        }
        #view_button:hover {
            background-color:#2e8b57;
        }

    </style>
</head>
<body>
    <a href="../visualizar_criancas.php" id="view_button">Voltar à Lista</a>
    <div class="box">
        <form action="processa_edicao.php" method="POST" class="form-container">
            <fieldset>
                <legend>Editar Dados da Criança</legend>
                <div class="inputBox">
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($crianca['id']); ?>">
                    
                    <input type="text" name="nome" id="nome" class="inputUser" value="<?php echo htmlspecialchars($crianca['nome']); ?>" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" value="<?php echo htmlspecialchars($crianca['endereco']); ?>" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type="text" name="responsavel" id="responsavel" class="inputUser" value="<?php echo htmlspecialchars($crianca['responsavel']); ?>" required>
                    <label for="responsavel" class="labelInput">Responsável</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type="tel" name="contato1" id="contato1" class="inputUser" value="<?php echo htmlspecialchars($crianca['contato1']); ?>" required>
                    <label for="contato1" class="labelInput">Contato 1</label>
                </div>
                <br><br>

                <div class="inputBox">
                    <input type="tel" name="contato2" id="contato2" class="inputUser" value="<?php echo htmlspecialchars($crianca['contato2']); ?>" required>
                    <label for="contato2" class="labelInput">Contato 2</label>
                </div>
                <br>

                <div class="flex-container">
                    <div class="flex-item">
                        <p><b>Turno de preferência:</b></p>
                        <input type="radio" id="manha" name="turno" value="manhã" <?php echo isset($crianca['turno']) && $crianca['turno'] == 'manhã' ? 'checked' : ''; ?> required>
                        <label for="manha">Manhã</label>
                        <input type="radio" id="tarde" name="turno" value="tarde" <?php echo isset($crianca['turno']) && $crianca['turno'] == 'tarde' ? 'checked' : ''; ?> required>
                        <label for="tarde">Tarde</label>
                    </div>

                    <div class="flex-item">
                        <p><b>Gênero:</b></p>
                        <select name="dia" id="dia">
                            <option value="Feminino" <?php echo isset($crianca['dia']) && $crianca['dia'] == 'Feminino' ? 'selected' : ''; ?>>Feminino</option>
                            <option value="Masculino" <?php echo isset($crianca['dia']) && $crianca['dia'] == 'Masculino' ? 'selected' : ''; ?>>Masculino</option>
                        </select>
                    </div>

                    <div class="flex-item">
                        <p><b>Data de Nascimento:</b></p>
                        <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo isset($crianca['data_nascimento']) ? htmlspecialchars($crianca['data_nascimento']) : ''; ?>" required>
                    </div>
                </div>
                <br><br>
                <input type="submit" name="submit" id="submit" value="Atualizar">
            </fieldset>
        </form>
    </div>
</body>
</html>
