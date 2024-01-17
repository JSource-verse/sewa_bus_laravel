@extends('logged.layouts.main', [
'nomor_admin' => $website_info->nomor_admin,
'sosial_media' => $website_info->sosial_media
])


@section('content')

@if($website_info->sop)
<h4>
  Ketentuan Penyewaan Bus
</h4>
<object data="{{ asset('storage/' . $website_info->sop) }}" type="application/pdf" width="100%" height="600px"
  style="border: none;">
  <p>Unable to display PDF file. <a target="_blank" href="{{ asset('storage/' . $website_info->sop) }}">Download</a>
    instead.</p>
</object>
@endif
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Form Sewa Bus</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card">
  <div class="card-body" style="gap: 20px;">
    <div class="alert alert-danger" role="alert" id="error-message"></div>
    <form action="{{ route('dashboard.booking.check') }}" method="POST">
      @method('POST')
      @csrf
      <div class="form-group">
        <input type="hidden" name="bus_id" value="{{ $bus->id }}" readonly>
        <label for="checkin">Tanggal Awal Sewa</label>
        <input type="date" class="form-control" name="checkin" value="{{ old('checkin') }}" id="checkin"
          placeholder="Enter email">

      </div>
      <div class="form-group">
        <label for="checkout">Tanggal Akhir Sewa</label>
        <input type="date" class="form-control" value="{{ old('checkout') }}" name="checkout" id="checkout"
          placeholder="Enter email">
      </div>
      <div class="form-group" id="jumlah_hari_wrapper">
        <label for="checkout">Jumlah Hari</label>
        <input type="text" class="form-control" id="jumlah_hari" value="{{ old('jumlah_hari') }}" readonly
          name="jumlah_hari">
      </div>
      <button type="submit" class="btn btn-primary" id="btnCheckSchedule">
        Check
      </button>
    </form>
  </div>

</div>

<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Info Bus</h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="form-group">
      <label for="exampleInputEmail1">Nama Bus</label>
      <input type="text" value="{{ $bus->nama }}" readonly class="form-control" id="exampleInputEmail1"
        placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Tipe Bus</label>
      <input type="text" value="{{ $bus->tipe_bus }}" readonly class="form-control" id="exampleInputEmail1"
        placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Jumlah Kursi</label>
      <input type="text" value="{{ $bus->jumlah_kursi }}" readonly class="form-control" id="exampleInputEmail1"
        placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Harga</label>
      <input type="text" value="{{ 'Rp. ' . number_format($bus->harga, 0, ',', '.') }}/Hari" readonly
        class="form-control" id="exampleInputEmail1" placeholder="Enter email">
    </div>
  </div>
</div>

@if(Session::get('busAvailable'))
<h4 style="margin-bottom: 20px;">
  Daftar Nomor Rekening Perusahaan
</h4>
<div class="d-flex flex-wrap" style="gap: 20px;">
  @foreach($website_info->nomor_rekening as $item)
  @php
  list($nama, $nomor_rekening, $nama_bank) = explode(' ', $item, 3);
  @endphp
  <div class="card" style="width: 18rem;">
    <div class="card-body d-flex flex-column">
      <h5 class="card-title font-weight-bold">
        {{ $nama_bank }}
      </h5>
      <p class="card-text">
        {{ $nama }} - {{ $nomor_rekening }}
      </p>
    </div>
  </div>
  @endforeach
</div>
<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Form Penyewaan</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form id="formSewa" action="{{ route('dashboard.booking.create') }}" enctype="multipart/form-data" method="POST">
    @method('POST')
    @csrf
    <input type="hidden" name="tanggal_checkin" value="{{ session('tanggal_checkin') }}">
    <input type="hidden" name="tanggal_checkout" value="{{ session('tanggal_checkout') }}">
    <input type="hidden" name="bus_id" value="{{ $bus->id }}">
    <input type="hidden" name="durasi_sewa" id="durasi_sewa">
    <div class="card-body">
      <div class="form-group">
        <label for="nama">Nama Penyewa</label>
        <input type="text" class="form-control" value="{{ $user->name }}" name="nama_penyewa" id="nama"
          placeholder="Nama Penyewa" required readonly>
      </div>
      <div class="form-group">
        <label for="alamat">Tujuan</label>
        <input type="text" class="form-control" name="tujuan" id="tujuan" placeholder="Tuliskan Alamat Tujuan" required>
      </div>
      <div class="form-group">
        <label for="nama">Penjemputan</label>
        <input type="text" class="form-control" name="penjemputan" id="penjemputan"
          placeholder="Tuliskan Alamat Penjemputan" required>
      </div>
      <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <textarea class="form-control" name="keterangan" id="keterangan"
          placeholder="Tuliskan Keterangan Lebih Lanjut Terkait Penyewaan Anda" required></textarea>
      </div>
      <div class="form-group">
        <label for="keterangan">Total Pembayaran</label>
        <input readonly class="form-control" value="{{ 'Rp. ' . number_format(session('harga'), 0, ',', '.') }}"
          id="total_pembayaran" required>
        <input type="hidden" value="{{ session('harga') }}" readonly class="form-control" name="total"
          id="total_pembayaran_real">
      </div>
      <div class="form-group">
        <div id="image-preview"></div>
        <label for="bukti_pembayaran">Bukti Pembayaran</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="bukti_pembayaran" id="image-input" required>
            <label class="custom-file-label" for="bukti_pembayaran">Choose file</label>
          </div>
          <div class="input-group-append">
            <span class="input-group-text">Upload</span>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <a href="#" id="trigger_form_sewa" class="btn btn-primary">Proses Sewa</a>
    </div>
  </form>
</div>
@endif

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>

@if(Session::get('busAvailable') === true)
<script>
  $('#jumlah_hari_wrapper').show()
  $('#checkin').attr('readonly', '')
  $('#checkout').attr('readonly', '')
  $('#durasi_sewa').val($('#jumlah_hari').val())
</script>
@else
<script>
  $('#jumlah_hari_wrapper').hide()
  $('#btnCheckSchedule').attr('disabled', false)
</script>
@endif

<script>
  $(document).ready(function() {

    $('#error-message').hide()


    $('#btnCheckSchedule').attr('disabled', true)

    $("#checkin, #checkout").change(function() {
      validateDates();
    });

    $("#submitBtn").click(function() {
      validateDates();
    });


    $("#image-input").change(function() {
      readURL(this);
    });


    $('#trigger_form_sewa').click(function(e) {
      e.preventDefault();

      var form = $('#formSewa');

      var tujuan = $("#tujuan").val();
      if (tujuan === '') {
        Swal.fire({
          title: "Error!",
          text: "Tujuan Tidak Boleh Kosong",
          icon: "error",
        });
        return; // Hentikan proses lebih lanjut jika validasi gagal
      }

      // Validasi tujuan_penjemputan
      var tujuanPenjemputan = $("#penjemputan").val();
      if (tujuanPenjemputan === '') {
        Swal.fire({
          title: "Error!",
          text: "Penjemputan Tidak Boleh Kosong",
          icon: "error",
        });
        return; // Hentikan proses lebih lanjut jika validasi gagal
      }

      // Validasi keterangan
      var keterangan = $("#keterangan").val();
      if (keterangan.length < 10) {
        Swal.fire({
          title: "Error!",
          text: "Keterangan harus minimal 10 karakter",
          icon: "error",
        });
        return; // Hentikan proses lebih lanjut jika validasi gagal
      }

      // Validasi bukti_pembayaran
      var buktiPembayaran = $(".custom-file-input").val();
      if (!buktiPembayaran) {
        Swal.fire({
          title: "Error!",
          text: "Pilih file bukti pembayaran",
          icon: "error",
        });
        return; // Hentikan proses lebih lanjut jika validasi gagal
      }

      // Jika semua validasi berhasil, tampilkan konfirmasi SweetAlert
      Swal.fire({
        title: "Data Yang Dimasukan Sudah Benar?",
        text: "Kamu Tidak Bisa Merubah Data Jika Sudah Submit Form",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Batalkan",
        confirmButtonText: "Sudah Benar"
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });



  });

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        // Tampilkan gambar preview
        $("#image-preview").html('<img src="' + e.target.result + '" alt="Preview" style="width: 200px;">');
      };

      // Baca URL gambar
      reader.readAsDataURL(input.files[0]);
    }
  }

  function validateDates() {
    $('#error-message').show()
    var checkinDate = $("#checkin").val();
    var checkoutDate = $("#checkout").val();

    // Validasi tanggal di sisi klien
    if (checkinDate === "" || checkoutDate === "") {
      $("#error-message").text("Tanggal check-in dan check-out wajib diisi.");
      $('#btnCheckSchedule').attr('disabled', true)
    } else if (new Date(checkinDate) >= new Date(checkoutDate)) {
      $("#error-message").text("Tanggal check-out harus lebih besar dari tanggal check-in.");
    } else if (new Date(checkinDate) <= new Date().setHours(0, 0, 0, 0)) {
      $("#error-message").text("Tanggal check-in harus lebih lama dari hari ini.");
    } else {
      $("#error-message").text("");
      $('#error-message').hide()
      var daysDifference = dateDiffInDays(new Date(checkinDate), new Date(checkoutDate));
      $('#jumlah_hari_wrapper').show()
      $('#jumlah_hari').val(daysDifference)
      $('#btnCheckSchedule').attr('disabled', false)
      $('#total_pembayaran').val('Rp. ' + daysDifference * $('#harga_real').val())

    }
  }

  function dateDiffInDays(a, b) {
    const timeDifference = b.getTime() - a.getTime();
    const daysDifference = timeDifference / (1000 * 3600 * 24);
    return Math.floor(daysDifference);
  }
</script>

@if(Session::has('busAvailable'))
@if(Session::get('busAvailable') === false)
<script type="text/javascript">
  Swal.fire({
    title: "Gagal",
    text: "Sudah Ada yang Booking Di tanggal tersebut",
    icon: "error",
    type: "error",
  });
</script>
@else
<script>
  Swal.fire({
    title: "Sukses",
    text: "Bus Yang Kamu Pilih Tersedia di tanggal tersebut",
    icon: "success",
    type: "success",
  });
</script>
@endif
@endif

@endsection