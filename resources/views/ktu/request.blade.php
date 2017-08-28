@extends('layouts.table.ktumaster')

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
                    <th>Surat Permohonan</th>
                    <th>Pemohon</th>
                    <th>Tanggal Permohonan</th>
                    <th>Catatan Tindak Lanjut</th>
                    <th>Cek Kesiapan Surat</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($requests as $request)
                    <tr role="row" class="odd">
                      <td class="sorting_1">{{ $count++ }}</td>
                      <td>{{ $request->kode_frm }} {{ $request->jenis_frm }}</td>
                      <td>{{ $request->nim }}</td>
                      <td>{{ substr($request->changed_at,8,2)."/".substr($request->changed_at,5,2)."/".substr($request->changed_at,0,4) }}</td>
                      <td>{{ $request->adm_catatan_tinjut }}</td>
                      <td><a href="{{ URL::to('frm_ktucheck/'.$request->id) }}">Cek</a></td>
                    </tr>
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
