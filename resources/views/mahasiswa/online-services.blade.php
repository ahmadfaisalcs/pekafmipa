@extends('layouts.mahasiswa.master')

@section('page-title')
  Pelayanan Online
@endsection

@section('header-content')
  <section class="content-header">
    <h1>
      Pilih Pelayanan Online
    </h1>
  </section>
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      <!-- 09a -->
      <div class="col-md-6">
          <div class="small-box bg-green">
            <div class="inner">
              <h4 align="center">Surat Keterangan</h4>
              <p align="center">POB/FMIPA-ADM/09a/01-01</p>
            </div>
            <a href="{{ url('/jenis_frm_09a') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 09b -->
      <div class="col-md-6">
          <div class="small-box bg-blue">
            <div class="inner">
              <h4 align="center">Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak</h4>
              <p align="center">POB/FMIPA-ADM/09b/01-01</p>
            </div>
            <a href="{{ url('frm_09b') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 10 -->
      <div class="col-md-6">
          <div class="small-box bg-maroon">
            <div class="inner">
              <h4 align="center">Surat Cuti Akademik</h4>
              <p align="center">POB/FMIPA-ADM/10/01-01</p>
            </div>
            <a href="{{ url('frm_10') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 11 -->
      <div class="col-md-6">
          <div class="small-box bg-purple">
            <div class="inner">
              <h4 align="center">Surat Aktif Kembali</h4>
              <p align="center">POB/FMIPA-ADM/11/01-01</p>
            </div>
            <a href="{{ url('frm_11') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 12 -->
      <div class="col-md-6">
          <div class="small-box bg-red">
            <div class="inner">
              <h4 align="center">Surat Undur Diri</h4>
              <p align="center">POB/FMIPA-ADM/12/01-01</p>
            </div>
            <a href="{{ url('frm_12') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 13 -->
      <div class="col-md-6">
          <div class="small-box bg-orange">
            <div class="inner">
              <h4 align="center">Surat Sidang Komisi Pascasarjana</h4>
              <p align="center">POB/FMIPA-ADM/13/01-01</p>
            </div>
            <a href="{{ url('frm_13') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 14 -->
      <div class="col-md-6">
          <div class="small-box bg-navy">
            <div class="inner">
              <h4 align="center">Surat Perpanjangan Studi</h4>
              <p align="center">POB/FMIPA-ADM/14/01-01</p>
            </div>
            <a href="{{ url('frm_14') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 15 -->
      <div class="col-md-6">
          <div class="small-box bg-primary">
            <div class="inner">
              <h4 align="center">Surat Keterangan Lulus</h4>
              <p align="center">POB/FMIPA-ADM/15/01-01</p>
            </div>
            <a href="{{ url('frm_15') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 16 -->
      <div class="col-md-6">
          <div class="small-box bg-yellow">
            <div class="inner">
              <h4 align="center">Surat Percepatan Ijazah</h4>
              <p align="center">POB/FMIPA-ADM/16/01-01</p>
            </div>
            <a href="{{ url('frm_16') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
      <!-- 17 -->
      <div class="col-md-6">
          <div class="small-box bg-black">
            <div class="inner">
              <h4 align="center">Legalisir</h4>
              <p align="center">POB/FMIPA-ADM/17/01-01</p>
            </div>
            <a href="{{ url('frm_17') }}" class="small-box-footer">
              Pilih <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
      </div>
    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
