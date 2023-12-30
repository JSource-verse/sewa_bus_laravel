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
          Daftar Transaksi Yang Batal
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
          <th>Nama Penyewa</th>
          <th>Nama Bus</th>
          <th>Keterangan</th>
          <th>
            Durasi Sewa
          </th>
          <th>
            Total Pembayaran
          </th>
          <th>
            Alasan Pembatalan
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
            {{ $item->user->name }}
          </td>
          <td>
            {{ $item->bus->nama }}
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
            {{ $item->alasan }}
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
              style="width: 150px;" alt="">
          </td>
          <td>
            <div style="display: flex; gap: 20px;">
              <a href="{{ route('dashboard.admin.transaction.edit', ['id' => $item->id]) }}" class="btn btn-warning">
                Edit
              </a>
              <form action="{{ route('dashboard.admin.transaction.delete', ['id' => $item->id]) }}" method="POST"
                id="form_delete_transaction">
                @method('POST')
                @csrf
                <a href="#" class="btn btn-danger trigger_button_delete">
                  Delete
                </a>
              </form>
            </div>
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

  $(document).ready(function() {
    $('.trigger_button_delete').click(function(e) {
      e.preventDefault()

      var form = $(this).closest('form#form_delete_transaction');
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    })

  })
</script>

@endsection