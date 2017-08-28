@extends('layouts.table.ktumaster')

@section('page-title')
  Surat Cuti Akademik
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
      <!-- TABLE: LATEST ORDERS -->
      <div class="col-md-12">
        <div class="box">
          <div class="box-body">
              <div class="form-group">
                <label class="col-md-2 col-md-offset-1 control-label">Pelayanan :</label>
                <div class="col-sm-8">
                  <label class="control-label">FRM/FMIPA-ADM/10 - <b>Surat Cuti Akademik</b></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 col-md-offset-1 control-label">Fungsi :</label>
                <div class="col-md-8">
                  <label class="control-label">Administrasi Akademik</label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 col-md-offset-1 control-label">Sasaran Mutu :</label>
                <div class="col-md-8">
                  <label class="control-label">5 Hari</label>
                </div>
              </div>
              <!-- form -->
            <form action="{{ route('qo_10') }}" method="post">
              <input type="hidden" name="return_halaman" value="ktu.qo.09a">
              <input type="hidden" name="kode_frm" value="FRM-09a">
              {{ csrf_field() }}
              {{-- <div class="form-group">
                <label class="col-md-2 col-md-offset-1 control-label">Semester :</label>
                <div class="col-md-8">
                  <div class="input-group input-group-sm">
                    <select name="semester" class="form-control">
                      <option value="">Semester 1</option>
                      <option value="">Semester 2</option>
                    </select>
                  </div>
                </div>
              </div>   --}}
              <div class="form-group">
                <label class="col-md-2 col-md-offset-1 control-label">Tahun :</label>
                <div class="col-md-8">
                  <div class="input-group input-group-sm">
                    <select name="tahun" class="form-control">
                      @foreach ($dis_year as $year)
                        <option  @if($year->tahun == $selected_year) Selected="" @endif value="{{ $year->tahun }}">{{ $year->tahun }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>  
              <div class="form-group">
                <div class="col-md-3 col-md-offset-3">
                  <span class="input-group-btn">
                    <button type="submit" class="btn btn-info btn-flat">Pilih!</button>
                  </span>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="box">
          <!-- /.box-header -->
          <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
              <thead class="with-border" align="center" vertical-align="middle" >
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Periode (bulan)</th>
                  <th rowspan="2">Jumlah Pelayanan</th>
                  <th colspan="3">Relasi Waktu Pelayanan</th>
                  <th colspan="2">Prosentasi</th>
                  <th rowspan="2">Alasan Tidak Tercapai</th>
                  <th rowspan="2">Tindak Lanjut</th>
                </tr>
                <tr>
                  <th>1 Hari</th>
                  <th>2-5 Hari</th>
                  <th>> 5 Hari</th>
                  <th>Tercapai</th>
                  <th>Tidak Tercapai</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Januari</td>
                  <td align="center">
                    @if ( empty($qo_jan->jumlah_layanan) ) 0 
                    @else {{ $qo_jan->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->range_1)) 0
                    @else {{ $qo_jan->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->range_2)) 0
                    @else {{ $qo_jan->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->range_3)) 0
                    @else {{ $qo_jan->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->persentase_tercapai)) 0
                    @else {{ $qo_jan->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->persentase_tdk_tercapai)) 0
                    @else {{ $qo_jan->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->alasan))
                    @else {{ $qo_jan->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jan->catatan_tinjut))
                    @else {{ $qo_jan->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Februari</td>
                  <td align="center">
                    @if ( empty($qo_feb->jumlah_layanan) ) 0 
                    @else {{ $qo_feb->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->range_1)) 0
                    @else {{ $qo_feb->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->range_2)) 0
                    @else {{ $qo_feb->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->range_3)) 0
                    @else {{ $qo_feb->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->persentase_tercapai)) 0
                    @else {{ $qo_feb->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->persentase_tdk_tercapai)) 0
                    @else {{ $qo_feb->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->alasan))
                    @else {{ $qo_feb->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_feb->catatan_tinjut))
                    @else {{ $qo_feb->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Maret</td>
                   <td align="center">
                    @if ( empty($qo_mar->jumlah_layanan) ) 0 
                    @else {{ $qo_mar->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->range_1)) 0
                    @else {{ $qo_mar->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->range_2)) 0
                    @else {{ $qo_mar->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->range_3)) 0
                    @else {{ $qo_mar->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->persentase_tercapai)) 0
                    @else {{ $qo_mar->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->persentase_tdk_tercapai)) 0
                    @else {{ $qo_mar->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->alasan))
                    @else {{ $qo_mar->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mar->catatan_tinjut))
                    @else {{ $qo_mar->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>April</td>
                  <td align="center">
                    @if ( empty($qo_apr->jumlah_layanan) ) 0 
                    @else {{ $qo_apr->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->range_1)) 0
                    @else {{ $qo_apr->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->range_2)) 0
                    @else {{ $qo_apr->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->range_3)) 0
                    @else {{ $qo_apr->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->persentase_tercapai)) 0
                    @else {{ $qo_apr->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->persentase_tdk_tercapai)) 0
                    @else {{ $qo_apr->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->alasan))
                    @else {{ $qo_apr->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_apr->catatan_tinjut))
                    @else {{ $qo_apr->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Mei</td>
                  <td align="center">
                    @if ( empty($qo_mei->jumlah_layanan) ) 0 
                    @else {{ $qo_mei->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->range_1)) 0
                    @else {{ $qo_mei->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->range_2)) 0
                    @else {{ $qo_mei->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->range_3)) 0
                    @else {{ $qo_mei->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->persentase_tercapai)) 0
                    @else {{ $qo_mei->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->persentase_tdk_tercapai)) 0
                    @else {{ $qo_mei->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->alasan))
                    @else {{ $qo_mei->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_mei->catatan_tinjut))
                    @else {{ $qo_mei->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Juni</td>
                  <td align="center">
                    @if ( empty($qo_jun->jumlah_layanan) ) 0 
                    @else {{ $qo_jun->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->range_1)) 0
                    @else {{ $qo_jun->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->range_2)) 0
                    @else {{ $qo_jun->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->range_3)) 0
                    @else {{ $qo_jun->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->persentase_tercapai)) 0
                    @else {{ $qo_jun->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->persentase_tdk_tercapai)) 0
                    @else {{ $qo_jun->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->alasan))
                    @else {{ $qo_jun->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jun->catatan_tinjut))
                    @else {{ $qo_jun->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Juli</td>
                  <td align="center">
                    @if ( empty($qo_jul->jumlah_layanan) ) 0 
                    @else {{ $qo_jul->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->range_1)) 0
                    @else {{ $qo_jul->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->range_2)) 0
                    @else {{ $qo_jul->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->range_3)) 0
                    @else {{ $qo_jul->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->persentase_tercapai)) 0
                    @else {{ $qo_jul->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->persentase_tdk_tercapai)) 0
                    @else {{ $qo_jul->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->alasan))
                    @else {{ $qo_jul->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_jul->catatan_tinjut))
                    @else {{ $qo_jul->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Agustus</td>
                  <td align="center">
                    @if ( empty($qo_ags->jumlah_layanan) ) 0 
                    @else {{ $qo_ags->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->range_1)) 0
                    @else {{ $qo_ags->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->range_2)) 0
                    @else {{ $qo_ags->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->range_3)) 0
                    @else {{ $qo_ags->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->persentase_tercapai)) 0
                    @else {{ $qo_ags->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->persentase_tdk_tercapai)) 0
                    @else {{ $qo_ags->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->alasan))
                    @else {{ $qo_ags->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_ags->catatan_tinjut))
                    @else {{ $qo_ags->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>September</td>
                  <td align="center">
                    @if ( empty($qo_sep->jumlah_layanan) ) 0 
                    @else {{ $qo_sep->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->range_1)) 0
                    @else {{ $qo_sep->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->range_2)) 0
                    @else {{ $qo_sep->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->range_3)) 0
                    @else {{ $qo_sep->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->persentase_tercapai)) 0
                    @else {{ $qo_sep->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->persentase_tdk_tercapai)) 0
                    @else {{ $qo_sep->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->alasan))
                    @else {{ $qo_sep->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_sep->catatan_tinjut))
                    @else {{ $qo_sep->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>Oktober</td>
                  <td align="center">
                    @if ( empty($qo_okt->jumlah_layanan) ) 0 
                    @else {{ $qo_okt->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->range_1)) 0
                    @else {{ $qo_okt->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->range_2)) 0
                    @else {{ $qo_okt->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->range_3)) 0
                    @else {{ $qo_okt->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->persentase_tercapai)) 0
                    @else {{ $qo_okt->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->persentase_tdk_tercapai)) 0
                    @else {{ $qo_okt->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->alasan))
                    @else {{ $qo_okt->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_okt->catatan_tinjut))
                    @else {{ $qo_okt->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>11</td>
                  <td>November</td>
                  <td align="center">
                    @if ( empty($qo_nov->jumlah_layanan) ) 0 
                    @else {{ $qo_nov->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->range_1)) 0
                    @else {{ $qo_nov->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->range_2)) 0
                    @else {{ $qo_nov->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->range_3)) 0
                    @else {{ $qo_nov->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->persentase_tercapai)) 0
                    @else {{ $qo_nov->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->persentase_tdk_tercapai)) 0
                    @else {{ $qo_nov->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->alasan))
                    @else {{ $qo_nov->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_nov->catatan_tinjut))
                    @else {{ $qo_nov->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td>12</td>
                  <td>Desember</td>
                  <td align="center">
                    @if ( empty($qo_des->jumlah_layanan) ) 0 
                    @else {{ $qo_des->jumlah_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->range_1)) 0
                    @else {{ $qo_des->range_1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->range_2)) 0
                    @else {{ $qo_des->range_2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->range_3)) 0
                    @else {{ $qo_des->range_3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->persentase_tercapai)) 0
                    @else {{ $qo_des->persentase_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->persentase_tdk_tercapai)) 0
                    @else {{ $qo_des->persentase_tdk_tercapai }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->alasan))
                    @else {{ $qo_des->alasan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_des->catatan_tinjut))
                    @else {{ $qo_des->catatan_tinjut }}
                    @endif
                  </td>
                </tr>
                <tr>
                  <td align="right" colspan="2"><b>Total Layanan</b></td>
                  <td align="center">
                    @if (empty($qo_total_layanan)) 0
                    @else {{ $qo_total_layanan }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_total_range1)) 0
                    @else {{ $qo_total_range1 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_total_range2)) 0
                    @else {{ $qo_total_range2 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_total_range3)) 0
                    @else {{ $qo_total_range3 }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_total_pass)) 0
                    @else {{ $qo_total_pass }}
                    @endif
                  </td>
                  <td align="center">
                    @if (empty($qo_total_pass)) 0
                    @else {{ 100-$qo_total_pass }}
                    @endif
                  </td>
                  <td align="center"></td>
                  <td align="center"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>

    </div>
    <!-- /.row (main row) -->

  </section>
@endsection
