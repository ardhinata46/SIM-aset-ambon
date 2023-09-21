<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add reference to html2pdf.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            /* Adjust the gap between cards as needed */
        }

        .card {
            width: 60px;
            /* Set the width to match the QR code size */
            border: 1px solid #ccc;
            padding: 10px;
        }

        .card-content {
            text-align: center;
            padding-bottom: 1px;
        }

        p {
            font-size: 7px;
        }
    </style>
</head>

<body>
    <div class="cards-container">
        <div class="card">
            <div class="card-content">
                {!! QrCode::size(60)->generate(route('barang.info', ['id_item_barang' => $itemBarang->id_item_barang])) !!}
                <p>{{ $itemBarang->nama_item_barang }}</p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // konfigurasi html2pdf.js
            const options = {
                margin: 10,
                filename: 'QRCode_Satuan_item_barang.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'portrait'
                }
            };

            // Konversi HTML menjadi PDF
            html2pdf().from(document.documentElement).set(options).save();
        };
    </script>
</body>

</html>