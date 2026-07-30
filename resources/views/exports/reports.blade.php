<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Laporan Insiden K3</title>
    <style>
        @page {
            size: A4;
            margin: 0; /* Remove browser default headers and footers */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            padding: 20mm; /* Padding inside the document to replace page margin */
            padding-top: 15mm;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            color: #CD171F; /* Cabot Red Dark */
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        
        /* Urgency Colors */
        .urgency-rendah { color: #059669; }
        .urgency-sedang { color: #D97706; }
        .urgency-tinggi { color: #EA580C; }
        .urgency-kritis { color: #DC2626; font-weight: bold; }
        
        /* Status Colors */
        .status-baru { color: #2563EB; }
        .status-ditinjau { color: #9333EA; }
        .status-proses { color: #D97706; }
        .status-selesai { color: #059669; }
        .status-ditolak { color: #DC2626; }
    </style>
</head>
<body>

    <!-- Web/PDF Header -->
    <table style="width: 100%; border: none; margin-bottom: 20px; font-size: 11px; color: #666;">
        <tr>
            <td style="width: 33%; text-align: left; border: none; padding: 0;">
                @if(function_exists('imagecreatefromstring'))
                    @php
                        $imagePath = public_path('img/cabot-logo.png');
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $src = 'data:image/png;base64,' . $imageData;
                    @endphp
                    <img src="{{ $src }}" alt="Logo Cabot" style="height: 35px;">
                @else
                    <h2 style="color: #CD171F; margin: 0; padding: 0;">CABOT</h2>
                @endif
            </td>
            <td style="width: 34%; text-align: center; border: none; padding: 0;">
                {{ now()->format('d/m/Y, H:i') }}
            </td>
            <td style="width: 33%; text-align: right; border: none; padding: 0;">
                Rekap Laporan Insiden K3
            </td>
        </tr>
    </table>

    <div class="header">
        <h2>REKAPITULASI LAPORAN INSIDEN K3</h2>
        <p>PT Cabot Indonesia | Tanggal Export: {{ now()->format('d F Y, H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">Tracking Code</th>
                <th width="15%">Jenis Kejadian</th>
                <th width="20%">Lokasi & Waktu</th>
                <th width="25%">Deskripsi Singkat</th>
                <th width="10%">Tingkat Urgensi</th>
                <th width="15%">Status Saat Ini</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $index => $report)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $report->tracking_code }}</strong></td>
                <td>{{ $report->incident_type_label }}</td>
                <td>
                    {{ $report->location }}<br>
                    <span style="color:#666; font-size:10px;">{{ $report->incident_date->format('d/m/Y') }} {{ $report->incident_time }}</span>
                </td>
                <td>{{ Str::limit($report->description, 100) }}</td>
                <td class="urgency-{{ $report->urgency }}">
                    {{ $report->urgency_label }}
                </td>
                <td class="status-{{ $report->status === 'dalam_penanganan' ? 'proses' : $report->status }}">
                    {{ $report->status_label }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
