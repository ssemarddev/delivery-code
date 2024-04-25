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
    <div style="float: right; padding-left: 1rem">
        <p>Usuario: {{ $user->name }}</p>
        <p>Fecha de creación: {{ $print }}</p>
    </div>
    <p>Lugares de entrega: {{ $regions }}</p>
    <p>Fecha de entrega: {{ $date }}</p>
    <main>
        <table style="width:100%; max-width:100%;">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th style="text-align: right">Cant.</th>
                    <th style="text-align: right; white-space: nowrap">S. inicial</th>
                    <th style="text-align: right; white-space: nowrap">S. actual</th>
                    <th style="text-align: right">Ventas</th>
                    {{-- <th>Hora</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td style="text-align: right">{{ $item['quantity'] }}</td>
                        <td style="text-align: right">{{ $item['stock'] + $item['quantity'] }}</td>
                        <td
                            style="text-align: right; @if ($item['stock'] < 0) color:red; @else color:green; @endif">
                            {{ $item['stock'] }}</td>
                        <td style="font-weight: bold;text-align: right;">
                            {{ number_format($item['total'], 0, ',', '.') }}
                        </td>
                        {{-- <td>{{ date('H:i', strtotime($item->created_at)) }} Hrs.</td> --}}
                    </tr>
                @endforeach
                <tr>
                    <td style="font-weight: bold">Total</td>
                    <td style="font-weight: bold; text-align: right">{{ $total }}</td>
                    <td style="font-weight: bold;"></td>
                    <td style="font-weight: bold; text-align: right">{{ $current }}
                    </td>
                    <td style="font-weight: bold; text-align: right">
                        {{ number_format($sales, 0, ',', '.') }}
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>
