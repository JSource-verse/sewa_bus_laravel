@extends('logged.layouts.main',  [
  'nomor_admin' => $website_info->nomor_admin,
  'sosial_media' => $website_info->sosial_media
])

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
          <th>Action</th>
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
            {{ $item->durasi_sewa }} hari
          </td>
          <td>
            {{ 'Rp. ' . number_format($item->total , 0,0)}}
          </td>
          <td>
            <div class="badge @if($item->status === 'menunggu persetujuan')
                  badge-info
              @elseif($item->status === 'sudah disetujui')
                  badge-success
              @else
                  badge-danger
              @endif
          ">
              {{ strtoupper($item->status) }}
            </div>
          </td>
          <td>
            <img src=" {{ url('/') . '/storage/' . ($item->bukti_pembayaran) }}" class="img-responsive"
              style="width: 200px;" alt="">
          </td>
          <td>
            <button type="button" class="btn btn-danger trigger_request_cancel" {{ $item->is_cancel === 0 || now() >= $item->tanggal_checkout ? '' : 'disabled' }}
              data-id="{{ $item->id }}">
             Batalkan Sewa
            </button>
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


    $('.trigger_request_cancel').click(function() {
      const id = $(this).data('id');

      Swal.fire({
        title: "Alert",
        text: "Anda Ingin Membatalkan Transaksi ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batalkan",
        confirmButtonText: "Ya, Lanjutkan",
        html: `<form id="form_cancel" method="POST" action="/booking/cancel/${id}">
        @csrf
       <div class="form-group">
        <label for="alasan">Alasan Pembatalan</label>
        <textarea type="text" class="form-control" id='alasan' name="alasan"
          placeholder="Tuliskan Alasan Pembatalan Mu Disini" required></textarea>
      </div>
        </form>`
      }).then((result) => {
        const alasan = $('#alasan').val()

        if (result.isConfirmed) {
          if (alasan === '') {
            Swal.fire({
              title: "Error",
              text: "Alasan Pembatalan Harus Diisi",
              icon: "error",
              type: "error",
            });

            return
          }
          $('#form_cancel').submit();
        }
      });
    })
  });
</script>

@if(Session::get('successCreate'))
<script>
  Swal.fire({
    title: "Success",
    text: "Transaksi Berhasil Dibuat. Tunggu Admin Mengkonfirmasi Transaksi Anda",
    icon: "success",
    type: "success",
  });
</script>
@endif

@if(Session::get('successCancel'))
<script>
  Swal.fire({
    title: "Success",
    text: "Permintaan Batal Transaksi Berhasil Tunggu Admin Menghubungi Anda",
    icon: "success",
    type: "success",
  });
</script>
@endif

@endsection