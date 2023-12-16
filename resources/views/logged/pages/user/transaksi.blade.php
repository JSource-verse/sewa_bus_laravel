@extends('logged.layouts.main')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Hello, {{ Auth::user()->name }}</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard </li>
        </ol>
      </div><!-- /.col -->
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
          <th>Tanggal Checkin</th>
          <th>Tanggal Checkout</th>
          <th>Durasi Sewa ( Hari )</th>
          <th>Tujuan</th>
          <th>Unit Bus</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transactions as $item)
        <tr>
          <td>1</td>
          <td>
            {{ $item->user->name }}
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
            <a href="{{ route('dashboard.bus.edit', ['id' => $item->id ])}}" class="btn btn-warning">
              Edit
            </a>
          </td>
          <td>
            <form action="{{ route('dashboard.bus.delete', ['id' => $item->id ]) }}" method="POST">
              @csrf
              <button href="#" class="btn btn-danger ml-3">
                Delete
              </button>
            </form>
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
@endsection