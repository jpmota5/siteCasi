<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url("cadastro2.png");
            display: flex;
            background-size: cover;
            background-position: center;
            justify-content: center;
            align-items: center;
            background-repeat: no-repeat;
            height: 100vh;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        .container h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
        }
        .form-group input[type="file"] {
            width: 100%;
        }
        .form-group textarea {
            width: 100%;
            height: 100px;
        }
        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #218838;
        }
        .home-button {
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
    </style>
</head>
<body>
    <a href="mural.php" class="home-button">Voltar ao Mural</a>

    <div class="container">
        <h2>Envio de Imagem e Descrição</h2>
        <form action="processar_upload.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="imagem">Escolha uma imagem:</label>
                <input type="file" name="imagem" id="imagem" required>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Enviar</button>
            </div>
        </form>
    </div>
</body>
</html>
