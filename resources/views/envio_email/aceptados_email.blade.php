<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articulo Aceptado</title>
    <!-- FontAwesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        h1 {
            color: #ffffff;
            background-color: #2cbe24;
            padding: 15px;
            margin: 0;
            border-radius: 8px 8px 0 0;
            font-size: 22px;
            text-align: center;
        }

        .table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        .table td {
            padding: 12px 18px; /* Espaciado mejorado */
            border: 1px solid #e0e0e0;
            font-size: 17px;
            color: #333;
            vertical-align: top;
        }

        .table td:first-child {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .message {
            padding: 15px;
            font-size: 16px;
            color: #2c7f2e; /* Color distintivo para felicitación */
            background-color: #f0faf0;
            border-radius: 0 0 8px 8px;
            border-top: 1px solid #e0e0e0;
        }

        footer {
            text-align: left;
            margin-top: 25px;
            font-size: 13px;
            color: #777;
        }

        .footer-small {
            font-size: 12px;
            color: #555;
        }

        .icon {
            color: #267110;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-clipboard-check icon"></i>{{ $titulo }}</h1>
    <table class="table">
        <tr>
            <td><i class="fas fa-check-circle icon"></i>Estado del artículo:</td>
            <td><strong>Aprobado</strong></td>
        </tr>
        <tr>
            <td><i class="fas fa-newspaper icon"></i>Revista:</td>
            <td><strong>{{ $revista }}</strong></td>
        </tr>
        <tr>
            <td><i class="fas fa-cogs icon"></i>Modalidad:</td>
            <td><strong>{{ $modalidad }}</strong></td>
        </tr>
    </table>
    <div class="message">
        <p>¡Felicidades por la aprobación de su artículo para publicación!</p>
        <p>Le recordamos que debe cargar la carta de cesión de derechos en el sistema, conforme a los requisitos de la revista donde registró su artículo.</p>
    </div>
    <footer>
        <p class="footer-small"><i class="fas fa-envelope icon"></i>Soporte Técnico: sistemaingeco@gmail.com</p>
    </footer>
</div>
</body>
</html>
