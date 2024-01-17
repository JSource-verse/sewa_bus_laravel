@extends('logged.layouts.main', [
'nomor_admin' => $website_info->nomor_admin,
'sosial_media' => $website_info->sosial_media
])

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">
          Daftar Transaksi Sewa Bus
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
          <th>id</th>
          <th>Nama Penyewa</th>
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
            {{ $item->id }}
          </td>
          <td>
            {{ $item->user->name }}
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
                <div class="btn btn-danger trigger_button_delete" id="trigger">
                  Delete
                </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.7/js/dataTables.responsive.min.js"></script>
<!-- Other scripts -->

<script>
  $(document).ready(function() {
    var table = $('#example1').DataTable({
      responsive: {
        autoWidth: true,
        details: {
          display: DataTable.Responsive.display.modal({
            header: function(row) {
              var data = row.data();
              return 'Details for ' + data[2];
            }
          }),
          renderer: DataTable.Responsive.renderer.tableAll()
        }
      },
      columnDefs: [{
        targets: -1, // Target the last column
        data: null, // Use the entire row data
        render: function(data, type, row) {
          // Use the row data to create the content of the "Actions" column
          var id = row[1]
          return `<div style="display: flex; gap: 20px;">
           <a href="/admin/transaksi/edit/${id}"
          class="btn btn-warning" >Edit</a> 
          <form action="/admin/transaksi/delete/${id}"
          method="POST" id="form_delete_transaction">
            @method('POST')
            @csrf
            <div class = "btn btn-danger trigger_button_delete" rowId="${id}" id="trigger" >
            Delete </div> </form></div>`;
        }
      }]
    })

    table.column(1).visible(false)


    $(document).on('click', '.trigger_button_delete', function(e) {
      e.preventDefault()
      Swal.fire({
        title: "Anda Yakin ?",
        text: "Kamu Tidak Bisa Mengembalikan data yang terhapus !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: 'Batalkan'
      }).then((result) => {


        var form = $(this).closest('form#form_delete_transaction');
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });


  });
</script>

@if(Session::has('successDelete'))
<script>
  Swal.fire({
    title: "Deleted!",
    text: "Transaksi Berhasil Dihapus",
    icon: "success"
  });
</script>
@endif

@if(Session::has('successUpdate'))
<script>
  Swal.fire({
    title: "Update!",
    text: "Transaksi Berhasil Di Update",
    icon: "success"
  });
</script>
@endif

@endsection