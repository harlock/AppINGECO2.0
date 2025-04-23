<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Envío de Artículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #212529;
        }
        .email-wrapper {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border-top: 5px solid #0dcaf0;
        }
        .header {
            background: linear-gradient(135deg, #0dcaf0, #6c757d);
            color: #ffffff;
            padding: 25px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        .header .icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .content {
            padding: 25px;
        }
        .info-card {
            background-color: #f8f9fa;
            border-left: 4px solid #0dcaf0;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            font-size: 16px;
        }
        .info-item i {
            color: #0dcaf0;
            font-size: 1.3rem;
            margin-right: 10px;
            background-color: #e7faff;
            padding: 6px;
            border-radius: 50%;
        }
        .info-item strong {
            color: #333;
            font-weight: 600;
        }
        .message {
            background-color: #f0fcff;
            padding: 20px;
            border-radius: 8px;
            font-size: 16px;
            color: #333;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 14px;
            color: #6c757d;
            background-color: #f8f9fa;
            border-top: 1px solid #e0e0e0;
        }
        .footer a {
            color: #0dcaf0;
            text-decoration: none;
            font-weight: 500;
        }
        .footer .no-reply {
            font-size: 12px;
            color: #dc3545;
            margin-top: 10px;
            font-style: italic;
        }
        @media (max-width: 576px) {
            .email-wrapper {
                margin: 10px;
                border-top-width: 3px;
            }
            .header {
                padding: 15px;
            }
            .header h1 {
                font-size: 20px;
            }
            .header .icon {
                font-size: 2rem;
            }
            .content, .footer {
                padding: 15px;
            }
            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .info-item i {
                margin-bottom: 6px;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <!-- Encabezado -->
    <div class="header">
        <i class="bi bi-check-circle-fill icon"></i>
        <h1>Gracias por enviar su artículo</h1>
    </div>

    <!-- Contenido -->
    <div class="content">
        <div class="info-card">
            <div class="info-item">
                <i class="bi bi-file-earmark-text"></i>
                <span><strong>Título del Artículo:</strong> {{ $titulo }}</span>
            </div>
            <div class="info-item">
                <i class="bi bi-book"></i>
                <span><strong>Revista:</strong> {{ $revista }}</span>
            </div>
            <div class="info-item">
                <i class="bi bi-mortarboard"></i>
                <span><strong>Modalidad:</strong> {{ $modalidad }}</span>
            </div>
        </div>

        <div class="message">
            <p>Gracias por enviar su artículo. Estaremos revisando su trabajo y le enviaremos los resultados por este mismo correo.</p>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p><i class="bi bi-envelope me-2"></i>Soporte Técnico: <a href="mailto:sistemaingeco@gmail.com">sistemaingeco@gmail.com</a></p>
        <p>Sistema de Gestión de Artículos - INGENCO</p>
        <p class="no-reply"><i class="bi bi-exclamation-circle me-1"></i>Favor de no responder a este mensaje, es un envío automático.</p>
    </div>
</div>
</body>
</html>