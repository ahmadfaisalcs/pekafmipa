@extends('layouts.ktu.master')

@section('page-title')
  Rekapitulasi Lulusan
@endsection

@section('header-content')
  {{-- <section class="content-header">
    <h2>

    </h2>
  </section> --}}
@endsection

@section('data-content')
  <section class="content">
    <!-- Main row -->
    <div class="row">
      
      <!-- BOX #1 -->
      <div class="col-md-5 col-md-offset-4">
        <div class="box">

          <!-- form start -->
          <form action="{{ route('rekapitulasi_lulusan') }}" method="post" class="form-horizontal">
            <div class="box-body">
              {{ csrf_field() }}
              <!-- header -->
              <div class="form-group" align="center">
                <label class="">REKAPITULASI LULUSAN FMIPA-IPB</label>
              </div>
              <!-- wisuda tahap -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Periode Wisuda :</label>
                <div class="col-sm-7">
                  <select name="periode_wisuda" class="form-control">
                    <option @if($drop_periode == "1") Selected="" @endif value="1">Tahap 1</option>
                    <option @if($drop_periode == "2") Selected="" @endif value="2">Tahap 2</option>
                    <option @if($drop_periode == "3") Selected="" @endif value="3">Tahap 3</option>
                    <option @if($drop_periode == "4") Selected="" @endif value="4">Tahap 4</option>
                    <option @if($drop_periode == "5") Selected="" @endif value="5">Tahap 5</option>
                    <option @if($drop_periode == "6") Selected="" @endif value="6">Tahap 6</option>
                    <option @if($drop_periode == "7") Selected="" @endif value="7">Tahap 7</option>
                  </select>
                </div>
              </div>
              <!-- tanggal -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Tanggal :</label>
                <div class="col-sm-7">
                  <label class="control-label">7 Desember 2016</label>
                </div>
              </div>
              <!-- tahun -->
              <div class="form-group">
                <label class="col-sm-4 control-label">Tahun Akademik :</label>
                <div class="col-sm-7">
                  <select name="tahun_akademik" class="form-control">
                    @foreach ($dis_year as $year)
                      <option  @if($year->tahun_akademik == $selected_year) Selected="" @endif value="{{ $year->tahun_akademik }}">{{ $year->tahun_akademik }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <!-- button -->
              <div class="box-footer">
                <button type="submit" class="btn btn-block btn-primary">Pilih</button>
              </div>
            </div>
            <!-- /.box-body -->
          </form>
        </div>
      </div>

      <!-- TABLE: LATEST ORDERS -->
      <div class="col-md-10 col-md-offset-1">
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead class="with-border" align="center" vertical-align="middle" >
                <tr>
                  <td rowspan="2" style="vertical-align:middle"><b>Fak./Dep.</b></td>
                  <td rowspan="2" style="vertical-align:middle"><b>Jumlah Responden</b></td>
                  <td colspan="2" style="vertical-align:middle"><b>IPK</b></td>
                  <td colspan="2" style="vertical-align:middle"><b>Lama Studi</b></td>
                  <td rowspan="2" style="vertical-align:middle"><b>Tingkat Kepuasan</b></td>
                </tr>
                <tr>
                  <td align="center"><b>Rata-rata</b></td>
                  <td align="center"><b>Min-Max</b></td>
                  <td align="center"><b>Rata-rata</b></td>
                  <td align="center"><b>Min-Max</b></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><b>G0-FMIPA</td>
                  <td align="center">
                    @if (empty($mipa_res)) 0 
                    @else {{ $mipa_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g0_ipk_rata)) 0
                    @else {{ $grad->g0_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g0_ipk_min)) 0
                    @else {{ $grad->g0_ipk_min }} - {{ $grad->g0_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g0_studi_rata)) 0
                    @else {{ $grad->g0_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g0_studi_min)) 0
                    @else {{ $grad->g0_studi_min }} - {{ $grad->g0_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mipa_rata)) 0
                    @else {{ $st->mipa_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G1-STK</td>
                  <td align="center">
                    @if (empty($stk_res)) 0 
                    @else {{ $stk_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g1_ipk_rata)) 0
                    @else {{ $grad->g1_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g1_ipk_min)) 0
                    @else {{ $grad->g1_ipk_min }} - {{ $grad->g1_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g1_studi_rata)) 0
                    @else {{ $grad->g1_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g1_studi_min)) 0
                    @else {{ $grad->g1_studi_min }} - {{ $grad->g1_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_rata)) 0
                    @else {{ $st->stk_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G2-GFM</td>
                  <td align="center">
                    @if (empty($gfm_res)) 0 
                    @else {{ $gfm_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g2_ipk_rata)) 0
                    @else {{ $grad->g2_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g2_ipk_min)) 0
                    @else {{ $grad->g2_ipk_min }} - {{ $grad->g2_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g2_studi_rata)) 0
                    @else {{ $grad->g2_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g2_studi_min)) 0
                    @else {{ $grad->g2_studi_min }} - {{ $grad->g2_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_rata)) 0
                    @else {{ $st->gfm_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G3-BIO</t>
                  <td align="center">
                    @if (empty($bio_res)) 0 
                    @else {{ $bio_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g3_ipk_rata)) 0
                    @else {{ $grad->g3_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g3_ipk_min)) 0
                    @else {{ $grad->g3_ipk_min }} - {{ $grad->g3_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g3_studi_rata)) 0
                    @else {{ $grad->g3_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g3_studi_min)) 0
                    @else {{ $grad->g3_studi_min }} - {{ $grad->g3_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_rata)) 0
                    @else {{ $st->bio_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G4-KIM</td>
                  <td align="center">
                    @if (empty($kim_res)) 0 
                    @else {{ $kim_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g4_ipk_rata)) 0
                    @else {{ $grad->g4_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g4_ipk_min)) 0
                    @else {{ $grad->g4_ipk_min }} - {{ $grad->g4_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g4_studi_rata)) 0
                    @else {{ $grad->g4_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g4_studi_min)) 0
                    @else {{ $grad->g4_studi_min }} - {{ $grad->g4_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_rata)) 0
                    @else {{ $st->kim_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G5-MAT</td>
                  <td align="center">
                    @if (empty($mat_res)) 0 
                    @else {{ $mat_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g5_ipk_rata)) 0
                    @else {{ $grad->g5_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g5_ipk_min)) 0
                    @else {{ $grad->g5_ipk_min }} - {{ $grad->g5_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g5_studi_rata)) 0
                    @else {{ $grad->g5_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g5_studi_min)) 0
                    @else {{ $grad->g5_studi_min }} - {{ $grad->g5_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_rata)) 0
                    @else {{ $st->mat_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G6-KOM</td>
                  <td align="center">
                    @if (empty($kom_res)) 0 
                    @else {{ $kom_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g6_ipk_rata)) 0
                    @else {{ $grad->g6_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g6_ipk_min)) 0
                    @else {{ $grad->g6_ipk_min }} - {{ $grad->g6_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g6_studi_rata)) 0
                    @else {{ $grad->g6_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g6_studi_min)) 0
                    @else {{ $grad->g6_studi_min }} - {{ $grad->g6_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_rata)) 0
                    @else {{ $st->kom_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G7-FIS</td>
                  <td align="center">
                    @if (empty($fis_res)) 0 
                    @else {{ $fis_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g7_ipk_rata)) 0
                    @else {{ $grad->g7_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g7_ipk_min)) 0
                    @else {{ $grad->g7_ipk_min }} - {{ $grad->g7_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g7_studi_rata)) 0
                    @else {{ $grad->g7_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g7_studi_min)) 0
                    @else {{ $grad->g7_studi_min }} - {{ $grad->g7_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_rata)) 0
                    @else {{ $st->fis_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G8-BIK</td>
                  <td align="center">
                    @if (empty($bik_res)) 0 
                    @else {{ $bik_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if(empty($grad->g8_ipk_rata)) 0
                    @else {{ $grad->g8_ipk_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g8_ipk_min)) 0
                    @else {{ $grad->g8_ipk_min }} - {{ $grad->g8_ipk_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g8_studi_rata)) 0
                    @else {{ $grad->g8_studi_rata }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($grad->g8_studi_min)) 0
                    @else {{ $grad->g8_studi_min }} - {{ $grad->g8_studi_max }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_rata)) 0
                    @else {{ $st->bik_rata }}
                    @endif
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
          {{-- <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right">Download Tabel</button>
          </div> --}}
        </div>
        <!-- /.box -->
      </div>

    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
