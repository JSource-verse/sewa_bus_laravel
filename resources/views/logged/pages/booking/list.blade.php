@extends('logged.layouts.main')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          Daftar Sewa Bus
        </h1>
      </div>
      <!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card">
  <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Bus</th>
          <th>Tipe</th>
          <th>
            Harga Sewa Bus/Hari
          </th>
          <th>Tanggal Awal Sewa</th>
          <th>Tanggal Akhir Sewa</th>
          <th>Tujuan</th>
          <th>Penjemputan</th>
          <th>Keterangan</th>
          <th>
            Durasi Sewa
          </th>
          <th>
            Total Pembayaran
          </th>
          <th>Status</th>

          <th>Bukti Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $key => $item)
        <tr>
          <td>
            {{ $key + 1 }}
          </td>
          <td>
            {{ $item->bus->nama }}
          </td>
          <td>
            {{ $item->bus->tipe_bus }}
          </td>
          <td>
            {{ 'Rp. ' . number_format($item->bus->harga, 0,0) }}
          </td>
          <td>
            {{ $item->tanggal_checkin }}
          </td>
          <td>
            {{ $item->tanggal_checkout }}
          </td>
          <td>
            {{ $item->tujuan }}
          </td>
          <td>
            {{ $item->penjemputan }}

          </td>
          <td>
            {{ $item->keterangan }}
          </td>
          <td>
            {{ $item->durasi_sewa }}
          </td>
          <td>
            {{ 'Rp. ' . number_format($item->total , 0,0)}}
          </td>
          <td>
            <div class="badge {{ $item->status === 'menunggu persetujuan' ? 'badge-info' : 'badge-success' }}">
             {{ strtoupper($item->status) }}
           </div>
          </td>


          <td>
            <img src=" {{ url('/') . '/storage/' . ($item->bukti_pembayaran) }}" class="img-responsive"
              style="width: 200px;" alt="">
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
  <!-- /.card-body -->
</div>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "lengthChange": false,
      "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

  @if(Session::get('successCreate'))
  Swal.fire({
    title: "Success",
    text: "Transaksi Berhasil Dibuat. Tunggu Admin Mengkonfirmasi Transaksi Anda",
    icon: "success",
    type: "success",
  });
  @endif

</script>

@endsection