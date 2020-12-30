@php
use Illuminate\Support\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kwitansi</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
        .float_right {
            text-align: right
        }

    </style>
</head>

<body>
    <div class="container" style="width: 600px">
        <div class="header text-center">
            <h2 class="center">SION YAMARA</h2>
            <h3 class="center">Kwitansi Perpuluhan</h3>
        </div>
        <hr>
        <div class="content mb-3">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <p>Telah Menerima Dari</p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p class="ml-3">{{ $perpuluhan->nm_jemaat }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Jumlah Perpuluhan</p>
                        </td>
                        <td>
                            <p>:</p>
                        </td>
                        <td>
                            <p class="ml-3">@currency($perpuluhan->jumlah)</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-6 text-center">
                <p>Bendahara</p>
                <p class=" mt-5">Pnt. Barbalince. Andarek</p>
            </div>
            <div class="col-12 text-right">
                <p>{{ Carbon::parse($perpuluhan->tgl_perpuluhan)->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
</body>

</html>
