@extends('layouts.mahasiswa.master')

@section('page-title')
  Formulir Tidak Tersedia
@endsection

@section('header-content')

@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form class="" action="index.html" method="post">
          <!-- BOX #1 -->
          <div class="callout callout-info">
                <h2>Formulir Versi Online Belum Tersedia</h2>

                <p>Mohon maaf, untuk sementara <b>Formulir Data Mahasiswa yang Mengajukan Perpanjangan Studi</b> belum tersedia secara <i>online</i>. Silahkan <i>download</i> dan isi (secara manual) 2 formulir di bawah untuk mengajukan secara <i>offline</i> ke tata usaha FMIPA.</p>

                <p>Terimakasih atas pengertiannya. Semangat, semoga studinya dilancarkan. (^_^)</p>
              </div>

          <!-- BOX #2 -->
          <div class="box box-info">
            <!-- form start -->
            <div class="form">
              <div class="box-body">
                <!-- download #1-->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="spp">Download Formulir Mahasiswa yang Mengajukan Perpanjangan Studi</label>
                    {{-- <p class="help-block">POB/FMIPA-ADM/14/FRM-01-01</p> --}}
                    <button type="button" class="btn btn-block btn-primary">Download</button>
                  </div>
                </div>
                <!-- download #2 -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="spp">Download Surat Pernyataan Rencana Penyelesaian Studi</label>
                    <button type="button" class="btn btn-block btn-primary">Download</button>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
          </div>

          {{-- <!-- terimakasih -->
          <div class="callout callout-info">
            <p align="center">Maksimal waktu pelayanan Surat Sidang Komisi Pasca Sarjana adalah <strong>3 Hari</strong>. Cek menu <strong>Status Permohonan</strong> untuk mengetahui status formulir permohonan</p>
          </div> --}}
        </form>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
