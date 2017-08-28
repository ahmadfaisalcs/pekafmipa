@extends('layouts.mahasiswa.master')

@section('page-title')
  Status Permohonan
@endsection

@section('header-content')
  <section class="content-header">
    @if ($isexist)
      <h1>
        Status Permohonan
      </h1>
    @endif
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <!-- TABLE: LATEST ORDERS -->
      <div class="col-md-12">
        @if ($isexist)
          <div class="box">

            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    {{-- <th style="width: 1px"></th> --}}
                    <th>No</th>
                    <th>Surat Permohonan</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Tanggal Permohonan</th>
                    <th>Pilihan</th>
                  </tr>
                  @foreach($requests as $request)
                    <tr>
                      {{-- <td>
					  	<input type="checkbox" name="checkbox[]" id="{{ $request->kode_frm}}" value="{{ $request->id }}">
					  </td> --}}
                      <td>{{ $count++ }}</td>
                      <td>{{ $request->kode_frm }} - {{ $request->jenis_frm }}</td>
                      {{--
                      status 1 = berhasil diupload
                      status 2 = pengecekan kelengkapan berkas
                      status 3 = proses penyelesaian surat
                      status 4 = telah selesai
                      --}}
                      <td>
                        @if($request->status == "Berhasil diupload")
                          <span class="label label-warning">01 - {{ $request->status }}</span>
                        @endif
                        @if($request->status == "Pengecekan kelengkapan berkas")
                          <span class="label label-danger">02 - {{ $request->status }}</span>
                        @endif
                        @if($request->status == "Proses penyelesaian surat")
                          <span class="label label-info">03 - {{ $request->status }}</span>
                        @endif
                        @if($request->status == "Telah selesai")
                          <span class="label label-success">04 - {{ $request->status }}</span>
                        @endif
                      </td>
                      <td>{{ $request->information->adm_keterangan }}</td>
                      <td>{{ substr($request->changed_at,8,2)."/".substr($request->changed_at,5,2)."/".substr($request->changed_at,0,4) }}</td>
                      <!-- link perbarui -->
                      {{-- @if ($request->status == "Berhasil diupload" or $request->status == "Pengecekan kelengkapan berkas")
                        <td><a href="{{ URL::to('frm_update/'.$request->id) }}">Perbarui</a></td>
                      @else
                        <td><s>Perbarui</s></td>
                      @endif --}}
                      <td>
                        <span class="tools">
                          @if ($request->status == "Berhasil diupload" or $request->status == "Pengecekan kelengkapan berkas")
                            <a href="{{ URL::to('frm_update/'.$request->id) }}" title="Perbarui"><i class="fa fa-edit"></i></a>&nbsp&nbsp
                            <i data-target="#delete{{ $request->id }}" data-toggle="modal"  class="fa fa-trash-o text-info" title="Hapus"></i>
                          @else
                            <i class="fa fa-edit"></i>&nbsp&nbsp
                            <i class="fa fa-trash-o"></i>
                          @endif
                        </span>
                      </td>
                    </tr>

                    <!-- Modal hapus permohonan -->
                    <div class="modal fade" id="delete{{ $request->id }}" tabindex="-1"  aria-labelledby="myModalLabel">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="{{ route('delete') }}" method="post" enctype="multipart/form-data">
                            <div class="modal-body" align="center">
                              <!-- Hidden input -->
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="id" value="{{ $request->id }}">
                              <!-- End hidden input -->
                              <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                              </button>
                              <div class="form-group">
                                <label for="status" class="control-label">Yakin ingin menghapus permohonan ini ?</label>
                              </div>
                              <div align="center">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Hapus</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        @else
          <div class="col-md-8 col-md-offset-2">
            <div class="callout callout-info">
              <h2>Tidak Ada Permohonan Aktif</h2>

              <p>Tidak ada permohonan yang bisa ditampilkan, karena anda belum pernah mengajukan / telah menghapus permohonan.</p>

              <p>Jika anda ingin mengajukan permohonan, silahkan klik menu <a href="{{  url('pelayanan_online') }}"><b>Pelayanan Online</b></a>, kemudian pilih salah satu permohonan yang tersedia.</p>
            </div>
          </div>
        @endif
      </div>
    </div>
    <!-- /.row (main row) -->
    <br>
    <br>
    <br>
    <br>
    <!-- callout -->
    @if($callout)
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="callout callout-danger">
              <p align="center">Permohonan yang gagal diproses biasanya disebabkan karena isian formulir atau lampiran yang tidak lengkap / tidak sesuai. Silahkan perbarui dengan klik icon <i class="fa fa-edit"></i>  yang ada pada kolom paling kanan permohonan untuk memperbarui permohonan</p>
            </div>
          </div>
        </div>
      </div>
    @endif

  </section>
@endsection
