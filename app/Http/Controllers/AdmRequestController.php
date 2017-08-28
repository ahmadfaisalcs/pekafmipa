<?php

namespace App\Http\Controllers;

use Notification;
use App\Notifications\StdSubmitNewForm;
use App\Notifications\AdmReturnForm;
use App\Notifications\AdmPassForm;
use Session;
use File;
use Storage;
use App\User;
use App\Form;
use App\Satisfaction;
use App\Http\Controllers\Input;
use App\Http\Requests;
use Illuminate\Http\Request; //5.4
use Illuminate\Http\UploadedFile; //5.4

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;

use Illuminate\Notifications\Notifiable;

// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Application;
use App\Information;
use App\Applicant;

/**
 *
 */
class AdmRequestController extends Controller
{
  /// FUNGSI PUSH NOTIFIKASI KE TENDIK adminlte
  public function pushNotifToStd($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $nim = $frm->nim;
      $user_std = User::where('nim', $nim)->first();
      Notification::send($user_std, new AdmReturnForm($frm));
      $data = 'Permohonan anda <br />' .$frm->jenis_frm .' gagal diproses';
      StreamLabFacades::pushMessage('admreturnform', 'AdmReturnForm', $data);
    }
    return null;
  }

  public function pushNotifToKtu($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $user_ktu = User::where('role', 'ktu')->first();
      Notification::send($user_ktu, new AdmPassForm($frm));
      $data = 'Tendik adm. pendidikan membagikan <br />' .$frm->jenis_frm.' untuk diperiksa';
      StreamLabFacades::pushMessage('ktu', 'AdmPassForm', $data);
    }
    return null;
  }

  public function admDashboard()
  {
    // $requests = Form::where('status', 'Berhasil diupload')->where('adm_keterangan', '')->orderBy('updated_at', 'desc')->get();
    // return view('adm.request', ['requests' => $requests, 'count' => 1]);

    $requests = DB::table('applicants')
                  ->join('applications', 'applicants.id', '=', 'applications.applicant_id')
                  ->join('information', 'applications.id', '=', 'information.application_id')
                  ->where('applications.status', 'Berhasil diupload')
                  ->where('information.adm_keterangan', '')
                  ->orderBy('updated_at', 'desc')
                  ->select('applications.kode_frm', 'applications.jenis_frm', 'applicants.nim', 'applications.changed_at', 'applications.updated_at', 'applications.id')
                  ->get();
    return view('adm.request', ['requests' => $requests, 'count' => 1]);
  }

  public function admRequestInfo()
  {
    // $requests = Form::where('status', 'Pengecekan kelengkapan berkas')->orderBy('updated_at', 'desc')->get();
    // return view('adm.request_info', ['requests' => $requests, 'count' => 1]);

    $requests = DB::table('applicants')
                  ->join('applications', 'applicants.id', '=', 'applications.applicant_id')
                  ->join('information', 'applications.id', '=', 'information.application_id')
                  ->where('applications.status', 'Pengecekan kelengkapan berkas')
                  ->orderBy('updated_at', 'desc')
                  ->select('applications.kode_frm', 'applications.jenis_frm', 'applicants.nim', 'applications.changed_at', 'applications.updated_at', 'applications.id', 'information.adm_keterangan')
                  ->get();
    return view('adm.request_info', ['requests' => $requests, 'count' => 1]);
  }

  public function admKtuCorrection()
  {
    // $requests = Form::where('status', 'Proses penyelesaian surat')->where('ktu_keterangan', '<>', '')->where('ktu_catatan_tinjut', '')->orderBy('updated_at', 'desc')->get();
    // return view('adm.ktu_correction', ['requests' => $requests, 'count' => 1]);

    $requests = DB::table('applicants')
                  ->join('applications', 'applicants.id', '=', 'applications.applicant_id')
                  ->join('information', 'applications.id', '=', 'information.application_id')
                  ->where('applications.status', 'Proses penyelesaian surat')
                  ->where('ktu_keterangan', '<>', '')
                  ->where('ktu_catatan_tinjut', '')
                  ->orderBy('updated_at', 'desc')
                  ->select('applications.kode_frm', 'applications.jenis_frm', 'applicants.nim', 'applications.changed_at', 'applications.updated_at', 'applications.id', 'information.ktu_keterangan')
                  ->get();
    return view('adm.ktu_correction', ['requests' => $requests, 'count' => 1]);
  }

  public function admCheck($id)
  {
    $kode_frm = Application::where('id', $id)->pluck('kode_frm');
    $form = Application::where('id', $id)->first();
    $info = Information::where('id', $form->information_id)->first();

    if($kode_frm == '["FRM-09a"]') {
      $lampiran = DB::table('frm-09a')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm09a_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-09b"]') {
      $lampiran = DB::table('frm-09b')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm09b_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-10"]') {
      $lampiran = DB::table('frm-10')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm10_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-11"]') {
      $lampiran = DB::table('frm-11')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm11_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-12"]') {
      $lampiran = DB::table('frm-12')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm12_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-13"]') {
      $lampiran = DB::table('frm-13')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm13_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-14"]') {
      $lampiran = DB::table('frm-14')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm14_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-15"]') {
      $lampiran = DB::table('frm-15')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm15_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-16"]') {
      $lampiran = DB::table('frm-16')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm16_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
    elseif($kode_frm == '["FRM-17"]') {
      $lampiran = DB::table('frm-17')->where('id', $form->id_infrm)->first();
      return view('adm.frm.frm17_check', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'info' => $info]);
    }
  }

  //
  public function updateRequest(Request $request)
  {
    $nim = Session::get('nim');
    $allchecked = $request['is_allchecked'];
    // kalau request punya value keterangan, berarti berkas request tsb tdk lengkap
    if (!$allchecked) {
      $frm = Application::find($request['id']);
      $id_info = $frm->information_id;
      $frm->nomor_surat = "";
      $frm->status = 'Pengecekan kelengkapan berkas';
      
      $thatday = Application::where('id', $request['id'])->first();
      $thatday = $thatday['updated_at'];
      $thatday = $thatday->format('Y-m-d');
      $today = Carbon::today();
      $today = $today->format('Y-m-d');
      if ($thatday > $today) {
        $last_request = Application::where('nim', $request['nim'])->orderBy('updated_at', 'desc')->first();
        $last_request_time = $last_request['updated_at'];
        // echo $last_request_time;
        date_add($last_request_time, date_interval_create_from_date_string('1 seconds'));
        $frm->updated_at = $last_request_time;
      }
      else {
        $frm->updated_at = Carbon::now();
      }
      if($frm->update())
      {
        $this->pushNotifToStd($frm);
      }

      $info = Information::find($id_info);
      $info->adm_keterangan = $request['keterangan'];
      $info->update();

      return redirect()->to('adm_daftar_permohonan_keterangan');
    }
    else {
      $this->validate($request, [
        'nomor_surat' => 'required',
        // 'tgl_rencana_lulus' => 'required',
      ]);

      $id_app = $request['id'];
      $frm = Application::find($request['id']);
      $id_info = $frm->information_id;
      $kode_frm = $frm->kode_frm;
      $frm->nomor_surat = $request['nomor_surat'];
      $frm->status = 'Proses penyelesaian surat';

      if ($kode_frm == 'FRM-13') {
        $this->validate($request, [
          'komisi_pembimbing_1' => 'required',
          'komisi_pembimbing_2' => 'required',
          'hari' => 'required',
          'tanggal' => 'required',
          'jam' => 'required',
          'tempat' => 'required',
        ]);
      }

      if ($kode_frm == 'FRM-14') {
        $this->validate($request, [
          'tgl_rencana_lulus' => 'required',
          'thn_akademik' => 'required',
          'dosbing' => 'required',
        ]);
      }

      /* untuk frm 13 */
      if ($kode_frm == 'FRM-13') {
        DB::table('frm-13')->update(['kombing1' => $request['komisi_pembimbing_1'], 'kombing2' => $request['komisi_pembimbing_2'], 'hari' => $request['hari'], 'tanggal' => $request['tanggal'], 'jam' => $request['jam'], 'tempat' => $request['tempat']]);
      }      

      /* untuk frm 14 */
      if ($kode_frm == 'FRM-14') {
        DB::table('frm-14')->update(['tanggal' => $request['tgl_rencana_lulus'], 'tahun_akademik' => $request['thn_akademik'], 'dosbing' => $request['dosbing']]);
      }
      
      if($frm->update())
      {
        $this->pushNotifToKtu($frm);
      }

      $info = Information::find($id_info);
      $info->adm_keterangan = "";
      $info->adm_catatan_tinjut = $request['catatan_tinjut'];
      $info->ktu_keterangan = "";
      $info->ktu_catatan_tinjut = "";
      $info->adm_waktu_tinjut = Carbon::now();
      $info->update();

      // $this->printForm($id_app);
      
      return redirect()->to('frm_admcheck/'.$request->id);
    }
  }

  public function markAsRead()
  {
    foreach (\App\User::find(Session::get('id'))->unreadnotifications as $note)
    {
      $note->markAsRead();
    }
  }

  public function printForm($id)
  {
    $hasil = Application::where('id',$id)->first();
    if($hasil->kode_frm == "FRM-09a"){
      return redirect()->to('/FrmFmipa09a/'.$id);
    } 
    elseif($hasil->kode_frm == "FRM-09b"){
      return redirect()->to('/FrmFmipa09b/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-10"){
      return redirect()->to('/FrmFmipa10/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-11"){
      return redirect()->to('/FrmFmipa11/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-12"){
      return redirect()->to('/FrmFmipa12/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-13"){
      return redirect()->to('/FrmFmipa13/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-14"){
      return redirect()->to('/FrmFmipa14/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-15"){
      return redirect()->to('/FrmFmipa15/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-16"){
      return redirect()->to('/FrmFmipa16/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-17"){
      return redirect()->to('/FrmFmipa17/'.$id);
    }
  }
}

/*
    if (!$is_allchecked) {
      $frm = Form::find($request['id']);
      $frm->nomor_surat = "";
      $frm->adm_keterangan = $request['keterangan'];
      $frm->status = 'Pengecekan kelengkapan berkas';

      $thatday = Form::where('id', $request['id'])->first();
      $thatday = $thatday['updated_at'];
      $thatday = $thatday->format('Y-m-d');
      $today = Carbon::today();
      $today = $today->format('Y-m-d');
      if ($thatday > $today) {
        $last_request = Form::where('nim', $request['nim'])->orderBy('updated_at', 'desc')->first();
        $last_request_time = $last_request['updated_at'];
        echo $last_request_time;
        date_add($last_request_time, date_interval_create_from_date_string('1 seconds'));
        $frm->updated_at = $last_request_time;
      }
      else {
        $frm->updated_at = Carbon::now();
      }
      if($frm->update())
      {
        $this->pushNotifToStd($frm);
      }

      return redirect()->to('adm_daftar_permohonan_keterangan');
    }
    else {
      $this->validate($request, [
        'nomor_surat' => 'required',
        // 'tgl_rencana_lulus' => 'required',
      ]);

      $frm = Form::find($request['id']);
      $frm->nomor_surat = $request['nomor_surat'];
      $frm->adm_keterangan = "";
      $frm->adm_catatan_tinjut = $request['catatan_tinjut'];
      $frm->ktu_keterangan = "";
      $frm->ktu_catatan_tinjut = "";
      $frm->adm_followup_time = Carbon::now();
      $frm->status = 'Proses penyelesaian surat';

      
      if ($request['tgl_rencana_lulus']) {
        //pakai kolom foto utk simpan tgl rencana lulus
        $frm->foto = $request['tgl_rencana_lulus'];
      }
      if ($request['dosbing']) {
        //pakai kolom srt_sidkom utk simpan nama dosbing
        $frm->srt_sidkom = $request['dosbing'];
      }
      if ($request['thn_akademik']) {
        //pakai kolom srt_undurdiri utk simpan tgl rencana lulus
        $frm->srt_undurdiri = $request['thn_akademik'];
      }
      

      
      if ($request['komisi_pembimbing_1']) {
        $frm->ktm = $request['komisi_pembimbing_1'];
      }
      if ($request['komisi_pembimbing_2']) {
        $frm->srt_pengantar = $request['komisi_pembimbing_2'];
      }
      if ($request['hari']) {
        $frm->srt_rekomen = $request['hari'];
      }
      if ($request['tanggal']) {
        $frm->srt_cuti = $request['tanggal'];
      }
      if ($request['jam']) {
        $frm->srt_undurdiri = $request['jam'];
      }
      if ($request['tempat']) {
        $frm->srt_rencanastudi = $request['tempat'];
      }
      
      
      if($frm->update())
      {
        $this->pushNotifToKtu($frm);
      }

      return redirect()->to('adm_daftar_permohonan');
    }
*/