<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Apartment System</title>
    <link rel="stylesheet" href="{{ asset('pdf.css') }}" type="text/css"> 
</head>
<body>
    <table class="w-full">
        <tr>
            <td class="w-half">
                <img src="{{ asset('admin_assets/assets/images/logo/logo.png') }}" alt="Logo" class="w-16 h-16 mx-auto">
            </td>
            <td class="w-half">
            </td>
        </tr>
    </table>
 
    <div class="margin-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <div><h4>To:</h4></div>
                    <div> {{ $payment->full_name }}</div>
                </td>
                <td class="w-half">
                    <div><h4>From:</h4></div>
                    <div>Apartment System</div>
                </td>
            </tr>
        </table>
    </div>
 
    <div class="margin-top">
        <table class="products">
            <tr>
                <th>Amount Paid</th>
                <th>Date</th>
            </tr>
            <tr class="items">
                    <td>
                        ${{ number_format($payment->amount, 2) }}
                    </td>
                    <td>
                        {{ $payment->created_at->format('F j, Y') }}
                    </td>
            </tr>
        </table>
    </div>
 
    <div class="footer margin-top">
        <div>Thank you</div>
        <div>This is a computer-generated receipt. No signature required.</div>
        <div>&copy; Apartment System</div>
    </div>
</body>
</html>