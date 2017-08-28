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

use Notification;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;
use Illuminate\Notifications\Notifiable;
use App\Notifications\SrtPassForm;

/**
 *
 */
class SrtRequestController extends Controller
{
  public function pushNotifToStd($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $nim = $frm->nim;
      $user_std = User::where('nim', $nim)->first();
      Notification::send($user_std, new SrtPassForm($frm));
      $data = 'Permohonan anda <br />' .$frm->jenis_frm .' selesai diproses';
      StreamLabFacades::pushMessage('admreturnform', 'SrtPassForm', $data);
    }
    return null;
  }

  public function SrtDashboard()
  {
    $requests = Form::where('status', 'Proses penyelesaian surat')->where('adm_followup_time', '<>', '')->where('ktu_followup_time', '<>', '')->orderBy('updated_at', 'desc')->get();
    return view('srt.request', ['requests' => $requests, 'count' => 1]);
  }

  public function SrtRequestDone()
  {
    $requests = Form::where('status', 'Telah selesai')->orderBy('updated_at', 'desc')->get();
    return view('srt.request_done', ['requests' => $requests, 'count' => 1]);
  }

  public function getMonthName($i)
  {
    // if ($i == 1) $bulan = 'jan' ;
    // elseif ($i == 2) $bulan = 'feb' ;
    // elseif ($i == 3) $bulan = 'mar' ;
    // elseif ($i == 4) $bulan = 'apr' ;
    // elseif ($i == 5) $bulan = 'mei' ;
    // elseif ($i == 6) $bulan = 'jun' ;
    // elseif ($i == 7) $bulan = 'jul' ;
    // elseif ($i == 8) $bulan = 'ags' ;
    // elseif ($i == 9) $bulan = 'sep' ;
    // elseif ($i == 10) $bulan = 'okt' ;
    // elseif ($i == 11) $bulan = 'nov' ;
    // elseif ($i == 12) $bulan = 'des' ;
    // return $bulan;
    echo "2";
  }

  public function getFrmCode($j)
  {
    // if ($j == 1) $kode_frm = 'FRM-09a' ;
    // elseif ($j == 2) $kode_frm = 'FRM-09b' ;
    // elseif ($j == 3) $kode_frm = 'FRM-10' ;
    // elseif ($j == 4) $kode_frm = 'FRM-11' ;
    // elseif ($j == 5) $kode_frm = 'FRM-12' ;
    // elseif ($j == 6) $kode_frm = 'FRM-13' ;
    // elseif ($j == 7) $kode_frm = 'FRM-14' ;
    // elseif ($j == 8) $kode_frm = 'FRM-15' ;
    // elseif ($j == 9) $kode_frm = 'FRM-16' ;
    // elseif ($j == 10) $kode_frm = 'FRM-17' ;
    // return $kode_frm;
    echo "2";
  }

  public function create_new_QO_record($tahun, $nama_bulan, $kode_frm)
  {
    // for ($i=1; $i < 11 ; $i++) {
    //   for ($j=1; $j < 13 ; $j++) {
        $new_record = new QualityObjective();
        $new_record->tahun = $tahun;
        $new_record->bulan = $nama_bulan;
        $new_record->kode_frm = $kode_frm;
        $new_record->jumlah_layanan = 0;
        $new_record->range_1 = 0;
        $new_record->range_2 = 0;
        $new_record->range_3 = 0;
        $new_record->persentase_tercapai = 0;
        $new_record->persentase_tdk_tercapai = 0;
        $new_record->save();
    //     $this->getMonthName($j);
    //     $this->getFrmCode($i);
    //   }
    // }
    return 1;
  }

  public function updateRequest(Request $request)
  {
    // kalau request punya value keterangan, berarti berkas request tsb tdk lengkap
    if ($request['status'] == 'sudah') {
      return DB::transaction(function($request) use($request)
      {
        $id = $request['id'];
        $form = Form::find($id);
        $form->status = 'Telah selesai';
        if ($request['srt_keterangan'] == '') {
          $form->adm_keterangan = 'Silahkan ambil berkas di Tata Usaha FMIPA dengan membawa dokumen persyaratan ';
        }
        if($form->update())
        {
          $this->pushNotifToStd($form);
        }

        // /// hitung sasaran mutu (tgl diajukan - tgl selesai) / updated_at - changed_at
        $this_form = Form::where('id', $id)->first();
        $tgl_diajukan = $this_form['changed_at'];
        $tgl_diajukan = substr($tgl_diajukan,0,4)."/".substr($tgl_diajukan,5,2)."/".substr($tgl_diajukan,8,2);
        $tgl_diajukan = strtotime($tgl_diajukan);
        $tgl_diajukan = date('Y/m/d', $tgl_diajukan);
        $tgl_diajukan = date_create($tgl_diajukan);

        $tgl_selesai = $this_form['updated_at'];;
        $tgl_selesai = substr($tgl_selesai,0,4)."/".substr($tgl_selesai,5,2)."/".substr($tgl_selesai,8,2);
        $tgl_selesai = strtotime($tgl_selesai);
        $tgl_selesai = date('Y/m/d', $tgl_selesai);
        $tgl_selesai = date_create($tgl_selesai);

        $diff = $tgl_diajukan->diff($tgl_selesai);
        $d = $diff->d;

        // dapatkan properti bulan
        $bulan = $this_form['changed_at'];
        $bulan = substr($bulan,5,2);
        if ($bulan == '01') { $nama_bulan = 'jan'; }
        elseif ($bulan == '02') { $nama_bulan = 'feb'; }
        elseif ($bulan == '03') { $nama_bulan = 'mar'; }
        elseif ($bulan == '04') { $nama_bulan = 'apr'; }
        elseif ($bulan == '05') { $nama_bulan = 'mei'; }
        elseif ($bulan == '06') { $nama_bulan = 'jun'; }
        elseif ($bulan == '07') { $nama_bulan = 'jul'; }
        elseif ($bulan == '08') { $nama_bulan = 'ags'; }
        elseif ($bulan == '09') { $nama_bulan = 'sep'; }
        elseif ($bulan == '10') { $nama_bulan = 'okt'; }
        elseif ($bulan == '11') { $nama_bulan = 'nov'; }
        elseif ($bulan == '12') { $nama_bulan = 'des'; }

        // dapatkan properti tahun
        $tahun = $this_form['changed_at'];
        $tahun = substr($tahun,0,4);

        // kalau tahun belum ada di database, buat baru
        $qo = QualityObjective::where('kode_frm', $this_form['kode_frm'])->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
        // $qo = QualityObjective::where('tahun', $tahun)->first();
        if (!count($qo))
        {
          $this->create_new_QO_record($tahun, $nama_bulan, $this_form['kode_frm']);
          // echo "new_qo_id";
          // return redirect()->route('srt_daftar_permohonan');
        }

        // frm09a
        if ($this_form->kode_frm == 'FRM-09a') {
          $qo = QualityObjective::where('kode_frm', 'FRM-09a')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 4) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 3) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_09a = QualityObjective::find($id_qo);
          $qo_09a->jumlah_layanan = $jumlah_layanan;
          $qo_09a->range_1 = $range_1;
          $qo_09a->range_2 = $range_2;
          $qo_09a->range_3 = $range_3;
          $qo_09a->persentase_tercapai = $persentase_tercapai;
          $qo_09a->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_09a->update();
        }

        // frm09b
        if ($this_form->kode_frm == 'FRM-09b') {
          $qo = QualityObjective::where('kode_frm', 'FRM-09b')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 4) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 3) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_09b = QualityObjective::find($id_qo);
          $qo_09b->jumlah_layanan = $jumlah_layanan;
          $qo_09b->range_1 = $range_1;
          $qo_09b->range_2 = $range_2;
          $qo_09b->range_3 = $range_3;
          $qo_09b->persentase_tercapai = $persentase_tercapai;
          $qo_09b->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_09b->update();
        }

        // frm10
        if ($this_form->kode_frm == 'FRM-10') {
          $qo = QualityObjective::where('kode_frm', 'FRM-10')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_10 = QualityObjective::find($id_qo);
          $qo_10->jumlah_layanan = $jumlah_layanan;
          $qo_10->range_1 = $range_1;
          $qo_10->range_2 = $range_2;
          $qo_10->range_3 = $range_3;
          $qo_10->persentase_tercapai = $persentase_tercapai;
          $qo_10->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_10->update();
        }

        // frm11
        if ($this_form->kode_frm == 'FRM-11') {
          $qo = QualityObjective::where('kode_frm', 'FRM-11')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_11 = QualityObjective::find($id_qo);
          $qo_11->jumlah_layanan = $jumlah_layanan;
          $qo_11->range_1 = $range_1;
          $qo_11->range_2 = $range_2;
          $qo_11->range_3 = $range_3;
          $qo_11->persentase_tercapai = $persentase_tercapai;
          $qo_11->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_11->update();
        }

        // frm12
        if ($this_form->kode_frm == 'FRM-12') {
          $qo = QualityObjective::where('kode_frm', 'FRM-12')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_12 = QualityObjective::find($id_qo);
          $qo_12->jumlah_layanan = $jumlah_layanan;
          $qo_12->range_1 = $range_1;
          $qo_12->range_2 = $range_2;
          $qo_12->range_3 = $range_3;
          $qo_12->persentase_tercapai = $persentase_tercapai;
          $qo_12->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_12->update();
        }

        // frm13
        if ($this_form->kode_frm == 'FRM-13') {
          $qo = QualityObjective::where('kode_frm', 'FRM-13')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 4) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 3) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_13 = QualityObjective::find($id_qo);
          $qo_13->jumlah_layanan = $jumlah_layanan;
          $qo_13->range_1 = $range_1;
          $qo_13->range_2 = $range_2;
          $qo_13->range_3 = $range_3;
          $qo_13->persentase_tercapai = $persentase_tercapai;
          $qo_13->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_13->update();
        }

        // frm14
        if ($this_form->kode_frm == 'FRM-14') {
          $qo = QualityObjective::where('kode_frm', 'FRM-14')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_14 = QualityObjective::find($id_qo);
          $qo_14->jumlah_layanan = $jumlah_layanan;
          $qo_14->range_1 = $range_1;
          $qo_14->range_2 = $range_2;
          $qo_14->range_3 = $range_3;
          $qo_14->persentase_tercapai = $persentase_tercapai;
          $qo_14->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_14->update();
        }

        // frm15
        if ($this_form->kode_frm == 'FRM-15') {
          $qo = QualityObjective::where('kode_frm', 'FRM-15')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 4) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 3) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_15 = QualityObjective::find($id_qo);
          $qo_15->jumlah_layanan = $jumlah_layanan;
          $qo_15->range_1 = $range_1;
          $qo_15->range_2 = $range_2;
          $qo_15->range_3 = $range_3;
          $qo_15->persentase_tercapai = $persentase_tercapai;
          $qo_15->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_15->update();
        }

        // frm16
        if ($this_form->kode_frm == 'FRM-16') {
          $qo = QualityObjective::where('kode_frm', 'FRM-16')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_16 = QualityObjective::find($id_qo);
          $qo_16->jumlah_layanan = $jumlah_layanan;
          $qo_16->range_1 = $range_1;
          $qo_16->range_2 = $range_2;
          $qo_16->range_3 = $range_3;
          $qo_16->persentase_tercapai = $persentase_tercapai;
          $qo_16->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_16->update();
        }

        // frm17
        if ($this_form->kode_frm == 'FRM-17') {
          $qo = QualityObjective::where('kode_frm', 'FRM-17')->where('bulan', $nama_bulan)->where('tahun', $tahun)->first();
          if ($d < 2) {
            $range_1 = $qo->range_1+1; $range_2 = $qo->range_2; $range_3 = $qo->range_3;
          }
          elseif ($d > 1 && $d < 6) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2+1; $range_3 = $qo->range_3;
          }
          elseif ($d > 5) {
            $range_1 = $qo->range_1; $range_2 = $qo->range_2; $range_3 = $qo->range_3+1;
          }
          $jumlah_layanan = $qo->jumlah_layanan+1;
          if ($jumlah_layanan > 0) {
            $persentase_tdk_tercapai = ($range_3/$jumlah_layanan)*100;
          } else $jumlah_layanan = 0;
          $persentase_tercapai = 100-$persentase_tdk_tercapai;

          // update nilai QualityObjective
          $id_qo = $qo->id;
          $qo_17 = QualityObjective::find($id_qo);
          $qo_17->jumlah_layanan = $jumlah_layanan;
          $qo_17->range_1 = $range_1;
          $qo_17->range_2 = $range_2;
          $qo_17->range_3 = $range_3;
          $qo_17->persentase_tercapai = $persentase_tercapai;
          $qo_17->persentase_tdk_tercapai = $persentase_tdk_tercapai;
          $qo_17->update();
        } // if kode_frm ==

        return redirect()->route('sendmail',[$id]);
      }); // DB transaction
    } // if status == sudah

    //kalau status request bukan 'sudah'
    else {
      return redirect()->back();
    }

    return redirect()->route('srt_daftar_permohonan');
  }

  public function markAsRead()
  {
    foreach (\App\User::find(Session::get('id'))->unreadnotifications as $note)
    {
      $note->markAsRead();
    }
  }
}
