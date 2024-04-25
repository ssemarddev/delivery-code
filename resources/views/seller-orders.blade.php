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
            font-size: 2rem;
        }

        nav>h2,
        nav>p,
        h3 {
            /*text-align: center;*/
            margin: 0rem;
        }

        nav>img {
            max-width: 15%;
            max-height: 15%;
        }

        header>div {
            width: 39%;
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

        p {
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

        tbody>tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <nav>
        <h5 style="font-size: 9px; text-decoration: underline; font-weight: normal; text-align:center; margin-bottom: 0rem">DISTRIBUIDORA</h5>
        <h2 style="font-size: 24px; text-align: center">JOSE DEL SUR</h2>
    </nav>
    <div style="">
        <p>Vendedor: {{ $user->name }}</p>
        <p>Fecha de creación: {{ $print }}</p>
    </div>
    <main style="margin-top: 1rem">
        <table style="width:100%; max-width:100%;">
            <thead>
                <tr>
                    <th style="text-align: center">#</th>
                    <th style="text-align: center">ID</th>
                    <th>Cliente</th>
                    <th>Ciudad</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th style="text-align: center">Items</th>
                    <th style="text-align: right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $i => $item)
                    <tr>
                        <td style="text-align: center">{{ $i + 1 }}</td>
                        <td style="text-align: center">{{ $item->client->id }}</td>
                        <td>{{ $item->client->name }}</td>
                        <td>{{ $item->client->city->province }}</td>
                        <td>{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                        <td style="white-space: nowrap">{{ date('H:i', strtotime($item->created_at)) }} Hrs.</td>
                        <td style="text-align: center">{{ $item->totalItems() }}</td>
                        <td style="text-align: right">{{ number_format($item->totalPrice(), 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td style="text-align: right"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right; font-weight: bold">{{ $items }}</td>
                    <td style="text-align: right; font-weight: bold">{{ number_format($total, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
