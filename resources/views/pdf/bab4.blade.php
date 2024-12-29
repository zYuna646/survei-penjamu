<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BAB IV - Laporan Survei </title>
    <style>
        @page {
            margin-top: 2cm;
            margin-bottom: 2cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            margin: 0;
        }

        * {
            font-size: 12;
        }

        .heading-1 {
            text-align: center;
        }

        .heading-2 {
            margin-bottom: 0;
        }

        .kop {
            border-bottom: 1px solid black;
        }

        .audit-detail {
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .audit-detail th,
        .audit-detail td {
            text-align: left;
            vertical-align: top;
        }

        .audit-detail th {
            padding-right: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 8px;
        }

        .table th {
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: left;
            vertical-align: top;
        }

        .paragraf {
            text-align: justify;
            text-indent: 25px;
            line-height: 2em;
        }

        .number-list {
            list-style-type: decimal;
            margin-left: 25px;
            padding: 0px;
            line-height: 2em;
        }

        .number-list li {
            text-align: justify;
        }

        .ttd {
            width: 100%;
        }

        .ttd td {
            width: 33.33%;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h5 class="heading-1">
        BAB II <br> <br>
        KESIMPULAN DAN TINDAK LANJUT
    </h5>
    <p class="paragraf">
        Berdasarkan analisis hasil pengukuran indeks kepuasan tenaga kependidikan pada periode XXX masuk ke dalam
        kategori mutu layanan XXX artinya kinerja pelayanan masuk ke dalam kategori BAIK.
        Selanjutnya, urutan indeks kepuasan mahasiswa untuk setiap butir/aitem pernyataan disajikan pada tabel di bawah
        ini:
    </p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Aitem Pernyataan</th>
                <th>Indeks</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($survei->aspek as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $detail_rekapitulasi_aspek[$item->id]['ikm'] }}</td>
                <td>{{ $detail_rekapitulasi_aspek[$item->id]['kinerja_unit'] }}</td>
            </tr>
            @endforeach --}}
        </tbody>
    </table>
    <p class="paragraf">
        Dapat diamati dari tabel di atas, lima (5) aitem atau butir pernyataan yang memiliki nilai yang paling rendah yaitu:
    </p>
    <ol>
        <li>sample</li>
    </ol>
    <p class="paragraf">
        Faktor-faktor atau akar permasalahan yang menyebabkan indeks kepuasan mahasiswa masih rendah yaitu:
    </p>
    <ol>
        <li>sample</li>
    </ol>
    <p class="paragraf">
        Rencana tindak lanjutnya yaitu
    </p>
    <ol>
        <li>sample</li>
    </ol>
    
</body>

</html>
