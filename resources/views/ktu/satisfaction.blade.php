@extends('layouts.ktu.master')

@section('page-title')
  Survei Tingkat Kepuasan Lulusan
@endsection

@section('header-content')
  {{-- <section class="content-header">
    <h2>

    </h2>
  </section> --}}
@endsection

@section('data-content')
  <!-- Main content -->
  <section class="content">
    <!-- Main row -->
    <div class="row">
      
      <!-- BOX #1 -->
      <div class="col-md-5 col-md-offset-4">
        <div class="box">

          <!-- form start -->
          <form action="{{ route('kepuasan_layanan') }}" class="form-horizontal" method="post">
            <div class="box-body">
              {{ csrf_field() }}
              <!-- header -->
              <div class="form-group" align="center">
                <label class="">SURVEI TINGKAT KEPUASAN LULUSAN FMIPA-IPB</label>
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

      <!-- BOX #2 TABLE: LATEST ORDERS -->
      <div class="col-md-12">
        <div class="box">
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead class="with-border" align="center" vertical-align="middle" >
                <tr>
                  <td rowspan="2" style="vertical-align:middle"><b>Fak./Dep.</b></td>
                  <td rowspan="2" style="vertical-align:middle"><b>Jum. Responden</b></td>
                  <td colspan="4" style="vertical-align:middle"><b>Akademik</b></td>
                  <td colspan="4" style="vertical-align:middle"><b>Non Akademik</b></td>
                  {{-- <td rowspan="2">Tindak Lanjut</td> --}}
                  <td rowspan="2" style="vertical-align:middle"><b>Rata-rata</b></td>
                </tr>
                <tr>
                  <td align="center"><b>Kuliah</b></td>
                  <td align="center"><b>Praktikum</b></td>
                  <td align="center"><b>Penelitian</b></td>
                  <td align="center"><b>Pembimbingan</b></td>
                  <td align="center"><b>Adm. Akademik</b></td>
                  <td align="center"><b>Kebersihan</b></td>
                  <td align="center"><b>Toilet</b></td>
                  <td align="center"><b>Hotspot</b></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><b>G0-FMIPA</b></td>
                  <td align="center">
                    @if (empty($mipa_res)) 0
                    @else {{ $mipa_res }}
                    @endif
                  </td>
                  <td align="center">-</td>
                  <td align="center">-</td>
                  <td align="center">-</td>
                  <td align="center">-</td>
                  <td align="center">
                    @if (empty($st->mipa_na1)) 0
                    @else {{ $st->mipa_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mipa_na2)) 0
                    @else {{ $st->mipa_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mipa_na3)) 0
                    @else {{ $st->mipa_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mipa_na4)) 0
                    @else {{ $st->mipa_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mipa_rata)) 0
                    @else {{ $st->mipa_rata }}
                    @endif
                  </td>
                </tr>
                <!-- stk -->
                <tr>
                  <td><b>G1-STK</b></td>
                  <td align="center">
                    @if (empty($stk_res)) 0
                    @else {{ $stk_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_a1)) 0
                    @else {{ $st->stk_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_a2)) 0
                    @else {{ $st->stk_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_a3)) 0
                    @else {{ $st->stk_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_a4)) 0
                    @else {{ $st->stk_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_na1)) 0
                    @else {{ $st->stk_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_na2)) 0
                    @else {{ $st->stk_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_na3)) 0
                    @else {{ $st->stk_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_na4)) 0
                    @else {{ $st->stk_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->stk_rata)) 0
                    @else {{ $st->stk_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G2-GFM</b></td>
                  <td align="center">
                    @if (empty($gfm_res)) 0
                    @else {{ $gfm_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_a1)) 0
                    @else {{ $st->gfm_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_a2)) 0
                    @else {{ $st->gfm_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_a3)) 0
                    @else {{ $st->gfm_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_a4)) 0
                    @else {{ $st->gfm_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_na1)) 0
                    @else {{ $st->gfm_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_na2)) 0
                    @else {{ $st->gfm_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_na3)) 0
                    @else {{ $st->gfm_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_na4)) 0
                    @else {{ $st->gfm_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->gfm_rata)) 0
                    @else {{ $st->gfm_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G3-BIO</b></td>
                  <td align="center">
                    @if (empty($bio_res)) 0
                    @else {{ $bio_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_a1)) 0
                    @else {{ $st->bio_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_a2)) 0
                    @else {{ $st->bio_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_a3)) 0
                    @else {{ $st->bio_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_a4)) 0
                    @else {{ $st->bio_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_na1)) 0
                    @else {{ $st->bio_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_na2)) 0
                    @else {{ $st->bio_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_na3)) 0
                    @else {{ $st->bio_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_na4)) 0
                    @else {{ $st->bio_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bio_rata)) 0
                    @else {{ $st->bio_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G4-KIM</b></td>
                  <td align="center">
                    @if (empty($kim_res)) 0
                    @else {{ $kim_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_a1)) 0
                    @else {{ $st->kim_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_a2)) 0
                    @else {{ $st->kim_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_a3)) 0
                    @else {{ $st->kim_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_a4)) 0
                    @else {{ $st->kim_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_na1)) 0
                    @else {{ $st->kim_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_na2)) 0
                    @else {{ $st->kim_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_na3)) 0
                    @else {{ $st->kim_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_na4)) 0
                    @else {{ $st->kim_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kim_rata)) 0
                    @else {{ $st->kim_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G5-MAT</b></td>
                  <td align="center">
                    @if (empty($mat_res)) 0
                    @else {{ $mat_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_a1)) 0
                    @else {{ $st->mat_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_a2)) 0
                    @else {{ $st->mat_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_a3)) 0
                    @else {{ $st->mat_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_a4)) 0
                    @else {{ $st->mat_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_na1)) 0
                    @else {{ $st->mat_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_na2)) 0
                    @else {{ $st->mat_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_na3)) 0
                    @else {{ $st->mat_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_na4)) 0
                    @else {{ $st->mat_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->mat_rata)) 0
                    @else {{ $st->mat_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G6-KOM</b></td>
                  <td align="center">
                    @if (empty($kom_res)) 0
                    @else {{ $kom_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_a1)) 0
                    @else {{ $st->kom_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_a2)) 0
                    @else {{ $st->kom_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_a3)) 0
                    @else {{ $st->kom_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_a4)) 0
                    @else {{ $st->kom_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_na1)) 0
                    @else {{ $st->kom_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_na2)) 0
                    @else {{ $st->kom_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_na3)) 0
                    @else {{ $st->kom_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_na4)) 0
                    @else {{ $st->kom_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->kom_rata)) 0
                    @else {{ $st->kom_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G7-FIS</b></td>
                  <td align="center">
                    @if (empty($fis_res)) 0
                    @else {{ $fis_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_a1)) 0
                    @else {{ $st->fis_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_a2)) 0
                    @else {{ $st->fis_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_a3)) 0
                    @else {{ $st->fis_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_a4)) 0
                    @else {{ $st->fis_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_na1)) 0
                    @else {{ $st->fis_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_na2)) 0
                    @else {{ $st->fis_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_na3)) 0
                    @else {{ $st->fis_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_na4)) 0
                    @else {{ $st->fis_na4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->fis_rata)) 0
                    @else {{ $st->fis_rata }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td><b>G8-BIK</b></td>
                  <td align="center">
                    @if (empty($bik_res)) 0
                    @else {{ $bik_res }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_a1)) 0
                    @else {{ $st->bik_a1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_a2)) 0
                    @else {{ $st->bik_a2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_a3)) 0
                    @else {{ $st->bik_a3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_a4)) 0
                    @else {{ $st->bik_a4 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_na1)) 0
                    @else {{ $st->bik_na1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_na2)) 0
                    @else {{ $st->bik_na2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_na3)) 0
                    @else {{ $st->bik_na3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($st->bik_na4)) 0
                    @else {{ $st->bik_na4 }}
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
{{--           <div class="box-footer">
            <button type="submit" class="btn btn-success pull-right">Download Tabel</button>
          </div> --}}
        </div>
        <!-- /.box -->
      </div>

    </div>
    <!-- /.row (main row) -->
  </section>
@endsection
