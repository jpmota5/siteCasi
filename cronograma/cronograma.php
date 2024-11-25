<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Atividade</title>
</head>
<body>
    <h1>Cadastrar Atividade no Cronograma</h1>
    <form action="inserir_atividade.php" method="POST">
        <!-- Escolher horário -->
        <label for="horario">Horário:</label>
        <select name="horario" id="horario" required>
            <option value="">Selecione um horário</option>
            <!-- Estes valores podem ser fixos ou também vindos do banco -->
            <option value="08:00-09:00">08:00-09:00</option>
            <option value="09:00-10:00">09:00-10:00</option>
            <option value="10:00-11:00">10:00-11:00</option>
        </select>
        <br><br>

        <!-- Inserir descrição da atividade -->
        <label for="atividade">Descrição da Atividade:</label>
        <input type="text" name="atividade" id="atividade" maxlength="255" required>
        <br><br>

        <!-- Selecionar crianças -->
        <label for="criancas">Selecione as Crianças:</label>
        <select name="criancas[]" id="criancas" multiple size="5" required>
            <?php
            // Conexão com o banco de dados
            $conn = new mysqli('localhost', 'root', '', 'casi');

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Falha na conexão: " . $conn->connect_error);
            }

            // Consulta as crianças
            $sql = "SELECT id, nome FROM criancas";
            $result = $conn->query($sql);

            // Verifica se existem resultados
            if ($result->num_rows > 0) {
                // Gera as opções dinamicamente
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['nome']}</option>";
                }
            } else {
                echo "<option value=''>Nenhuma criança cadastrada</option>";
            }

            $conn->close();
            ?>
        </select>
        <br><br>

        <button type="submit">Cadastrar Atividade</button>
    </form>
</body>
</html>
