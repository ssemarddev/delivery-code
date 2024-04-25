<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF con Laravel</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
        h1 {
            margin-bottom: 0rem;
            margin-top: 0rem;
            font-size: 3rem;
        }
        nav>h2,
        nav>p {
            text-align: center;
            margin: 0rem;
        }

        nav>img {
            max-width: 15%;
            max-height: 15%;
        }

        header>div {
            width: 49%;
            margin: .25rem;
        }

        header {
            padding-top: 1.25rem;
        }

        header h3 {
            color: black;
            font-weight: bold;
            margin-bottom: .2rem;
            margin-top: 0;
        }

        header p {
            color: #2c2c2c;
            margin: 0;
        }

        th {
            text-align: left;
            border-bottom: 1px solid black;
        }

        th,
        td {
            margin-left: .25rem;
            margin-right: .25rem;
            padding: .25rem
        }

        tbody>tr:last-child>td {
            border-top: 1px solid black;
        }
    </style>
</head>

<body>
    <h1 style="float: right">0-0</h1>
    <nav>
        <h2>Distribuidora del sur</h2>
        <p>Número del pedido: </p>
    </nav>
    <header>
        <div style="float: left">
            <h3>Detalles del cliente</h3>
            <p>Nombre del cliente: </p>
            <p>Dirección: </p>
        </div>
        <div style="float: right">
            <h3>Detalles del pedido</h3>
            <p>Fecha: </p>
            <p>Vendedor: </p>
            <p>Identificador del pedido: </p>
        </div>
    </header>
    <main style="margin-top: 7.5rem">
        <table style="width:100%; max-width:100%;">
            <thead>
                <tr>
                    <th>COD</th>
                    <th style="text-align: right">Cantidad</th>
                    <th>Producto</th>
                    <th style="text-align: right">Precio</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td style="font-weight: bold">Items</td>
                    <td style="font-weight: bold; text-align: right">0</td>
                    <td style="font-weight: bold"></td>
                    <td style="font-weight: bold; text-align: right">TOTAL</td>
                    <td style="font-weight: bold; text-align: right">0</td>
                </tr>
            </tbody>
        </table>
    </main>

</body>

</html>
