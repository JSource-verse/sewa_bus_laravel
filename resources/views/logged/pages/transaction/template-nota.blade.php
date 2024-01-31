<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>
    {{ $title }}
  </title>
  <style>

    body {
      font-size: 14px;
    }

    .text-center {
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table td {
      text-align: start;
      padding: 5px 10px;
    }

  </style>
</head>
<body>
  <h1 class="text-center">
    PO. Lestari Alam Raya
  </h1>
  <p class="text-center" style="margin-top: -15px;">
    Jl. Baru lingkar utara km 02 purwodadi-grobogan
  </p>
  <hr>
  <table>
    <tr>
      <td>
        <table>
          <tr>
            <td>
            Tanggal Pemesanan 
          </td>
            <td>
              : {{ $date }}
            </td>
          </tr>
          <tr>
            <td>
            Telah Terima Dari
          </td>
            <td>
              : {{ $sewa->user->name }}
            </td>
          </tr>
          <tr>
            <td>
            No. Telp
          </td>
            <td>
              : {{ $sewa->user->no_hp }}
            </td>
          </tr>
        </table>
      </td>
      <td>
        <table>
          <tr>
            <td>Tanggal Pemesanan</td>
            <td>
              : {{ $sewa->created_at->format('d-m-Y') }}
            </td>
          </tr>
          <tr>
            <td>Durasi Sewa</td>
            <td>
              : {{ $sewa->durasi_sewa }} Hari
            </td>
          </tr>
          <tr>
            <td>Status Sewa</td>
            <td>
              : {{ $sewa->status === 'sudah disetujui' ? 'LUNAS' :  strtoupper( $sewa->status)}}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <h3>
   Informasi Sewa
  </h3>
  <table border="1">
     <thead>
        <tr>
          <th>Nama Bus</th>
          <th>Tipe</th>
          <th>
            Harga Sewa per Hari
          </th>
          <th>
            Tanggal Sewa
          </th>
          <th>Tujuan</th>
          <th>Penjemputan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ $sewa->bus->nama }}
          </td>
          <td>
            {{ $sewa->bus->tipe_bus }}
          </td>
          <td>
            Rp. {{ number_format($sewa->bus->harga, 0,0) }}
          </td>
          <td>
            {{ date('d-m-Y', strtotime($sewa->tanggal_checkin)) }} - {{ date('d-m-Y', strtotime($sewa->tanggal_checkout)) }}
          </td>
          <td>
            {{ $sewa->tujuan }}
          </td>
          <td>
            {{ $sewa->penjemputan }}
          </td>
        </tr>
        <tr>
          <td colspan="6"></td>
        </tr>
        <tr>
          <td colspan="4"></td>
          <td>
            Rp. {{ number_format($sewa->bus->harga, 0,0) }} x {{ $sewa->durasi_sewa }} Hari
          </td>
          <td>
             Rp. {{ number_format($sewa->total, 0,0) }}
          </td>
        </tr>
        <tr>
          <td colspan="4">
            Total Pembayaran
          </td>
          <td></td>
         <td>
           Rp. {{ number_format($sewa->total, 0,0) }}
          </td>
        </tr>
      </tbody>
  </table>

  <table style="text-align: right; margin-top: 20px;">
    <tr>
      <td></td>
      <td>
       Purwodadi, {{ $sewa->created_at->format('d-M-Y') }}
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
         <img src="{{ public_path('images/signature.png') }}" style="width: 100px; height: 100px;">
      </td>
    </tr>
    <tr>
      <td></td>
      <td>
        PO. Lestari Alam Raya
      </td>
    </tr>
  </table>

</body>
</html>