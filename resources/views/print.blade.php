<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-section {
            text-align: left;
        }

        .right-section {
            text-align: right;
        }

        .invoice-details {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th,
        .invoice-details td {
            padding: 10px;
            border: 1px dotted #ddd;
            text-align: left;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="header-section">
            <div class="left-section">
                <h2>INVOICE PEMBELIAN</h2>
                <p>BEE ACCOUNTING</p>
                <p>KLAMPIS WAYA 291</p>
                <p>Tanggal: 07/03/2011</p>
                <p>Term: 1 30 Hari</p>
            </div>
            <div class="right-section">
                <p>Kepada Yth:</p>
                <p>VISION SUREES MAKMUR</p>
                <p>SURABAYA</p>
                <p>Telp: 1 Fax 1</p>
            </div>
        </div>
        <table class="invoice-details">
            <tr>
                <th>KODE</th>
                <th>NAMA BARANG</th>
                <th>BANYAKNYA</th>
                <th>HARGA</th>
                <th>SUBTOTAL</th>
            </tr>
            <!-- Item 1 -->
            <tr>
                <td>001001</td>
                <td>CH MET NE 1100 VISION</td>
                <td>25 PCS</td>
                <td>55,000</td>
                <td>875,000</td>
            </tr>
            <!-- Add more items here -->
        </table>
        <div class="total-section">
            <p>SubTotal: 3,723,300</p>
            <p>Lain-lain: Rp -</p>
            <p>Total: RP 2,668,883</p>
        </div>
    </div>
</body>

</html>
