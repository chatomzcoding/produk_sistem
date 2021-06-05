<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Dokumen</title>
</head>
<body>
    <h2>"Percobaan Cetak Data dengan Dompdf terbaru v.0.9.0"</h2>
    <i>ini adalah garis miring</i>
    <table border="1" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan Kategori</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategori as $item)
            <tr>
                <td>{{ $item->id}}</td>
                <td>{{ $item->nama_kategori}}</td>
                <td>{{ $item->keterangan}}</td>
                <td>{{ $item->status}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>