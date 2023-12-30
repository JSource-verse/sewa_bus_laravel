@extends('logged.layouts.main', [
  'nomor_admin' => $website_info->nomor_admin,
  'sosial_media' => $website_info->sosial_media
])


@section('content')
@if(Auth::user()->role === 'admin')
<style>
  .active-filter {
    background-color: gray;
  }
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
  <h1 class="m-0" id="db">Dashboard</h1>
</div>
<!-- /.content-header -->
<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3>
              {{ $transactions }}
            </h3>

            <p>Total Transaksi</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
              {{ $pendingTransactions }}
            </h3>

            <p>Transaksi Menunggu Persetujuan</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>
              {{ $users }}
            </h3>

            <p>Total User</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>
              {{
              $cancelTransaction }}
            </h3>

            <p>
              Permintaan Pembatalan Sewa
            </p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
        </div>
      </div>
      <!-- ./col -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
  <div class="d-flex align-items-center justify-content-between" style="margin-right: 50px;">
  <div></div>
    <h4 id="chart_title">
    </h4>
    <div class="dropdown">
      <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        Filter
      </button>
      <div class="dropdown-menu">
        <button class="dropdown-item" href="#">Perbulan Tahun Ini</button>
        <div class="p-3">
          <div class="form-group">
            <label for="tahun">Tahun</label>
            <input type="number" class="form-control" id="tahun">
          </div>
          <button class="btn btn-primary" id="year-filter-trigger">Cek</button>
        </div>
      </div>
    </div>
    
  </div>
  <div>
    <canvas id="line-chart" width="100%" height="500px"></canvas>
  </div>
  <h4 class="mt-5">
    Daftar Sewa Semua Bus
  </h4>
  <table class="table mt-3">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama Bus</th>
      <th scope="col">Total Sewa</th>
    </tr>
  </thead>
  <tbody>
    @foreach($popularBuses as $key => $item)
    <tr>
      <td>
        {{ $key + 1 }}
      </td>
      <td>
        {{ $item->bus->nama }}
      </td>
      <td>
        {{ $item->total_sewa }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</section>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const bulanArray = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];


   var currentYear = new Date().getFullYear();
   $('#tahun').val(currentYear)

    

    $(document).ready(function(){
      $('#year-filter-trigger').click()
    })

  
    $('#year-filter-trigger').click(function(){
      var year = $('#tahun').val()
      $('#chart_title').text(`Total Transaksi dan Total Batal Transaksi Dalam Setiap Bulan Tahun ${year}`)
      $.ajax({
        url: '{{ route('getChartData') }}',
        method: 'GET',
        dataType: 'json',
        data: {
          tahun: parseInt($('#tahun').val())
        },
        success: function(data){
            new Chart(document.getElementById("line-chart"), {
              type: 'line',
              data: {
                labels: bulanArray,
                datasets: [
                  {
                  data: data.totalTransactionInMonth,
                  label: "Jumlah Transaksi Selesai",
                  borderColor: "#3cba9f",
                  fill: false
                },
                {
                  data: data.totalCancelTransactionInMonth,
                  label: "Jumlah Transaksi Batal",
                  borderColor: "#000",
                  fill: false
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                  legend:{
                    position: 'top'
                  },
                  title: {
                    display: true,
                    text: `Total Transaksi dan Total Batal Transaksi Dalam Setiap Bulan Tahun ${currentYear}`
                  }
                }
              }
            });
        },
        error: function (error) {
          console.log(error);
        }
      })
    })
</script>
@else
<div class="content-header">
  <h1 class="m-0">Selamat Datang Kembali, {{ Auth::user()->name }}</h1>
</div>

<h1>
  Daftar Bus
</h1>

<div class="d-flex flex-wrap" style="gap: 20px;">
  @foreach($buses as $item)
  <div class="card" style="width: 18rem;" >
    <img class="card-img-top" src="{{ asset('storage/' . $item->photo) }}" alt="Card image cap">
    <div class="d-flex flex-column p-3">
      <h5 class="card-title" style="font-weight: 700;">
        {{ $item->nama }}
      </h5>
      <p style="margin-top: 20px;">
        Rp. {{ number_format($item->harga, 0, ',', '.') }}/Hari
      </p>
      <p>
        {{ $item->jumlah_kursi }} Seat
      </p>
      <p>
        Tipe Bus : {{ $item->tipe_bus }}
      </p>
      <a href="{{ route('dashboard.booking.index', ['busid' => $item->id ]) }}" class="btn btn-primary">
        Sewa
      </a>
    </div>
  </div>
  @endforeach
</div>



@endif

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




<script type="text/javascript">
  $(document).ready(function() {
    $(document).on('click', '#db', function(event) {

      event.preventDefault();
      swal({
        title: "Are you sure you want to delete this record?",
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        type: "warning",
        buttons: ["Cancel", "Yes!"],
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      })
    });
  });
</script>
@endsection