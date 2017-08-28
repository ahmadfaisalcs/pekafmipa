<?php

namespace App\Http\Controllers;

use Session;
use File;
use Storage;
use App\User;
use App\Form;
use App\Satisfaction;
use App\QualityObjective;
use App\Http\Controllers\Input;
use App\Http\Requests;
use Illuminate\Http\Request; //5.4
use Illuminate\Http\UploadedFile; //5.4

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

/**
 *
 */
class QualityObjectiveController extends Controller
{
  public function get_qo_09a(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    // echo $qo_jan;
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    // if ($qo_feb) $qo_feb; echo "<br>";
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    // if ($qo_mar) $qo_mar; echo "<br>";
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    // if ($qo_apr) $qo_apr; echo "<br>";
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    // if ($qo_mei) $qo_mei; echo "<br>";
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    // if ($qo_jun) $qo_jun; echo "<br>";
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    // if ($qo_jul) $qo_jul; echo "<br>";
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    // if ($qo_ags) $qo_ags; echo "<br>";
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    // if ($qo_sep) $qo_sep; echo "<br>";
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    // if ($qo_okt) $qo_okt; echo "<br>";
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    // if ($qo_nov) $qo_nov; echo "<br>";
    $qo_des = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', 'des')->where('tahun', $tahun)->first();
    // if ($qo_des) $qo_des; echo "<br>";

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-09a')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-09a')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-09a')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-09a')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.09a', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_09b(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-09b')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-09b')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-09b')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-09b')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.09b', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_10(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-10')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-10')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-10')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-10')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.10', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_11(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-11')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-11')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-11')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-11')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.11', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_12(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-12')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-12')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-12')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-12')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.12', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_13(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-13')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-13')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-13')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-13')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.13', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_14(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-14')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-14')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-14')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-14')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.14', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_15(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-15')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-15')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-15')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-15')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.15', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_16(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-16')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-16')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-16')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-16')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.16', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function get_qo_17(Request $request)
  {
    $now = Carbon::now();
    if ($request['tahun']) {
      $tahun = $request['tahun'];
    }
    else $tahun = $now->year;

    $qo_jan = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'jan')->where('tahun', $tahun)->first();
    $qo_feb = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'feb')->where('tahun', $tahun)->first();
    $qo_mar = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'mar')->where('tahun', $tahun)->first();
    $qo_apr = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'apr')->where('tahun', $tahun)->first();
    $qo_mei = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'mei')->where('tahun', $tahun)->first();
    $qo_jun = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'jun')->where('tahun', $tahun)->first();
    $qo_jul = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'jul')->where('tahun', $tahun)->first();
    $qo_ags = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'ags')->where('tahun', $tahun)->first();
    $qo_sep = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'sep')->where('tahun', $tahun)->first();
    $qo_okt = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'okt')->where('tahun', $tahun)->first();
    $qo_nov = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'nov')->where('tahun', $tahun)->first();
    $qo_des = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', 'des')->where('tahun', $tahun)->first();

    $qo_total_layanan = QualityObjective::where('kode_frm', 'FRM-17')->where('tahun', $tahun)->sum('jumlah_layanan');
    $qo_total_range1 = QualityObjective::where('kode_frm', 'FRM-17')->where('tahun', $tahun)->sum('range_1');
    $qo_total_range2 = QualityObjective::where('kode_frm', 'FRM-17')->where('tahun', $tahun)->sum('range_2');
    $qo_total_range3 = QualityObjective::where('kode_frm', 'FRM-17')->where('tahun', $tahun)->sum('range_3');

    if ($qo_total_layanan > 0) {
      $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
    }
    else $qo_total_pass = 0;

    $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');

    // get dropdown value
    $dis_year = QualityObjective::distinct()->get(['tahun']);

    return view('ktu.qo.17', ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3, 'dis_year' => $dis_year, 'selected_year' => $tahun]);
  }

  public function check_to_get_qo(Request $request)
  {
    // $return_halaman = $request->return_halaman;
    // $tahun = $request->tahun;
    // $kode_frm = $request->kode_frm;
    // $var = $this->qo_print($return_halaman, $tahun, $kode_frm);
    //
    // echo $var;
    if(\Request::is('qo_09a'))
    {
      $this->get_qo_09a();
    }
  }

  // public function qo_print($return_halaman, $tahun, $kode_frm)
  // {
  //
  //   // $tahun = $request['tahun'];
  //   $qo_jan = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'jan')->where('tahun', $tahun)->first();
  //   $qo_feb = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'feb')->where('tahun', $tahun)->first();
  //   $qo_mar = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'mar')->where('tahun', $tahun)->first();
  //   $qo_apr = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'apr')->where('tahun', $tahun)->first();
  //   $qo_mei = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'mei')->where('tahun', $tahun)->first();
  //   $qo_jun = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'jun')->where('tahun', $tahun)->first();
  //   $qo_jul = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'jul')->where('tahun', $tahun)->first();
  //   $qo_ags = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'ags')->where('tahun', $tahun)->first();
  //   $qo_sep = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'sep')->where('tahun', $tahun)->first();
  //   $qo_okt = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'okt')->where('tahun', $tahun)->first();
  //   $qo_nov = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'nov')->where('tahun', $tahun)->first();
  //   $qo_des = QualityObjective::where('kode_frm', $kode_frm)->where('bulan', 'des')->where('tahun', $tahun)->first();
  //
  //   $qo_total_layanan = QualityObjective::where('kode_frm', $kode_frm)->sum('jumlah_layanan');
  //   $qo_total_range1 = QualityObjective::where('kode_frm', $kode_frm)->sum('range_1');
  //   $qo_total_range2 = QualityObjective::where('kode_frm', $kode_frm)->sum('range_2');
  //   $qo_total_range3 = QualityObjective::where('kode_frm', $kode_frm)->sum('range_3');
  //
  //   if ($qo_total_layanan > 0) {
  //     $qo_total_pass = (($qo_total_range1+$qo_total_range2)/$qo_total_layanan)*100;
  //   }
  //   else $qo_total_pass = 0;
  //
  //   $qo_total_pass = number_format((float)$qo_total_pass, 4, '.', '');
  //
  //   //  view($return_halaman, ['qo_jan' => $qo_jan, 'qo_feb' => $qo_feb, 'qo_mar' => $qo_mar, 'qo_apr' => $qo_apr, 'qo_mei' => $qo_mei, 'qo_jun' => $qo_jun, 'qo_jul' => $qo_jul, 'qo_ags' => $qo_ags, 'qo_sep' => $qo_sep, 'qo_okt' => $qo_okt, 'qo_nov' => $qo_nov, 'qo_des' => $qo_des, 'qo_total_pass' => $qo_total_pass, 'qo_total_layanan' => $qo_total_layanan, 'qo_total_range1' => $qo_total_range1, 'qo_total_range2' => $qo_total_range2, 'qo_total_range3' => $qo_total_range3]);
  //   // \Redirect::route('ktu_daftar_permohonan');
  //   $s1 = 'string1'; $s2 = 'string2';
  //   return $s1;
  //
  // }
}
