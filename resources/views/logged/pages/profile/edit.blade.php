@extends('logged.layouts.main')


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
    <h3 class="card-title">Profile Data</h3>
  </div>
  <!-- /.card-header -->
  <!-- form start -->
  <form>
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" value="{{ $user->email }}" id="exampleInputEmail1"
          placeholder="Enter email">
      </div>
      <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <div class="input-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="exampleInputFile">
            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
@endsection