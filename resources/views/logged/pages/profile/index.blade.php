@extends('logged.layouts.main',  [
  'nomor_admin' => $website_info->nomor_admin,
  'sosial_media' => $website_info->sosial_media
])


@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Profile</h1>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>

<div class="card card-primary">
  <div class="card-header">
    <h3 class="card-title">Profile</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.user.profile.update') }}">
    @method('POST')
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="name" placeholder="Enter Name"
          required>
      </div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" class="form-control" value="{{ $user->email }}" id="email"
          placeholder="Enter email" required>
      </div>
      <div class="form-group">
        <label for="no_hp">Nomor Whatsappp</label>
        <input type="no_hp" name="no_hp" class="form-control" value="{{ $user->no_hp }}" id="no_hp" placeholder="No Hp"
          required>
      </div>
      <div class="form-group d-flex flex-column">
        <label for="ktp">KTP</label>
        @if($user->ktp_image)
        <img src="{{ asset('storage/' . $user->ktp_image) }}" style="width: 200px;" alt="" id="ktp_user">
        @endif
        <div id="image-preview"></div>
        <div class="input-group mt-3">
          <div class="custom-file">
            <input type="file" name="ktp_image" required class="custom-file-input" id="image-input">
            <label class="custom-file-label" for="ktp">Choose file</label>
          </div>
          <div class="input-group-append">
            <span class="input-group-text">Upload</span>
          </div>
        </div>
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
    $("#image-input").change(function() {
      readURL(this);
    });

  })

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        // Tampilkan gambar preview
        $("#image-preview").html('<img src="' + e.target.result + '" alt="Preview" style="width: 200px;">');
        $('#ktp_user').hide()
      };

      // Baca URL gambar
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>

@if(Session::has('error'))
<script>
  Swal.fire({
    title: "Erorr!",
    text: "Data Kamu Belum Lengkap! Upload KTP dahulu sebelum melakukan pemesanan bus",
    icon: "error"
  });
</script>
@endif

@if(Session::get('updateSuccess'))
<script>
  Swal.fire({
    title: "Success",
    text: "Update Profile Berhasil",
    icon: "success"
  });
</script>
@endif
@endsection