<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sales Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sales Report</h1>
    <table>
        <thead>
            <tr>
                <th>Room Number</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salesData as $sale)
                <tr>
                    <td>{{ $sale->room_number }}</td>
                    <td>{{ number_format($sale->price, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No sales data available.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
