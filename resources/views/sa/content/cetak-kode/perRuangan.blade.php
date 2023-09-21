<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

    <style>
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .card {
            width: 150px;
            /* Adjust the card width to accommodate the QR code size */
            border: 1px solid #ccc;
            padding: 10px;
        }

        .card-content {
            text-align: center;
            padding-bottom: 1px;
        }

        p {
            font-size: 15px;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>

<body>
    <div class="cards-container">
        <div class="card">
            <div class="card-content">
                {!! QrCode::size(150)->generate(route('ruangan.info', ['id_ruangan' => $ruangan->id_ruangan])) !!}
                <p><b>Ruangan {{ $ruangan->nama_ruangan }}</b></p>
            </div>
        </div>
    </div>

    <script>
        window.onload = function() {
            // konfigurasi html2pdf.js
            const options = {
                margin: 10,
                filename: 'QRCode_PerRuangan.pdf',
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