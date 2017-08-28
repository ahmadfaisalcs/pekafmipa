@extends('layouts.mahasiswa.master')

@section('page-title')
  Pelayanan Online
@endsection

@section('header-content')
  <section class="content-header">
    <h1>
      Pilih Jenis Surat Keterangan
    </h1>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <!-- 09a -->
      <div class="col-md-4">
          <div class="small-box bg-green">
            <div class="inner">
              <h4 align="center">Surat Keterangan Beasiswa</h4>
              {{-- <p align="center">POB/FMIPA-ADM/09a/01-01</p> --}}
            </div>
            <a href="{{ URL::to('frm_09a/1') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 09b -->
      <div class="col-md-4">
          <div class="small-box bg-blue">
            <div class="inner">
              <h4 align="center">Surat Keterangan Pembuatan Visa</h4>
              {{-- <p align="center">POB/FMIPA-ADM/09b/01-01</p> --}}
            </div>
            <a href="{{ URL::to('frm_09a/2') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 10 -->
      <div class="col-md-4">
          <div class="small-box bg-maroon">
            <div class="inner">
              <h4 align="center">Surat Keterangan Kehilangan KTM</h4>
              {{-- <p align="center">POB/FMIPA-ADM/10/01-01</p> --}}
            </div>
            <a href="{{ URL::to('frm_09a/3') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
