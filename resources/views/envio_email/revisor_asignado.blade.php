<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisor Asignado</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

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
            background-color: #0066cc;
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
            padding: 12px 18px;
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
            color: #444;
            background-color: #f8f8f8;
            border-radius: 0 0 8px 8px;
            border-top: 1px solid #e0e0e0;
            margin-top: 15px;
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
            color: #0066cc;
            margin-right: 8px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Revisor Asignado</h1>
    <table class="table">
        <tr>
            <td><i class="fas fa-file-alt icon"></i>Título del artículo:</td>
            <td><strong>{{ $titulo }}</strong></td>
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
        <p>Estimado Revisor,</p>
        <p>Se le ha asignado un nuevo artículo para revisión. Por favor, inicie sesión en el sistema para acceder al artículo y comenzar con el proceso de evaluación.</p>
    </div>
    <footer>
        <p class="footer-small">Soporte Técnico: sistemaingeco@gmail.com</p>
    </footer>
</div>
</body>
</html>
