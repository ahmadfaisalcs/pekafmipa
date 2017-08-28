<?php

namespace App\Http\Controllers;

use Notification;
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

// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Notifications\KtuReturnForm;
use App\Notifications\KtuPassForm;
use StreamLab\StreamLabProvider\Facades\StreamLabFacades;
use Illuminate\Notifications\Notifiable;

use App\Application;
use App\Information;
use App\Applicant;

/**
 *
 */
class KtuRequestController extends Controller
{
  public function pushNotifToAdm($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $nim = $frm->nim;
      $user_adm = User::where('role', 'adm')->first();
      Notification::send($user_adm, new KtuReturnForm($frm));
      $data = 'Ada kekurangan/kesalahan.<br />' .$frm->jenis_frm .' gagal diproses';
      StreamLabFacades::pushMessage('adm', 'KtuReturnForm', $data);
    }
    return null;
  }

  public function pushNotifToSrt($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $user_srt = User::where('role', 'srt')->first();
      Notification::send($user_srt, new KtuPassForm($frm));
      $data = 'Ktu membagikan <br />' .$frm->jenis_frm.' untuk diselesaikan';
      StreamLabFacades::pushMessage('srt', 'KtuPassForm', $data);
    }
    return null;
  }

  public function ktuDashboard()
  {
    // $requests = Form::where('status', 'Proses penyelesaian surat')->where('ktu_keterangan', '')->where('ktu_catatan_tinjut', '')->orderBy('updated_at', 'desc')->get();
    // return view('ktu.request', ['requests' => $requests, 'count' => 1]);

    $requests = DB::table('applicants')
                  ->join('applications', 'applicants.id', '=', 'applications.applicant_id')
                  ->join('information', 'applications.id', '=', 'information.application_id')
                  ->where('applications.status', 'Proses penyelesaian surat')
                  ->where('information.ktu_keterangan', '')
                  ->where('information.ktu_catatan_tinjut', '')
                  ->orderBy('updated_at', 'desc')
                  ->select('applications.kode_frm', 'applications.jenis_frm', 'applicants.nim', 'applications.changed_at', 'applications.updated_at', 'applications.id', 'information.adm_catatan_tinjut')
                  ->get();
    return view('ktu.request', ['requests' => $requests, 'count' => 1]);
  }

  public function ktuRequestInfo()
  {
    // $requests = Form::where('status', 'Proses penyelesaian surat')->where('ktu_keterangan', '<>', '')->where('ktu_catatan_tinjut', '')->orderBy('updated_at', 'desc')->get();
    // return view('ktu.request_info', ['requests' => $requests, 'count' => 1]);

    $requests = DB::table('applicants')
                  ->join('applications', 'applicants.id', '=', 'applications.applicant_id')
                  ->join('information', 'applications.id', '=', 'information.application_id')
                  ->where('applications.status', 'Proses penyelesaian surat')
                  ->where('information.ktu_keterangan', '<>', '')
                  ->where('information.ktu_catatan_tinjut', '')
                  ->orderBy('updated_at', 'desc')
                  ->select('applications.kode_frm', 'applications.jenis_frm', 'applicants.nim', 'applications.changed_at', 'applications.updated_at', 'applications.id', 'information.ktu_keterangan')
                  ->get();
    return view('ktu.request_info', ['requests' => $requests, 'count' => 1]);
  }


  public function ktuCheck($id)
  {
    $kode_frm = Form::where('id', $id)->pluck('kode_frm');
    $app = Application::where('id', $id)->first();
    $info = Information::where('id', $app->information_id)->first();

    return view('ktu.frm.frm_check', ['id' => $id, 'app' => $app, 'info' => $info]);

    // if($kode_frm == '["FRM-09a"]') {
    //   return view('ktu.frm.frm09a_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-09b"]') {
    //   return view('ktu.frm.frm09b_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-10"]') {
    //   return view('ktu.frm.frm10_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-11"]') {
    //   return view('ktu.frm.frm11_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-12"]') {
    //   return view('ktu.frm.frm12_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-13"]') {
    //   return view('ktu.frm.frm13_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-14"]') {
    //   return view('ktu.frm.frm14_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-15"]') {
    //   return view('ktu.frm.frm15_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-16"]') {
    //   return view('ktu.frm.frm16_check', ['id' => $id, 'form' => $form]);
    // }
    // elseif($kode_frm == '["FRM-17"]') {
    //   return view('ktu.frm.frm17_check', ['id' => $id, 'form' => $form]);
    // }
  }

  public function updateRequest(Request $request)
  {
    // kalau request punya value keterangan, berarti berkas request tsb tdk lengkap
    $iscomplete = $request['iscomplete'];
    if (!$iscomplete) {
      $this->validate($request, [
        'keterangan' => 'required',
      ]);

      $app = Application::where('id', $request->id)->first();
      $frm = Information::find($app->information_id);
      $frm->ktu_keterangan = $request['keterangan'];

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->to('ktu_daftar_keterangan_perbaikan');
    }
    else {
      $app = Application::find($request->id);
      $app->status = 'Proses penyelesaian surat';
      $app->update();

      $app = Application::where('id', $request->id)->first();
      $frm = Information::find($app->information_id);
      $frm->ktu_keterangan = "";
      $frm->ktu_catatan_tinjut = $request['catatan_tinjut'];
      $frm->ktu_waktu_tinjut = Carbon::now();
      if($frm->update())
      {
        $this->pushNotifToSrt($frm);
      }

      return redirect()->to('ktu_daftar_permohonan');
    }
  }

  public function printForm($id)
  {
    // jalankan fungsi fpdf
    $hasil = Form::where('id',$id)->first();
    if($hasil->kode_frm == "FRM-09a"){
      return redirect()->to('/SuratAktifKuliahPDF/'.$id);
    } 
    elseif($hasil->kode_frm == "FRM-09b"){
      return redirect()->to('/SuratTunjanganAnakPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-10"){
      return redirect()->to('/SuratCutiPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-11"){
      return redirect()->to('/SuratAktifSetelahCutiPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-12"){
      return redirect()->to('/SurtaUndurDiriPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-13"){
      return redirect()->to('/SuratSidangKomisiPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-14"){
      return redirect()->to('/SuratPerpanjanganStudiPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-15"){
      return redirect()->to('/SuratKeteranganLulusPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-16"){
      return redirect()->to('/SuratPercepatanIjazahPDF/'.$id);
    }
    elseif($hasil->kode_frm == "FRM-17"){
      return redirect()->to('/FrmFmipa17/'.$id);
    }
  }

  public function markAsRead()
  {
    foreach (\App\User::find(Session::get('id'))->unreadnotifications as $note)
    {
      $note->markAsRead();
    }
  }
}
