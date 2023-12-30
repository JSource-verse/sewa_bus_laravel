@extends('logged.layouts.main',  [
  'nomor_admin' => $website_info->nomor_admin,
  'sosial_media' => $website_info->sosial_media
])


@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Daftar Bus</h1>
        <a href="{{ route('dashboard.bus.create') }}" class="btn btn-primary mt-3">
          <i class="fas fa-plus mr-3"></i>
          Buat Bus Baru
        </a>
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
          <th>Nama</th>
          <th>Tipe</th>
          <th>Jumlah Kursi</th>
          <th>Harga/Hari</th>
          <th>Gambar</th>
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
            {{ $item->nama }}
          </td>
          <td>
            {{ $item->tipe_bus }}
          </td>
          <td>
            {{ $item->jumlah_kursi }}
          </td>
          <td>
            Rp. {{ number_format($item->harga, 0, ',', '.') }}
          </td>
          <td>
            <img src=" {{ url('/') . '/storage/' . ($item->photo) }}" class="img-responsive" style="width: 200px;"
              alt="">
          </td>
          <td>
            <div class="d-flex">
              <a href="{{ route('dashboard.bus.edit', ['id' => $item->id ])}}" class="btn btn-warning">
              Edit
            </a>
            <form action="{{ route('dashboard.bus.delete', ['id' => $item->id ]) }}" class="delete-form" method="POST">
              @method('DELETE')
              @csrf
              <a href="#" class="btn btn-danger ml-3 trigger_button_delete">
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
</script>

  @if(Session::has('successEdit'))
    <script>
      Swal.fire({
        title: "Sukses",
        text: "Sukses Edit Data Bus.",
        icon: "success",
        type: "success",
      });
    </script>
  @endif

<script type="text/javascript">

  $(document).ready(function() {
    $('.trigger_button_delete').click(function(e) {
      e.preventDefault()

      var form = $(this).closest('form.delete-form');
      Swal.fire({
        title: "Yakin Ingin Menghapus Bus",
        text: "Data transaksi bus ini akan ikut terhapus juga",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Lanjutkan",
        cancelButtonText: "Batal"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    })
  })
</script>

@if(Session::has('successDelete'))
  <script>
    Swal.fire({
      title: "Deleted!",
      text: "Bus Berhasil Di Hapus",
      icon: "success"
    });
  </script>
  @endif

@endsection