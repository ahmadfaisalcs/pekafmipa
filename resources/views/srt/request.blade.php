@extends('layouts.table.srtmaster')

@section('page-title')
  Daftar Permohonan
@endsection

@section('header-content')
  <section class="content-header">
    <h1>
      Daftar Permohonan
    </h1>
  </section>
@endsection

@section('data-content')
  <!-- Main content -->
  <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <!-- Table -->
          <div class="box">
            <div class="box-body table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr role="row">
                    <th>No.</th>
                    <th>Nomor Surat</th>
                    <th>Surat Permohonan</th>
                    <th>Pemohon</th>
                    <th>Tanggal Permohonan</th>
                    <th>Status Permohonan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($requests as $request)
                    <tr role="row" class="odd">
                        <td class="sorting_1">1</td>
                        <td>{{ $request->nomor_surat }}</td>
                        <td>{{ $request->kode_frm }} - {{ $request->jenis_frm }}</td>
                        <td>{{ $request->nim }}</td>
                        <td>{{ substr($request->changed_at,8,2)."/".substr($request->changed_at,5,2)."/".substr($request->changed_at,0,4) }}</td>
                        <td>
                          <span class="label label-warning">Belum Selesai</span>
                          <span class="label">
                            <i data-target="#gantistatus{{ $request->id }}" data-toggle="modal" class="fa fa-edit btn btn-primary" title="Edit status permohonan"></i>
                          </span>
                        </td>
                      </tr>
                  {{-- 2017-06-06 --}}
                    <!-- modal ganti status -->
                    <div class="modal fade" id="gantistatus{{ $request->id }}" tabindex="-1"  aria-labelledby="myModalLabel">
          						<div class="modal-dialog">
          							<div class="modal-content">
          								<form action="{{ route('srt_update') }}" method="post" enctype="multipart/form-data">
          									<div class="modal-header">
          										<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          										<h4 class="modal-title" id="myModalLabel">UBAH STATUS PERMOHONAN</h4>
                              <p>{{ $request->kode_frm }} - {{ $request->jenis_frm }}</p>
          									 </div>
          									<div class="modal-body">
          										<!-- Hidden input -->
          										<input type="hidden" name="_token" value="{{ csrf_token() }}">
          										<input type="hidden" name="id" value="{{ $request->id }}">
                              <input type="hidden" name="kode_frm" value="{{ $request->kode_frm }}">
          										<!-- End hidden input -->
                              <div class="form-group">
                                <label for="status" class="control-label">Permohonan Telah Selesai Diproses (telah diselesaikan oleh dekan/wadek) ?</label>
                                <div class="radio">
                                  <label class="col-sm-3 col-sm-offset-3">
                                    <input type="radio" name="status" id="status1" value="belum">
                                    Belum
                                  </label>
                                  <label>
                                    <input type="radio" name="status" id="status2" value="sudah">
                                    Sudah
                                  </label>
                                </div>
                              </div>
                              <!-- catatan tindak lanjut -->
          										<div class="form-group">
          										  <label for="followupnotes">Isi Catatan Tindak Lanjut <small>(jika permohonan telah selesai diproses)</small> :</label>
          											<textarea name="followupnotes" class="form-control" rows="2" placeholder=""></textarea>
          										</div>
                              <!-- keterangan -->
                              {{-- <div class="form-group">
                                <label for="srt_keterangan">Isi Keterangan <small>(jika permohonan telah selesai diproses)</small> :</label>
                                <textarea name="srt_keterangan" class="form-control" rows="2" placeholder=""></textarea>
                              </div> --}}
          									</div>
          									<div class="modal-footer">
          										<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
          										<button type="submit" class="btn btn-primary">Simpan</button>
          									</div>
          								</form>
          							</div>
          						</div>
          					</div>
                    <!-- /modal ganti status -->
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
@endsection
