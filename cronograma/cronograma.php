<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Atividade</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #555;
        }

        input, select, button {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus, select:focus, button:focus {
            border-color: #5c6bc0;
            outline: none;
        }

        button {
            background-color: #5c6bc0;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3f51b5;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group select {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Atividade no Cronograma</h1>
        <form action="inserir_atividade.php" method="POST" onsubmit="showPopup()">
            <div class="form-group">
                <label for="horario">Horário:</label>
                <select name="horario" id="horario" required>
                    <option value="">Selecione um horário</option>
                    <option value="08:00-09:00">08:00-09:00</option>
                    <option value="09:00-10:00">09:00-10:00</option>
                    <option value="10:00-11:00">10:00-11:00</option>
                    <option value="13:00-14:00">13:00-14:00</option>
                    <option value="14:00-15:00">14:00-15:00</option>
                    <option value="15:00-16:00">15:00-16:00</option>
                    <option value="16:00-17:00">16:00-17:00</option>
                </select>
            </div>

            <div class="form-group">
                <label for="atividade">Descrição da Atividade:</label>
                <input type="text" name="atividade" id="atividade" maxlength="255" required>
            </div>

            <div class="form-group">
                <label for="dia">Dia da Atividade:</label>
                <select name="dia" id="dia" required>
                    <option value="">Selecione o dia</option>
                    <option value="segunda">Segunda-feira</option>
                    <option value="terca">Terça-feira</option>
                    <option value="quarta">Quarta-feira</option>
                    <option value="quinta">Quinta-feira</option>
                    <option value="sexta">Sexta-feira</option>
                </select>
            </div>

            <div class="form-group">
                <label for="criancas">Selecione as Crianças:</label>
                <select name="criancas[]" id="criancas" multiple size="5" required>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'casi');
                    if ($conn->connect_error) {
                        die("Falha na conexão: " . $conn->connect_error);
                    }
                    $sql = "SELECT id, nome FROM criancas";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                        }
                    } else {
                        echo "<option value=''>Nenhuma criança cadastrada</option>";
                    }
                    $conn->close();
                    ?>
                </select>
            </div>

            <button type="submit">Cadastrar Atividade</button>
        </form>
    </div>
</body>
</html>
