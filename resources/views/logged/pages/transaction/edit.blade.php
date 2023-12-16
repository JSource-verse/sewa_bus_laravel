@extends('logged.layouts.main')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">
        Detail Transaksi
      </h1>
    </div>
    <!-- /.col -->
  </div><!-- /.row -->
</div><!-- /.container-fluid -->
</div>

<form action="{{ route('dashboard.admin.transaction.update', ['id' => $data->id]) }}" method="POST">
  @method('POST')
  @csrf
  <div class="row px-5">
    <div class="col-md-6">
      <div class="row">
        <div class="col-md-6">
          <div class="d-flex flex-column">
            <label for="Nama Penyewa">
              Foto KTP
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->user->name }}" id="Nama Penyewa">
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex flex-column">
            <label for="Bukti Pembayaran">
              Bukti Transfer
            </label>
            <img src="{{ asset('storage/' . $data->bukti_pembayaran) }}" width="200" alt="">
          </div>
        </div>
      </div>
      <div class="form-group">
        <label for="Nama Penyewa">
          Nama Penyewa
        </label>
        <input type="text" readonly class="form-control" value="{{ $data->user->name }}" id="Nama Penyewa">
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="tanggal checkin">
              Tanggal Awal Sewa
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->tanggal_checkin }}" id="tanggal_checkin">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="tanggal checkout">
              Tanggal Akhir
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->tanggal_checkout }}"
              id="tanggal_checkout">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="durasi sewa">
              Durasi Sewa
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->durasi_sewa . ' hari' }}"
              id="durasi_sewa">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="tujuan">
              Tujuan
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->tujuan }}" id="tujuan">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="penjemputan">
              Penjemputan
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->penjemputan }}" id="penjemputan">
          </div>
        </div>
        <button class="btn btn-warning" type="submit">
          Proses Edit Status
        </button>
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label for="penjemputan">
          Nama Bus
        </label>
        <input type="text" readonly class="form-control" value="{{ $data->bus->nama }}" id="penjemputan">
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="jumlah_kursi">
              Jumlah Kursi
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->bus->jumlah_kursi }}" id="jumlah_kursi">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="tipe_bus">
              Tipe Bus
            </label>
            <input type="text" readonly class="form-control" value="{{ $data->bus->tipe_bus }}" id="tipe_bus">
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="harga_bus">
              Harga Bus/Hari
            </label>
            <input type="text" readonly class="form-control" value="{{ 'Rp. ' .number_format($data->bus->harga,0,0) }}"
              id="harga_bus">
          </div>
        </div>
      </div>
      <hr />
      <div class="form-group">
        <label for="keterangan">
          Keterangan Sewa
        </label>
        <textarea type="text" readonly class="form-control" id="keterangan">{{ $data->keterangan }}</textarea>
      </div>
      <div class="form-group">
        <label for="keterangan">
          Status
        </label>
        <select type="text" name="status" class="form-control" id="keterangan">
          <option value="{{ $data->status }}">
            {{ Str::title($data->status) }}
          </option>
          <option value="sudah disetujui">
            Sudah Disetujui
          </option>
          <option value="menunggu persetujuan">
            Menunggu Persetujuan
          </option>
        </select>
      </div>
      <div class="form-group">
        <label for="total">
          Total
        </label>
        <input type="text" readonly class="form-control" value="{{ 'Rp. ' . number_format($data->total, 0,0) }}"
          id="total">
      </div>

    </div>
  </div>

</form>

@endsection