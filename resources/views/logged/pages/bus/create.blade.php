@extends('logged.layouts.main')



@section('content')

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Buat Bus</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card card-primary">
  <!-- form start -->
  <form action="{{ route('dashboard.bus.store') }}" enctype="multipart/form-data" method="POST">
    @method('POST')
    @csrf
    <div class="card-body">
      <div class="form-group">
        <div id="image-preview"></div>
        <label for="imageInput">
          Gambar Bus
        </label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" name="photo" id="image-input" required>
            <label class="custom-file-label" for="imageInput">Choose file</label>
            @error('photo')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
          <div class="input-group-append">
            <span class="input-group-text">Upload</span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" id="nama"
          placeholder="Nama Bus">
        @error('nama')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-group">
        <label for="Tipe Bus">Tipe Bus</label>
        <input type="text" class="form-control @error('tipe_bus') is-invalid @enderror" id="Tipe Bus" name="tipe_bus"
          placeholder="Tipe Bus">
        @error('tipe_bus')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-group">
        <label for="Jumlah Kursi">Jumlah Kursi</label>
        <input type="number" class="form-control @error('jumlah_kursi') is-invalid @enderror" name="jumlah_kursi"
          id="Jumlah Kursi" placeholder="Jumlah Kursi">
        @error('jumlah_kursi')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="form-group">
        <label for="harga">Harga</label>
        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga"
          placeholder="Tipe Bus">
        @error('harga')
        <div class="invalid-feedback">
          {{ $message }}
        </div>
        @enderror
      </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
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
          $("#image-preview").html('<img src="' + e.target.result + '" alt="Preview" style="width: 200px;">');
        };

        // Baca URL gambar
        reader.readAsDataURL(input.files[0]);
      }
    }
  });
</script>

<script type="text/javascript">
  @if(Session::has('success'))
  Swal.fire({
    title: "Sukses",
    text: "Sukses Menambah Data Bus.",
    icon: "success",
    type: "success",
  });
  @endif
</script>

@endsection