<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email</title>
</head>
<body>
    {{--<h1>{{ $details ['title'] }}</h1>
    <p>{{ $details ['body']}}</p>
    <br>--}}
    <p> Gracias por enviar su artículo:</p>
    <h1>{{ $titulo }}</h1>
    <p><strong>Revista:</strong> {{ $revista }}</p>
    <p><strong>Modalidad:</strong> {{ $modalidad }}</p>
    <p> Recuerda que te estaremos enviando por correo tus resultados, en caso de ser aprobado tendrás que realizar el pago y la presentacion para recibir tus constancias.</p>
</body>
</html>