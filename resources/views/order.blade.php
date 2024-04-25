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
        nav>p,
        h2 {
            text-align: center;
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

        tbody>tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <div style="float: right; background-color: white; z-index:100; height: 150px; width: 110px; text-align: center;">
        <h1 style="font-size:7em;margin-bottom:0rem">{{ $order->client->id }}</h1>
        <h2 style="margin-top:0rem">{{ $order->client->city->province }}</h2>
    </div>
    <nav>
        <h5
            style="font-size: 12px; text-decoration: underline; font-weight: normal; text-align:center; margin-bottom: 0rem">
            DISTRIBUIDORA</h5>
        <h2 style="font-size: 26px; text-align: center">JOSE DEL SUR</h2>
    </nav>

    <header style="margin-top: 1rem; margin-top: 1rem;">
        <div style="float: left; font-size: 12px">
            <h3 style="margin-top: .5rem; font-size:14px">CLIENTE</h3>
            <div style="position: relative; margin-top:.35rem">
                <img style="position: absolute; top: .1rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-person-circle" viewBox="0 0 16 16">
                                      <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                      <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                    </svg>') }} " />
                <span style="margin-left: 1.4em">
                    {{ $order->client->name }}
                </span>
            </div>
            <div style="position: relative; margin-top:.35rem">
                <img style="position: absolute; top: .1rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-credit-card-2-back" viewBox="0 0 16 16">
                                      <path d="M11 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1z"/>
                                      <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2zm13 2v5H1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm-1 9H2a1 1 0 0 1-1-1v-1h14v1a1 1 0 0 1-1 1z"/>
                                    </svg>') }} " />
                <span style="width:100%; position: relative; margin-left: 1.4em">
                    {{ $order->client->rut }}
                    <div style="position: absolute; right:-2rem; ">
                        <img style="position: absolute; top: .1rem; height:14px"
                            src="data:image/svg+xml;base64,'
                            {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                              <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                            </svg>') }} " />
                        <span style="margin-left: 1.4em">
                            {{$order->client->phone}}
                        </span>
                    </div>
                </span>
            </div>

            <div style="position: relative;  margin-top:.35rem">
                <img style="position: absolute; top: .1rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                      <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                    </svg>') }} " />
                <span style="margin-left: 1.4em">
                    {{ $order->client->address }}; {{ $order->client->town }}. {{ $order->client->city->province }}
                </span>
            </div>
        </div>
        <div style="float: right; font-size: 12px;">
            <h3 style="margin-top: .5rem; font-size: 14px">
                PEDIDO {{ $order->client->id }}-{{$order->id}}
                <span style="border-radius: .25rem; font-size: 13px; background-color: #000; color: #fff; padding: .25rem">{{$order->file}}</span>
            </h3>
            <div style="position: relative;  margin-top:.35rem">
                <img style="position: absolute; top: .1rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-person-fill-check" viewBox="0 0 16 16">
                                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514ZM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                      <path d="M2 13c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4Z"/>
                                    </svg>') }} " />
                <span style="margin-left: 1.4em">
                    <strong style="color:#2c2c2c">VENDEDOR:</strong> {{ $order->user->name }}
                </span>
            </div>
            <div style="position: relative;  margin-top:.35rem">
                <img style="position: absolute; top: .1rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                      <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                    </svg>') }} " />
                <span style="margin-left: 1.4em">
                    <strong style="color:#2c2c2c">CEL:</strong> {{ $order->user->phone }}
                </span>
            </div>
            <div style="position: relative;  margin-top:.35rem">
                <img style="position: absolute; top: 0rem; height:14px"
                    src="data:image/svg+xml;base64,'
                    {{ base64_encode('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#000000" class="bi bi-calendar-event" viewBox="0 0 16 16">
                                      <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                      <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                                    </svg>') }} " />
                <span style="margin-left: 1.4em">
                    <strong style="color:#2c2c2c">FECHA:</strong> {{ date('d/m/Y H:i', strtotime($order->created_at) - 18000) }} HRS.
                </span>
            </div>
        </div>
    </header>

    <main style="margin-top: 6.5rem; padding-top: 2rem">
        <table style="width:100%; max-width:100%; font-size: 14px">
            <thead>
                <tr>
                    <th style="text-align: right">Cant.</th>
                    <th>Producto</th>
                    <th style="text-align: right; white-space: nowrap">P. Uni.</th>
                    <th style="text-align: right; white-space: nowrap">P. Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td style="text-align: right">{{ $item->quantity }}</td>
                        <td>
                            {{ $item->product->name }}
                            @if ($item->note != '')
                                <span style="font-style: italic; color: green">({{ $item->note }})</span>
                            @endif
                        </td>
                        <td style="text-align: right">{{ number_format($item->price, 0, ',', '.') }}</td>
                        <td style="text-align: right">{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                <tr style="font-size: 16px">
                    <td style="font-weight: bold; text-align: right">{{ $order->totalItems() }}</td>
                    <td style="font-weight: bold">Items</td>
                    <td style="font-weight: bold; text-align: right; font-size: 16px">TOTAL</td>
                    <td style="font-weight: bold; text-align: right; font-size: 16px">{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </main>

</body>

</html>
