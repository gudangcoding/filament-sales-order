<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SO No. {{ $so_no }}</title>
    <style>
        h4 {
            margin: 0;
        }

        .w-full {
            width: 100%;
        }

        .w-half {
            width: 50%;
            padding: 20px;
        }

        .margin-top {
            margin-top: 1.25rem;
        }

        .footer {
            font-size: 0.875rem;
            clear: both;
        }

        table {
            width: 100%;
            border-spacing: 0;
        }



        table.products {
            font-size: 0.875rem;
        }

        table.products tr {
            background-color: white;
        }

        table.products th {
            color: #000000;
            border: solid gray 1px;
            padding: 0.5rem;
        }

        table tr.items {
            background-color: white;
        }

        table tr.items td {
            padding: 0.5rem;
        }

        .total {
            text-align: right;
            margin-top: 1rem;
            font-size: 0.875rem;
            display: flex;

            .summary {
                width: 35%;
                float: right;
                display: flex;
                justify-content: flex-end;
            }

        }

        table,
        tr,
        td {
            border-bottom: 1px solid gray;
        }
    </style>
</head>

<body>

    <div class="header-top">
        <table class="w-full">
            <tr>
                <td class="w-half">
                    <h2> {{ $salesOrder->customer->jenis_badan_usaha }} -
                        {{ $salesOrder->customer->nama_customer }} </h2>
                </td>
                <td class="w-half">
                    <h3>Kepada:</h3>
                    <table>

                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td> &nbsp;{{ $salesOrder->customer->contacts->first()->sebutan }}.
                                {{ $salesOrder->customer->contacts->first()->nama }}</td>
                        </tr>
                        <tr>
                            <td>SO No</td>
                            <td>:</td>
                            <td> &nbsp;{{ $so_no }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td> &nbsp;{{ date('d/m/Y', strtotime($salesOrder->tanggal)) }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td> &nbsp;{{ $salesOrder->customer->alamat->first()->alamat }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>



    <div class="margin-top">
        <table class="products">
            <tr style="border-bottom: solid gray 1px;">
                <th style="text-align: center">Koli</th>
                <th style="text-align: left">Nama Produk</th>
                <th style="text-align: center">Satuan</th>
                <th>Qty</th>
                <th style="text-align: right">Harga</th>
                <th style="text-align: right">SubTotal</th>
            </tr>
            @foreach ($groupedDetails as $koli => $details)
                @php
                    $rowCount = count($details);
                @endphp
                @foreach ($details as $index => $detail)
                    <tr class="items">
                        @if ($index == 0)
                            <td style="text-align: center;line-height:0;border:1px solid gray; font-weight: bold; font-size: 1.2em;"
                                rowspan="{{ $rowCount }}">(1 Koli) {{ $detail->produk }}</td>
                        @endif
                        <td style="text-align: left;">{{ $detail->product->nama_produk }}
                        </td>
                        <td style="text-align: center">{{ $detail->satuan }}</td>
                        <td style="text-align: center">{{ $detail->qty }}</td>
                        <td style="text-align: right">{{ number_format($detail->harga) }}</td>

                        <td style="text-align: right;border-right:1px solid gray;">
                            {{ number_format($detail->subtotal) }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </table>
    </div>

    <div class="total">

        <table class="tes">
            <tr style="border-bottom: 1px solid gray">
                <td style="width: 100px">Subtotal</td>
                <td style="padding-left:50px;">:</td>
                <td style="text-align: right;padding-left:50px;">{{ number_format($salesOrder->subtotal) }}</td>
            </tr>
            <tr>
                <td>Diskon</td>
                <td style="padding-left:50px;">:</td>
                <td style="text-align: right">{{ number_format($salesOrder->diskon) }}</td>
            </tr>
            <tr>
                <td>Ongkir</td>
                <td style="padding-left:50px;">:</td>
                <td style="text-align: right">{{ number_format($salesOrder->ongkir) }}</td>
            </tr>
            <tr>
                <td>Total</td>
                <td style="padding-left:50px;">:</td>
                <td style="text-align: right">{{ number_format($salesOrder->grand_total) }}</td>
            </tr>
        </table>

    </div>


    <div class="footer margin-top">
        <div style="width: 25%;float:left;margin:1px;height:300px;border:solid gray 1px;">
            <div style="height:30px;top:0;text-align:center">Yang Membuat</div>
            <div style="height:30px;padding-top:210px;text-align:center">{{ $salesOrder->user->first()->name }}</div>
        </div>
        <div style="width: 25%;float:left;margin:1px;height:300px;border:solid gray 1px;">
            <div style="height:30px;top:0;text-align:center">Yang Menyiapkan</div>
            <div style="height:30px;padding-top:210px;text-align:center">(------------------------------)</div>
        </div>
        <div style="width: 25%;float:left;margin:1px;height:300px;border:solid gray 1px;">
            <div style="height:30px;top:0;text-align:center">Yang Memeriksa</div>
            <div style="height:30px;padding-top:210px;text-align:center">(------------------------------)</div>
        </div>
        <div style="width: 25%;float:left;margin:1px;height:300px;border:solid gray 1px;">
            <div style="height:30px;top:0;text-align:center">Yang Mengirim</div>
            <div style="height:30px;padding-top:210px;text-align:center">(------------------------------)</div>
        </div>

    </div>
</body>

</html>
