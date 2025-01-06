<!DOCTYPE html>
<html>

<head>
    <title>Data Pesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 24px;
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
        }

        th,
        td {
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Data Pesanan</h1>
        <p>Hotel XYZ</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Nama Tamu</th>
                <th>Tipe Kamar</th>
                <th>Check-In</th>
                <th>Check-Out</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id_pesanan }}</td>
                    <td>{{ $order->nama_tamu }}</td>
                    <td>{{ $order->tipe_kamar }}</td>
                    <td>{{ $order->check_in }}</td>
                    <td>{{ $order->check_out }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated on {{ date('Y-m-d') }}</p>
    </div>

</body>

</html>
