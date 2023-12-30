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
  <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.admin.pengaturan.update')  }}">
    @method('POST')
    @csrf
    <div class="card-body">
      <label for="">
        File SOP yang aktif : {{ $website_info->sop }}
      </label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text" id="sop">Upload</span>
        </div>
        <div class="custom-file">
          <input type="file" name="sop" accept=".pdf" class="custom-file-input" id="input-pdf">
          <label class="custom-file-label" id="labelSOP" for="sop">Choose file</label>
        </div>
      </div>
      <div class="form-group">
        <label for="nomor_admin">Nomor Admin</label>
        <textarea name="nomor_admin" class="form-control" id="nomor_admin" placeholder="Tuliskan Nomor Admin" required>{{ implode(",\n", $website_info->nomor_admin) }}</textarea>
      </div>
      <div class="form-group d-flex flex-column">
        <label for="nomor_rekening">Nomor Rekening</label>
         <textarea name="nomor_rekening" class="form-control" id="nomor_rekening" placeholder="Tuliskan Nomor Rekening" required>{{ implode(",\n", $website_info->nomor_rekening) }}</textarea>
      </div>
      <div class="form-group d-flex flex-column">
        <label for="sosial_media">Sosial Media</label>
         <textarea name="sosial_media" class="form-control" id="sosial_media" placeholder="Tuliskan Sosial Media" required>{{ implode(",\n", $website_info->sosial_media) }}</textarea>
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
    $("#input-pdf").change(function(e) {
        e.preventDefault();

        var fileInput = $(this);
        var fileName = fileInput.val();
        
        // Check if the file has a valid extension
        if (!isValidPDF(fileName)) {
          fileInput.val('')
          Swal.fire({
            title: "Error",
            text: "SOP hanya support file berextensi PDF",
            icon: "error"
          });

          return;
        }

        $("#labelSOP").text(fileInput.val().split('\\').pop());
    });

    function isValidPDF(fileName) {
        // Get the file extension
        var fileExtension = fileName.split('.').pop().toLowerCase();
        
        // Check if the file has a PDF extension
        return fileExtension === "pdf";
    }
});

</script>

@if(Session::get('suksesEdit'))
<script>
  Swal.fire({
    title: "Sukses",
    text: "Update Website Berhasil",
    icon: "success"
  });
</script>
@endif

@endsection