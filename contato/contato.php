
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Site CASI</title>
    <style>
        /* Estilos Gerais */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: url("../cadastro2.png");
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            over
        }
        /* Container Principal */
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            margin: 200px;
        }

        h1 {
            font-size: 2em;
            color: #333;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 20px;
        }

        /* Links de Contato */
        .contact-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .contact-links a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            font-size: 1.2em;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #e0e0e0;
            transition: background-color 0.3s;
        }

        .contact-links a:hover {
            background-color: #d0d0d0;
        }

        /* Ícones de Redes Sociais */
        .social-icon {
            width: 24px;
            height: 24px;
        }

        header {
            text-align: center;
            margin-top: 5px;
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
        .home-button:hover {
            background-color: #2e8b57;
        }
    </style>
</head>
<body>
    <!-- Botão de Página Inicial -->
    <a href="../index.html" class="home-button">Página Inicial</a>
    <div class="container">
        <h1>Contato</h1>
        <p>Entre em contato conosco por meio das redes sociais ou pelo WhatsApp:</p>

        <div class="contact-links">
            <!-- Link para Instagram -->
            <a href="https://instagram.com/marcelageremias" target="_blank">
                <img src="/siteCasi/img/instagram-icon.png" alt="Instagram" class="social-icon"> Instagram
            </a>

            <!-- Link para WhatsApp -->
            <a href="https://wa.me/+5534988252449" target="_blank">
                <img src="/siteCasi/img/whatsapp-icon.png" alt="WhatsApp" class="social-icon"> WhatsApp
            </a>
        </div>
    </div>
</body>
</html>
