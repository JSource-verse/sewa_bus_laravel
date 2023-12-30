@extends('logged.layouts.main',  [
  'nomor_admin' => $website_info->nomor_admin,
  'sosial_media' => $website_info->sosial_media
])


@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Bus</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card card-primary">
  <!-- /.card-header -->
  <!-- form start -->
  <form action="{{ route('dashboard.bus.update', ['id' => $bus->id]) }}" enctype="multipart/form-data" method="POST">
    @method('POST')
    @csrf
    <div class="card-body">
      <div class="d-flex flex-column">
        <label for="nama">Gambar Bus</label>
        <img src="{{ asset('storage/'. $bus->photo) }}" id="showOldBusImage" class="img-thumbnail" style="width: 200px;"
          name="photo">
      </div>
      <div id="image-preview"></div>
      <div class="form-group">
        <label for="inputImage">File input</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="photo" id="image-input">
            <label class="custom-file-label" for="inputImage">Choose file</label>
          </div>
          <div class="input-group-append">
            <span class="input-group-text">Upload</span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control" value="{{ $bus->nama }}" name="nama" id="nama" placeholder="Nama Bus">
      </div>
      <div class="form-group">
        <label for="tipeBus">Tipe Bus</label>
        <input type="text" class="form-control" value="{{ $bus->tipe_bus }}" name="tipe_bus" id="tipeBus"
          placeholder="Tipe Bus">
      </div>
      <div class="form-group">
        <label for="jumlahKursi">Jumlah Kursi</label>
        <input type="text" class="form-control" id="jumlahKursi" value="{{ $bus->jumlah_kursi }}" name="jumlah_kursi"
          placeholder="Jumlah Kursi">
      </div>
      <div class="form-group">
        <label for="harga">Harga/Hari</label>
        <input type="number" class="form-control" name="harga" value="{{ $bus->harga }}" id="harga" placeholder="Harga">
      </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Proses Edit Bus</button>
    </div>
  </form>
</div>

<script src="{{ asset('lte/plugins/jquery/jquery.min.js')}}"></script>
<script>
  $(document).ready(function() {
    // Ketika pengguna memilih gambar
    $("#image-input").change(function() {
      readURL(this);
    });

    // Fungsi untuk membaca URL gambar dan menampilkannya
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          // Tampilkan gambar preview
          $('#showOldBusImage').hide();
          $("#image-preview").html('<img src="' + e.target.result + '" alt="Preview" style="width: 200px;">');
        };


        // Baca URL gambar
        reader.readAsDataURL(input.files[0]);
      }
    }
  });
</script>

@endsection