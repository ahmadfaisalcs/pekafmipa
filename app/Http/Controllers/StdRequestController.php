<?php

namespace App\Http\Controllers;

use Notification;
use App\Notifications\StdSubmitNewForm;
use Session;
use File;
use Storage;
use App\User;
use App\Form;
use App\Satisfaction;
use App\Graduate;
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
use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Application;
use App\Applicant;
use App\Information;
use App\Biodata;

// use Illuminate\Http\Response;
use Illuminate\Support\Collection;
/**
 *
 */
class StdRequestController extends Controller
{
  /// Student Dashboard
  public function studentDashboard()
  {
    $user = Session::get('id');
    $requests = Application::where('applicant_id', $user)->orderBy('updated_at', 'desc')->get();
    $callout = Application::where('applicant_id', $user)->where('status', 'Pengecekan kelengkapan berkas')->first();
    $isexist = sizeof($requests);
    return view('mahasiswa.dashboard', ['requests' => $requests, 'count' => 1, 'callout' => $callout, 'isexist' => $isexist]);
  }

  /// UNTUK FRM 09a - 17
  public function checkFrm($id, $kode_frm)
  {
    $isfill = Application::where('applicant_id', $id)->where('kode_frm', $kode_frm)->where('status', '<>', 'telah selesai')->first();
    return $isfill;
  }

  public function getKodeFrm($route)
  {
    if ($route == 'frm_09a') { return $kode_frm = 'FRM-09a'; }
    elseif ($route == 'frm_09b') { return $kode_frm = 'FRM-09b'; }
    elseif ($route == 'frm_10') { return $kode_frm = 'FRM-10'; }
    elseif ($route == 'frm_11') { return $kode_frm = 'FRM-11'; }
    elseif ($route == 'frm_12') { return $kode_frm = 'FRM-12'; }
    elseif ($route == 'frm_13') { return $kode_frm = 'FRM-13'; }
    elseif ($route == 'frm_14') { return $kode_frm = 'FRM-14'; }
    elseif ($route == 'frm_15') { return $kode_frm = 'FRM-15'; }
    elseif ($route == 'frm_16') { return $kode_frm = 'FRM-16'; }
    elseif ($route == 'frm_17') { return $kode_frm = 'FRM-17'; }
  }

  public function getView($route)
  {
    if ($route == 'frm_09a') { return $view = 'frm09a'; }
    elseif ($route == 'frm_09b') { return $view = 'frm09b'; }
    elseif ($route == 'frm_10') { return $view = 'frm10'; }
    elseif ($route == 'frm_11') { return $view = 'frm11'; }
    elseif ($route == 'frm_12') { return $view = 'frm12'; }
    elseif ($route == 'frm_13') { return $view = 'frm13'; }
    elseif ($route == 'frm_14') { return $view = 'frm14'; }
    elseif ($route == 'frm_15') { return $view = 'frm15'; }
    elseif ($route == 'frm_16') { return $view = 'frm16'; }
    elseif ($route == 'frm_17') { return $view = 'frm17'; }
  }

  // untuk semua frm kecuali 09a
  public function checkFrmIsFill()
  {
    $id = Session::get('id');
    $route = \Request::route()->getName();
    $kode_frm = $this->getKodeFrm($route);

    $isfill = $this->checkFrm($id, $kode_frm);
    $view = $this->getView($route);

    if ($kode_frm == 'FRM-15') {
      $nim = Session::get('nim');
      $questionisfill = Satisfaction::where('nim', $nim)->first();
      $gd_isfill = Graduate::where('nim', $nim)->first();
      return view('mahasiswa.frm.'.$view, ['frmisfill' => $isfill, 'questionisfill' => $questionisfill, 'gd_isfill' => $gd_isfill]);
    }
    elseif ($kode_frm == 'FRM-16') {
      $nim = Session::get('nim');
      $gd_isfill = Graduate::where('nim', $nim)->first();
      return view('mahasiswa.frm.'.$view, ['isfill' => $isfill, 'gd_isfill' => $gd_isfill]);
    }
    else {
      return view('mahasiswa.frm.'.$view, ['isfill' => $isfill]);
    }
    
  }

  // khusus untuk frm-09a
  public function checkFrm09a($id)
  {
    $applicant_id = Session::get('id');

    if ($id == 1) { 
      $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('keperluan', 'Beasiswa')->first();
      $lampiran = DB::table('frm-09a')->where('id', $application['id_infrm'])->where('jenis_permohonan', 'Beasiswa')->first(); 
      if (sizeof($lampiran)) { 
        $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('id_infrm', $lampiran->id)->orderBy('updated_at', 'desc')->first();
        if ($application->status <> 'Telah selesai') {
          $isfill = 1; 
        }
        else{
          $isfill = 0; 
        }
      }
      else {
        $isfill = 0; 
      }
    }
    elseif ($id == 2) { 
      $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('keperluan', 'Pembuatan Visa')->first();
      $lampiran = DB::table('frm-09a')->where('id', $application['id_infrm'])->where('jenis_permohonan', 'Pembuatan Visa')->first(); 
      if (sizeof($lampiran)) { 
        $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('id_infrm', $lampiran->id)->orderBy('updated_at', 'desc')->first();
        if ($application->status <> 'Telah selesai') {
          $isfill = 1; 
        }
        else{
          $isfill = 0; 
        }
      }
      else {
        $isfill = 0; 
      }
    }
    elseif ($id == 3) { 
      $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('keperluan', 'Kehilangan KTM')->first();
      $lampiran = DB::table('frm-09a')->where('id', $application['id_infrm'])->where('jenis_permohonan', 'Kehilangan KTM')->first();
      if (sizeof($lampiran)) { 
        $application = Application::where('applicant_id', $applicant_id)->where('kode_frm', 'FRM-09a')->where('id_infrm', $lampiran->id)->orderBy('updated_at', 'desc')->first();
        if ($application->status <> 'Telah selesai') {
          $isfill = 1; 
        }
        else{
          $isfill = 0; 
        }
      }
      else {
        $isfill = 0; 
      }
    }
    
    if ($id == 1) { $jenis_permohonan = "Beasiswa"; }
    elseif ($id == 2) { $jenis_permohonan = "Pembuatan Visa"; }
    elseif ($id == 3) { $jenis_permohonan = "Kehilangan KTM"; }
    
    return view('mahasiswa.frm.frm09a', ['application' => $application, 'lampiran' => $lampiran, 'jenis_permohonan' => $jenis_permohonan, 'isfill' => $isfill]);
    // echo $application['id_infrm'];
  }

  /// FUNGSI CEK JAM/HARI PELAYANAN
  public function checkRequestDate($nim)
  {
    // kalau permohonan lebih dari jam 4 maka masuk pelayanan hari besoknya
    $current_date = Carbon::now();
    $close_date = Carbon::now();
    date_time_set($close_date, 16, 00, 00);

    if ($close_date < $current_date) {
      $request = Form::where('nim', $nim)->orderBy('updated_at', 'desc')->first();
      $isexist = sizeof($request);
      if ($isexist) {
        $last_request_date = $request['updated_at'];
        // $last_request_date = strtotime($last_request_date);
        $last_request_date_day = $last_request_date->format('Y-m-d');
        $current_date_day = $current_date->format('Y-m-d');
        if ($last_request_date_day == $current_date_day) {
          $input_date = $current_date;
        }
        elseif ($last_request_date_day < $current_date_day) {
          $input_date = $current_date;
          date_add($input_date, date_interval_create_from_date_string('1 days'));
          date_time_set($input_date, 00, 00, 01);
          $thatday = date("D", strtotime($input_date));
          if ($thatday == 'Sat') {
            date_add($input_date, date_interval_create_from_date_string('2 days'));
            date_time_set($input_date, 00, 00, 01);
          }
          elseif ($thatday == 'Sun') {
            date_add($input_date, date_interval_create_from_date_string('1 days'));
            date_time_set($input_date, 00, 00, 01);
          }
        }
        else {
          $input_date = $request['updated_at'];
          date_add($input_date, date_interval_create_from_date_string('1 seconds'));
          // $input_date = date("Y/m/d H:i:s a", time() + 1);
        }
      }
      else {
        $input_date = $current_date;
        date_add($input_date, date_interval_create_from_date_string('1 days'));
        date_time_set($input_date, 00, 00, 01);
        $thatday = date("D", strtotime($input_date));
        if ($thatday == 'Sat') {
          date_add($input_date, date_interval_create_from_date_string('2 days'));
          date_time_set($input_date, 00, 00, 01);
        }
        elseif ($thatday == 'Sun') {
          date_add($input_date, date_interval_create_from_date_string('1 days'));
          date_time_set($input_date, 00, 00, 01);
        }
        // echo $thatday;
      }
    }
    else {
      $input_date = $current_date;
      $thatday = date("D", strtotime($input_date));
      if ($thatday == 'Sat') {
        date_add($input_date, date_interval_create_from_date_string('2 days'));
        date_time_set($input_date, 00, 00, 01);
      }
      elseif ($thatday == 'Sun') {
        date_add($input_date, date_interval_create_from_date_string('1 days'));
        date_time_set($input_date, 00, 00, 01);
      }
    }

    // $input_date = strtotime($input_date);
    // $input_date = date('Y-m-d H:i:s', $input_date);
    // $input_date = date_create($input_date);

    // $frm->changed_at = $input_date;
    // $frm->updated_at = $input_date;

    return $input_date;
  }
  ///

  /// FUNGSI PUSH NOTIFIKASI KE TENDIK adminlte
  public function pushNotifToAdm($frm)
  {
    $connected = @fsockopen("www.google.com", 80);
    if ($connected) {
      $user_adm = User::where('role', 'adm')->first();
      Notification::send($user_adm, new StdSubmitNewForm($frm));
      $data = $frm->nim .' mengajukan permohonan  <br />' .$frm->jenis_frm;
      StreamLabFacades::pushMessage('adm', 'StdSubmitNewForm', $data);
    }
    return null;
  }
  ///

  /*
    cek file extention
  */
  public function checkExtention($file)
  {
    $filename = $file->getClientOriginalName();
    $extention = pathinfo($filename, PATHINFO_EXTENSION);
    return $extention;
  }

  // validate all form
  public function validateForm($request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email',
    ]);
  }

  public function makeNewApplicant($request)
  {
    return DB::transaction(function($request) use($request)
    {
      $applicant = new Applicant(); 
      $applicant->nim = $request['nim'];
      $applicant->nama = $request['nama'];
      $applicant->prodi = $request['program_studi'];
      $applicant->semester = $request['semester'];
      $applicant->email = $request['email'];
      $applicant->telp = $request['telp'];
      $applicant->username = Session::get('username');
      $applicant->save();

      return $applicant->id;
    });
  }

  public function updateApplicant($request)
  {
    return DB::transaction(function($request) use($request)
    {
      $nim = $request['nim'];
      $person = Applicant::where('nim', $nim)->first();
      $applicant = Applicant::find($person->id);
      $applicant->nim = $request['nim'];
      $applicant->nama = $request['nama'];
      $applicant->semester = $request['semester'];
      $applicant->email = $request['email'];
      $applicant->telp = $request['telp'];
      $applicant->update();

      return $applicant->id;
    });
  }

  public function checkApplicant($request)
  {
    $nim = $request['nim'];
    $person = Applicant::where('nim', $nim)->first();

    //kalau data pemohon sudah ada di database
    if (count($person)) {
      $applicant = $this->updateApplicant($request);
    }
    //kalau data pemohon blum ada di database
    else {
      $applicant = $this->makeNewApplicant($request);
    }
    return $applicant;
  }

  // make new application
  public function makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim)
  {
    $nim = Session::get('nim');
    $frm = new Application();
    $frm->jenis_frm = $jenis_frm;
    $frm->kode_frm = $kode_frm;
    $frm->id_infrm = $id_infrm;
    $frm->applicant_id = $applicant;
    $frm->keperluan = $request['utk_keperluan'];
    $frm->information_id = $info_id;
    $frm->status = "Berhasil diupload";

    $input_date = $this->checkRequestDate($nim);
    $frm->changed_at = $input_date;
    $frm->updated_at = $input_date;

    if($frm->save())
    {
      $this->pushNotifToAdm($frm);
      return $frm->id;
    }
  }

  public function updateApplication($request)
  {
    return DB::transaction(function($request) use($request)
    {
      $frm = Application::find($request->id);
      
      $frm->keperluan = $request['utk_keperluan'];
      $frm->status = 'Berhasil diupload';
      $input_date = $this->checkRequestDate($request['nim']);
      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
        return $frm->id;
      }

      $info = Information::find($frm->id_infrm);
      $info->adm_keterangan = "";
      $info->update();

      $result = Application::where('id', $request['id'])->first();
      return $id_infrm = $result->id_infrm;
    });
  }


  /// SUBMIT REQUEST
  // frm 09a
  public function submitRequest09a(Request $request)
  {
    $this->validateForm($request);

    if ($request['jenis_permohonan'] <> 'Kehilangan KTM')
    {
      if ($request->hasFile('surat') && $request->hasFile('spp') && $request->hasFile('ktm'))
      { $berkas = 1; }
      else $berkas = 0;
    }
    else
    {
      if ($request->hasFile('surat') && $request->hasFile('spp'))
      { $berkas = 1; }
      else $berkas = 0;
    }
    if ($berkas)
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_surat = $request->file('surat');
        $file_spp = $request->file('spp');
        $file_ktm = $request->file('ktm');
      
        if($request->hasFile('ktm')){
          $ktm_ext = $this->checkExtention($file_ktm);
          $path_ktm = "lampiran".'/'.$nim.'/'."KTM - frm-09a".'.'.$ktm_ext;
        }

        $surat = $this->checkExtention($file_surat);
        $spp_ext = $this->checkExtention($file_spp);

        if ($request['jenis_permohonan'] == 'Beasiswa')
        {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Rekomendasi - frm09a".'.'.$surat;
        }
        if ($request['jenis_permohonan'] == 'Kehilangan KTM')
        {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Pengantar - frm09a".'.'.$surat;
        }
        if ($request['jenis_permohonan'] == 'Kehilangan KTM')
        {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Keterangan - frm09a".'.'.$surat;
        }
        $path_spp = "lampiran".'/'.$nim.'/'."SPP - frm09a".'.'.$spp_ext;

        $upload_surat = 0;
        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //  jika Storage::put berahasil, maka akan mengembalikan nilai true
        if ($request->hasFile('ktm')){
          $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));
        }

        $upload_surat = Storage::put($path_surat, file_get_contents($file_surat->getRealPath()));
        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));


        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if (($upload_surat && $upload_spp) or $upload_ktm)
        { 
          $person = Applicant::where('nim', $nim)->first();

          //kalau data pemohon sudah ada di database
          if (count($person)) {
            $applicant = $this->updateApplicant($request);
          }
          //kalau data pemohon blum ada di database
          else {
            $applicant = $this->makeNewApplicant($request);
          }

          if (!$request->hasFile('ktm')){ $path_ktm = NULL; }
          // save di table 'frm-09a'
          $id_infrm = DB::table('frm-09a')->insertGetId(
              [
                'jenis_permohonan' => $request['jenis_permohonan'],
                'surat' => $path_surat,
                'spp' => $path_spp,
                'ktm' => $path_ktm
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Keterangan";
          $kode_frm = "FRM-09a";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 09b
  public function submitRequest09b(Request $request)
  {
    $this->validateForm($request);

    $this->validate($request, [
      'nama_ortu' => 'required',
      'nip' => 'required|digits:18',
      'pangkat' => 'required',
      'instansi' => 'required',
      'telp_ortu' => 'required|min:10|max:13|regex:/(08)[0-9]/'
    ]);

    if ($request->hasFile('spp') && $request->hasFile('ktm'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_spp = $request->file('spp');
        $file_ktm = $request->file('ktm');

        $spp_ext = $this->checkExtention($file_spp);
        $ktm_ext = $this->checkExtention($file_ktm);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_spp = "lampiran".'/'.$nim.'/'."SPP - frm09b".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM - frm09b".'.'.$ktm_ext;

        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true
        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
        $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_spp && $upload_ktm)
        {
          $applicant = $this->checkApplicant($request);

          $id_infrm = DB::table('frm-09b')->insertGetId(
              [
                'nama_ortu' => $request['nama_ortu'],
                'nip' => $request['nip'],
                'pangkat' => $request['pangkat'],
                'instansi' => $request['instansi'],
                'telp_ortu' => $request['telp_ortu'],
                'spp' => $path_spp,
                'ktm' => $path_ktm
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak";
          $kode_frm = "FRM-09b";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }

      });
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 10
  public function submitRequest10(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_cuti') && $request->hasFile('srt_pengantar') && $request->hasFile('spp') && $request->hasFile('ktm'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_cuti = $request->file('srt_cuti');
        $file_srt_pengantar = $request->file('srt_pengantar');
        $file_spp = $request->file('spp');
        $file_ktm = $request->file('ktm');

        $cuti_ext = $this->checkExtention($file_srt_cuti);
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $spp_ext = $this->checkExtention($file_spp);
        $ktm_ext = $this->checkExtention($file_ktm);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_srt_cuti = "lampiran".'/'.$nim.'/'."Surat Permohonan Cuti Dari Mahasiswa dan Wali - frm10".'.'.$cuti_ext;
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm10".'.'.$pengantar_ext;
        $path_spp = "lampiran".'/'.$nim.'/'."SPP - frm10".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM - frm10".'.'.$ktm_ext;

        $upload_srt_cuti = 0;
        $upload_srt_pengantar = 0;
        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_srt_cuti = Storage::put($path_srt_cuti, file_get_contents($file_srt_cuti->getRealPath()));
        $upload_srt_pengantar = Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
        $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));


        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_srt_cuti && $upload_srt_pengantar && $upload_spp && $upload_ktm)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-10'
          $id_infrm = DB::table('frm-10')->insertGetId(
              [
                'srt_cuti' => $path_srt_cuti,
                'srt_pengantar' => $path_srt_pengantar,
                'spp' => $path_spp,
                'ktm' => $path_ktm
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Cuti Akademik";
          $kode_frm = "FRM-10";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 11
  public function submitRequest11(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_cuti') && $request->hasFile('srt_pengantar') && $request->hasFile('spp') && $request->hasFile('ktm'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_cuti = $request->file('srt_cuti');
        $file_srt_pengantar = $request->file('srt_pengantar');
        $file_spp = $request->file('spp');
        $file_ktm = $request->file('ktm');

        $cuti_ext = $this->checkExtention($file_srt_cuti);
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $spp_ext = $this->checkExtention($file_spp);
        $ktm_ext = $this->checkExtention($file_ktm);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_srt_cuti = "lampiran".'/'.$nim.'/'."Surat Cuti - frm11".'.'.$cuti_ext;
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm11".'.'.$pengantar_ext;
        $path_spp = "lampiran".'/'.$nim.'/'."SPP - frm11".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM - frm11".'.'.$ktm_ext;

        $upload_srt_cuti = 0;
        $upload_srt_pengantar = 0;
        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_srt_cuti = Storage::put($path_srt_cuti, file_get_contents($file_srt_cuti->getRealPath()));

        $upload_srt_pengantar = Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));

        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));

        $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_srt_cuti && $upload_srt_pengantar && $upload_spp && $upload_ktm)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-11'
          $id_infrm = DB::table('frm-11')->insertGetId(
              [
                'srt_cuti' => $path_srt_cuti,
                'srt_pengantar' => $path_srt_pengantar,
                'spp' => $path_spp,
                'ktm' => $path_ktm
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Aktif Kembali";
          $kode_frm = "FRM-11";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    // {
    //   Session::flash('success', 'Berhasil ^_^');
    //   return redirect()->back();
    // }
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 12
  public function submitRequest12(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_undurdiri') && $request->hasFile('srt_pengantar'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_undurdiri = $request->file('srt_undurdiri');
        $file_srt_pengantar = $request->file('srt_pengantar');

        $undurdiri_ext = $this->checkExtention($file_srt_undurdiri);
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_srt_undurdiri = "lampiran".'/'.$nim.'/'."Surat Permohonan Undur Diri Dari Mahasiswa dan Orangtua Wali - frm12".'.'.$undurdiri_ext;
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm12".'.'.$pengantar_ext;

        $upload_srt_undurdiri = 0;
        $upload_srt_pengantar = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_srt_undurdiri = Storage::put($path_srt_undurdiri, file_get_contents($file_srt_undurdiri->getRealPath()));

        $upload_srt_pengantar = Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_srt_undurdiri && $upload_srt_pengantar)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-12'
          $id_infrm = DB::table('frm-12')->insertGetId(
              [
                'srt_undurdiri' => $path_srt_undurdiri,
                'srt_pengantar' => $path_srt_pengantar
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Undur Diri";
          $kode_frm = "FRM-12";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 13
  public function submitRequest13(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_sidkom') && $request->hasFile('spp'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_sidkom = $request->file('srt_sidkom');
        $file_spp = $request->file('spp');

        $sidkom_ext = $this->checkExtention($file_srt_sidkom);
        $spp_ext = $this->checkExtention($file_spp);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_srt_sidkom = "lampiran".'/'.$nim.'/'."Surat Pengajuan Sidang Komisi dari Program Studi - frm13".'.'.$sidkom_ext;
        $path_spp = "lampiran".'/'.$nim.'/'."Bukti Lunas SPP - frm13".'.'.$spp_ext;

        $upload_srt_sidkom = 0;
        $upload_spp = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_srt_sidkom = Storage::put($path_srt_sidkom, file_get_contents($file_srt_sidkom->getRealPath()));

        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_srt_sidkom && $upload_spp)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-13'
          $id_infrm = DB::table('frm-13')->insertGetId(
              [
                'srt_sidkom' => $path_srt_sidkom,
                'spp' => $path_spp
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Sidang Komisi Pasca Sarjana";
          $kode_frm = "FRM-13";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 14
  public function submitRequest14(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_rencanastudi'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_rencanastudi = $request->file('srt_rencanastudi');

        $studi_ext = $this->checkExtention($file_srt_rencanastudi);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_srt_rencanastudi = "lampiran".'/'.$nim.'/'."Surat Pernyataan Rencana Penyelesaian Studi - frm14".'.'.$studi_ext;

        $upload_srt_rencanastudi = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_srt_rencanastudi = Storage::put($path_srt_rencanastudi, file_get_contents($file_srt_rencanastudi->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_srt_rencanastudi)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-14'
          $id_infrm = DB::table('frm-14')->insertGetId(
              [
                'srt_rencanastudi' => $path_srt_rencanastudi
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Surat Perpanjangan Studi";
          $kode_frm = "FRM-14";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }
    // {
    //   Session::flash('success', 'Berhasil ^_^');
    //   return redirect()->back();
    // }
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 15
  public function submitRequest15(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('srt_keterangan') && $request->hasFile('foto') && $request->hasFile('spp') && $request->hasFile('lembar_pengesahan') && $request->hasFile('transkrip') && $request->hasFile('bayar_wisuda'))
    {
      // cek kuisioner tingkat kepuasan layanan sudah diisi atau belum
      $chek_questionnaire = Satisfaction::where('nim', $request['nim'])->first();
      $chek_graduate = Biodata::where('nim', $request['nim'])->first();
      if ((sizeof($chek_questionnaire) > 0) && (sizeof($chek_graduate) > 0)) {
        return DB::transaction(function($request) use($request)
        {
          $nim = $request['nim'];

          //ambil file dr request
          $file_srt_keterangan = $request->file('srt_keterangan');
          $file_foto = $request->file('foto');
          $file_spp = $request->file('spp');
          $file_lembar_pengesahan = $request->file('lembar_pengesahan');
          $file_transkrip = $request->file('transkrip');
          $file_bayar_wisuda = $request->file('bayar_wisuda');

          $ket_ext = $this->checkExtention($file_srt_keterangan);
          $fot_ext = $this->checkExtention($file_foto);
          $spp_ext = $this->checkExtention($file_spp);
          $lbr_ext = $this->checkExtention($file_lembar_pengesahan);
          $tra_ext = $this->checkExtention($file_transkrip);
          $byr_ext = $this->checkExtention($file_bayar_wisuda);

          //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
          $path_srt_keterangan = "lampiran".'/'.$nim.'/'."Surat keterangan dari Ketua Departemen - frm15".'.'.$ket_ext;
          $path_foto = "lampiran".'/'.$nim.'/'."Pas Foto - frm15".'.'.$fot_ext;
          $path_spp = "lampiran".'/'.$nim.'/'."Bukti Pembayaran SPP - frm15".'.'.$spp_ext;
          $path_lembar_pengesahan = "lampiran".'/'.$nim.'/'."Lembar Pengesahan Skripsi - frm15".'.'.$lbr_ext;
          $path_transkrip = "lampiran".'/'.$nim.'/'."Transkrip Kumulatif dari Departemen - frm15".'.'.$tra_ext;
          $path_bayar_wisuda = "lampiran".'/'.$nim.'/'."Bukti Pembayaran Wisuda - frm15".'.'.$byr_ext;

          $upload_srt_keterangan = 0;
          $upload_foto = 0;
          $upload_spp = 0;
          $upload_lembar_pengesahan = 0;
          $upload_transkrip = 0;
          $upload_bayar_wisuda = 0;

          //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
            //jika Storage::put berahasil, maka akan mengembalikan nilai true

          $upload_srt_keterangan = Storage::put($path_srt_keterangan, file_get_contents($file_srt_keterangan->getRealPath()));

          $upload_foto = Storage::put($path_foto, file_get_contents($file_foto->getRealPath()));

          $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));

          $upload_lembar_pengesahan = Storage::put($path_lembar_pengesahan, file_get_contents($file_lembar_pengesahan->getRealPath()));

          if(!Storage::exists($path_transkrip)) { //kalau file belum ada, maka upload
            $upload_transkrip = Storage::put($path_transkrip, file_get_contents($file_transkrip->getRealPath()));
          } else $upload_transkrip = 1; //kalau udh ada, kasih keterangan 'file ada'

          if(!Storage::exists($path_bayar_wisuda)) { //kalau file belum ada, maka upload
            $upload_bayar_wisuda = Storage::put($path_bayar_wisuda, file_get_contents($file_bayar_wisuda->getRealPath()));
          } else $upload_bayar_wisuda = 1; //kalau udh ada, kasih keterangan 'file ada'

          //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
          if ($upload_srt_keterangan && $upload_foto && $upload_spp && $upload_lembar_pengesahan && $upload_transkrip && $upload_bayar_wisuda)
          {
            $applicant = $this->checkApplicant($request);

            // save di table 'frm-15'
            $id_infrm = DB::table('frm-15')->insertGetId(
                [
                  'foto' => $path_foto,
                  'srt_keterangan' => $path_srt_keterangan,
                  'spp' => $path_spp,
                  'transkrip' => $path_transkrip,
                  'lbr_pengesahan' => $path_lembar_pengesahan,
                  'byr_wisuda' => $path_bayar_wisuda
                ]
              );
            // save di table 'information'
            $info = new Information();
            $info->adm_keterangan = "";
            $info->adm_catatan_tinjut = "";
            $info->save();
            $info_id = $info->id;

            $jenis_frm = "Surat Keterangan Lulus";
            $kode_frm = "FRM-15";

            $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

            $info = Information::find($info_id);
            $info->application_id = $application_id;
            $info->update();

            return redirect()->route('status_permohonan');
          }
        });
      }
      else {
        Session::flash('warning', 'Anda belum mengisi kuisioner tingkat kepuasan layanan / pendataan lulusan, silahkan isi untuk melanjutkan');
        return redirect()->back()->withInput();
      }
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 16
  public function submitRequest16(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('skl') && $request->hasFile('bayar_wisuda'))
    {
      // cek kuisioner tingkat kepuasan layanan sudah diisi atau belum
      $chek_questionnaire = Satisfaction::where('nim', $request['nim'])->first();
      if (sizeof($chek_questionnaire) > 0)
      {
        return DB::transaction(function($request) use($request)
        {
          $nim = $request['nim'];

          //ambil file dr request
          $file_skl = $request->file('skl');
          $file_bayar_wisuda = $request->file('bayar_wisuda');

          $skl_ext = $this->checkExtention($file_skl);
          $byr_ext = $this->checkExtention($file_bayar_wisuda);

          //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
          $path_skl = "lampiran".'/'.$nim.'/'."Scan Surat Keterangan Lulus Sarjana - frm16".'.'.$skl_ext;
          $path_bayar_wisuda = "lampiran".'/'.$nim.'/'."Bukti Pembayaran Wisuda - frm16".'.'.$byr_ext;

          $upload_skl = 0;
          $upload_bayar_wisuda = 0;

          //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
            //jika Storage::put berahasil, maka akan mengembalikan nilai true

          $upload_skl = Storage::put($path_skl, file_get_contents($file_skl->getRealPath()));

          $upload_bayar_wisuda = Storage::put($path_bayar_wisuda, file_get_contents($file_bayar_wisuda->getRealPath()));

          //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
          if ($upload_skl && $upload_bayar_wisuda)
          {
            $applicant = $this->checkApplicant($request);

            // save di table 'frm-16'
            $id_infrm = DB::table('frm-16')->insertGetId(
                [
                  'skl' => $path_skl,
                  'byr_wisuda' => $path_bayar_wisuda
                ]
              );
            // save di table 'information'
            $info = new Information();
            $info->adm_keterangan = "";
            $info->adm_catatan_tinjut = "";
            $info->save();
            $info_id = $info->id;

            $jenis_frm = "Surat Percepatan Ijazah";
            $kode_frm = "FRM-16";

            $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

            $info = Information::find($info_id);
            $info->application_id = $application_id;
            $info->update();

            return redirect()->route('status_permohonan');
          }
        });
      }
      else
      {
        Session::flash('warning', 'Anda belum mengisi pendataan wisuda, silahkan isi pendataan wisuda untuk melanjutkan');
        return redirect()->back()->withInput();
      }
    }
    
    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }

  // frm 17 -> cek sebelumnya pernah upload legalisir juga ga? kalau pernah tambah keterangan file ke berapa (#?)
  public function submitRequest17(Request $request)
  {
    $this->validateForm($request);

    if ($request->hasFile('foto'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_foto = $request->file('foto');
        
        $foto_ext = $this->checkExtention($file_foto);

        //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
        $path_foto = "lampiran".'/'.$nim.'/'."Dokumen Legalisir".'.'.$foto_ext;

        $upload_foto = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true

        $upload_foto = Storage::put($path_foto, file_get_contents($file_foto->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_foto)
        {
          $applicant = $this->checkApplicant($request);

          // save di table 'frm-17'
          $id_infrm = DB::table('frm-17')->insertGetId(
              [
                'banyaknya' => $request['banyaknya'],
                'foto' => $path_foto
              ]
            );
          // save di table 'information'
          $info = new Information();
          $info->adm_keterangan = "";
          $info->adm_catatan_tinjut = "";
          $info->save();
          $info_id = $info->id;

          $jenis_frm = "Legalisir";
          $kode_frm = "FRM-17";

          $application_id = $this->makeNewApplication($jenis_frm, $kode_frm, $id_infrm, $applicant, $request, $info_id, $nim);

          $info = Information::find($info_id);
          $info->application_id = $application_id;
          $info->update();

          return redirect()->route('status_permohonan');
        }
      });
    }

    else
    {
      Session::flash('warning', 'Submit formulir gagal. Ada dokumen persyaratan yang belum diupload, silahkan periksa kembali isian kelengkapan berkas');
      return redirect()->back()->withInput();
    }
  }


  /// LINK UPDATE REQUEST
  public function updatefrm($id)
  {
    $kode_frm = Application::where('id', $id)->pluck('kode_frm');
    $form = Application::where('id', $id)->first();
    $info = Information::where('id', $form->information_id)->first();
    $adm_keterangan = $info->adm_keterangan;

    if($kode_frm == '["FRM-09a"]') {
      $lampiran = DB::table('frm-09a')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm09a_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-09b"]') {
      $lampiran = DB::table('frm-09b')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm09b_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-10"]') {
      $lampiran = DB::table('frm-10')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm10_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-11"]') {
      $lampiran = DB::table('frm-11')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm11_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-12"]') {
      $lampiran = DB::table('frm-12')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm12_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-13"]') {
      $lampiran = DB::table('frm-13')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm13_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-14"]') {
      $lampiran = DB::table('frm-14')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm14_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-15"]') {
      $lampiran = DB::table('frm-15')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm15_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-16"]') {
      $lampiran = DB::table('frm-16')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm16_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
    elseif($kode_frm == '["FRM-17"]') {
      $lampiran = DB::table('frm-17')->where('id', $form->id_infrm)->first();
      return view('mahasiswa.frm.frm17_update', ['id' => $id, 'form' => $form, 'lampiran' => $lampiran, 'adm_keterangan' => $adm_keterangan]);
    }
  }


  // delete and put new file to update form
  public function deleteAndPutFile($nim, $delete_path, $file, $nama_file, $alias, $frm, $id_infrm)
  {
    // $n_file = strtolower($nama_file);
    Storage::delete($delete_path);
    $extention = $this->checkExtention($file);
    $path = "lampiran".'/'.$nim.'/'.$nama_file." - ".$frm.'.'.$extention;
    Storage::put($path, file_get_contents($file->getRealPath()));
    DB::table($frm)->where('id', $id_infrm)->update([$alias => $path]);
    return 1;
  }

  public function updateInfo($id)
  {
    $info = Information::find($id);
    $info->adm_keterangan = '';
    $info->update();
    return 0;
  }

  /// UPDATE OLD REQUEST
  // update frm 09a
  public function updateRequest09a(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-09a')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_surat = $request->file('surat');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('surat')){
        Storage::delete($lamp->surat);
        $surat_ext = $this->checkExtention($file_surat);
        if ($lamp->jenis_permohonan == 'Beasiswa') {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Rekomendasi - frm09a".'.'.$surat_ext;
        }
        elseif ($lamp->jenis_permohonan == 'Pembuatan Visa') {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Pengantar - frm09a".'.'.$surat_ext;
        }
        else {
          $path_surat = "lampiran".'/'.$nim.'/'."Surat Keterangan - frm09a".'.'.$surat_ext;
        }
        Storage::put($path_surat, file_get_contents($file_surat->getRealPath()));
        DB::table('frm-09a')->where('id', $id_infrm)->update(['surat' => $path_surat]);
      }
      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "SPP", $alias = "spp", $frm = "frm-09a", $id_infrm);
      }
      if ($request->hasFile('ktm')){
        $this->deleteAndPutFile($nim, $lamp->ktm, $file_ktm, $nama = "KTM", $alias = "ktm", $frm = "frm-09a", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 09b
  public function updateRequest09b(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $this->validate($request, [
        'nama_ortu' => 'required',
        'nip' => 'required|digits:18',
        'pangkat' => 'required',
        'instansi' => 'required',
        'telp_ortu' => 'required|min:10|max:13|regex:/(08)[0-9]/'
      ]);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-09b')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "SPP", $alias = "spp", $frm = "frm-09b", $id_infrm);
      }
      if ($request->hasFile('ktm')){
        $this->deleteAndPutFile($nim, $lamp->ktm, $file_ktm, $nama = "KTM", $alias = "ktm", $frm = "frm-09b", $id_infrm);
      }

      DB::table('frm-09b')->where('id', $id_infrm)->update(['nama_ortu' => $request['nama_ortu'], 'nip' => $request['nip'], 'pangkat' => $request['pangkat'], 'instansi' => $request['instansi'], 'telp_ortu' => $request['telp_ortu']]);

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 10
  public function updateRequest10(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-10')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_cuti = $request->file('srt_cuti');
      $file_srt_pengantar = $request->file('srt_pengantar');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('srt_cuti')){
        $this->deleteAndPutFile($nim, $lamp->srt_cuti, $file_srt_cuti, $nama = "Surat Cuti", $alias = "srt_cuti", $frm = "frm-10", $id_infrm);
      }
      if ($request->hasFile('srt_pengantar')){
        $this->deleteAndPutFile($nim, $lamp->srt_pengantar, $file_srt_pengantar, $nama = "Surat Pengantar", $alias = "srt_pengantar", $frm = "frm-10", $id_infrm);
      }
      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "SPP", $alias = "spp", $frm = "frm-10", $id_infrm);
      }
      if ($request->hasFile('ktm')){
        $this->deleteAndPutFile($nim, $lamp->ktm, $file_ktm, $nama = "KTM", $alias = "ktm", $frm = "frm-10", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 11
  public function updateRequest11(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-11')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_cuti = $request->file('srt_cuti');
      $file_srt_pengantar = $request->file('srt_pengantar');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('srt_cuti')){
        $this->deleteAndPutFile($nim, $lamp->srt_cuti, $file_srt_cuti, $nama = "Surat Cuti", $alias = "srt_cuti", $frm = "frm-11", $id_infrm);
      }
      if ($request->hasFile('srt_pengantar')){
        $this->deleteAndPutFile($nim, $lamp->srt_pengantar, $file_srt_pengantar, $nama = "Surat Pengantar", $alias = "srt_pengantar", $frm = "frm-11", $id_infrm);
      }
      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "SPP", $alias = "spp", $frm = "frm-11", $id_infrm);
      }
      if ($request->hasFile('ktm')){
        $this->deleteAndPutFile($nim, $lamp->ktm, $file_ktm, $nama = "KTM", $alias = "ktm", $frm = "frm-11", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 12
  public function updateRequest12(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-12')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_undurdiri = $request->file('srt_undurdiri');
      $file_srt_pengantar = $request->file('srt_pengantar');
      
      if ($request->hasFile('srt_undurdiri')){
        $this->deleteAndPutFile($nim, $lamp->srt_undurdiri, $file_srt_undurdiri, $nama = "Surat Permohonan Undur Diri Dari Mahasiswa dan Orangtua Wali", $alias = "srt_undurdiri", $frm = "frm-12", $id_infrm);
      }
      if ($request->hasFile('srt_pengantar')){
        $this->deleteAndPutFile($nim, $lamp->srt_pengantar, $file_srt_pengantar, $nama = "Surat Pengantar", $alias = "srt_pengantar", $frm = "frm-12", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 13
  public function updateRequest13(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-13')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_sidkom = $request->file('srt_sidkom');
      $file_spp = $request->file('spp');

      if ($request->hasFile('srt_sidkom')){
        $this->deleteAndPutFile($nim, $lamp->srt_sidkom, $file_srt_sidkom, $nama = "Surat Pengajuan Sidang Komisi dari Program Studi", $alias = "srt_sidkom", $frm = "frm-13", $id_infrm);
      }
      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "Bukti Lunas SPP", $alias = "spp", $frm = "frm-13", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 14
  public function updateRequest14(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-14')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_rencanastudi = $request->file('srt_rencanastudi');

      if ($request->hasFile('srt_rencanastudi')){
        $this->deleteAndPutFile($nim, $lamp->srt_rencanastudi, $file_srt_rencanastudi, $nama = "Surat Pernyataan Rencana Penyelesaian Studi", $alias = "srt_rencanastudi", $frm = "frm-14", $id_infrm);
      }
      
      return redirect()->route('status_permohonan');
    });
  }

  // update frm 15
  public function updateRequest15(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-15')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_keterangan = $request->file('srt_keterangan');
      $file_foto = $request->file('foto');
      $file_spp = $request->file('spp');
      $file_lembar_pengesahan = $request->file('lembar_pengesahan');
      $file_transkrip = $request->file('transkrip');
      $file_bayar_wisuda = $request->file('bayar_wisuda');

      if ($request->hasFile('srt_keterangan')){
        $this->deleteAndPutFile($nim, $lamp->srt_keterangan, $file_srt_keterangan, $nama = "Surat keterangan dari Ketua Departemen", $alias = "srt_keterangan", $frm = "frm-15", $id_infrm);
      }
      if ($request->hasFile('foto')){
        $this->deleteAndPutFile($nim, $lamp->foto, $file_foto, $nama = "Pas Foto", $alias = "foto", $frm = "frm-15", $id_infrm);
      }
      if ($request->hasFile('spp')){
        $this->deleteAndPutFile($nim, $lamp->spp, $file_spp, $nama = "Bukti Pembayaran SPP", $alias = "spp", $frm = "frm-15", $id_infrm);
      }
      if ($request->hasFile('lembar_pengesahan')){
        $this->deleteAndPutFile($nim, $lamp->lbr_pengesahan, $file_lembar_pengesahan, $nama = "Lembar Pengesahan Skripsi", $alias = "lbr_pengesahan", $frm = "frm-15", $id_infrm);
      }
      if ($request->hasFile('transkrip')){
        $this->deleteAndPutFile($nim, $lamp->transkrip, $file_transkrip, $nama = "Transkrip Kumulatif dari Departemen", $alias = "transkrip", $frm = "frm-15", $id_infrm);
      }
      if ($request->hasFile('bayar_wisuda')){
        $this->deleteAndPutFile($nim, $lamp->byr_wisuda, $file_bayar_wisuda, $nama = "Bukti Pembayaran Wisuda", $alias = "byr_wisuda", $frm = "frm-15", $id_infrm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 16
  public function updateRequest16(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-16')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_skl = $request->file('skl');
      $file_bayar_wisuda = $request->file('bayar_wisuda');

      if ($request->hasFile('skl')){
        $this->deleteAndPutFile($nim, $lamp->skl, $file_skl, $nama = "Surat Cuti", $alias = "skl", $frm = "frm-16", $id_infrm);
      }
      if ($request->hasFile('bayar_wisuda')){
        $this->deleteAndPutFile($nim, $lamp->byr_wisuda, $file_bayar_wisuda, $nama = "Bukti Pembayaran Wisuda", $alias = "byr_wisuda", $frm = "frm-16", $id_infrm);
      }
     
      return redirect()->route('status_permohonan');
    });
  }

  // update frm 17
  public function updateRequest17(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validateForm($request);

      $applicant = $this->updateApplicant($request);
      $id_infrm = $this->updateApplication($request);
      $result = Application::where('id', $request['id'])->first();
      $id_infrm = $result->id_infrm;
      $id_info = $result->information_id;
      $this->updateInfo($id_info);

      $lamp = DB::table('frm-17')->where('id', $id_infrm)->first();

      $nim = $request['nim'];

      //ambil file dr request
      $file_foto = $request->file('foto');

      if ($request->hasFile('foto')){
        $this->deleteAndPutFile($nim, $lamp->foto, $file_foto, $nama = "Dokumen Legalisir", $alias = "foto", $frm = "frm-17", $id_infrm);
      }
      DB::table('frm-17')->where('id', $id_infrm)->update(['banyaknya' => $request['banyaknya']]);

      return redirect()->route('status_permohonan');
    });
  }

  public function deleteRequest(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $id = $request['id'];
      $form_hapus = Application::where('id', $id)->first();
      $kode_frm = strtolower($form_hapus->kode_frm);
      $lampiran = DB::table($kode_frm)->where('id', $form_hapus->id_infrm)->first();
      
      if ($kode_frm == 'frm-09a') {
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->ktm);
        Storage::delete($lampiran->surat);
      }
      elseif ($kode_frm == 'frm-09b') {
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->ktm);
      }
      elseif ($kode_frm == 'frm-10') {
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->ktm);
        Storage::delete($lampiran->srt_pengantar);
        Storage::delete($lampiran->srt_cuti);
      }
      elseif ($kode_frm == 'frm-11') {
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->ktm);
        Storage::delete($lampiran->srt_pengantar);
        Storage::delete($lampiran->srt_cuti);
      }
      elseif ($kode_frm == 'frm-12') {
        Storage::delete($lampiran->srt_pengantar);
        Storage::delete($lampiran->srt_undurdiri);
      }
      elseif ($kode_frm == 'frm-13') {
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->srt_sidkom);
      }
      elseif ($kode_frm == 'frm-14') {
        Storage::delete($lampiran->srt_rencanastudi);
      }
      elseif ($kode_frm == 'frm-15') {
        Storage::delete($lampiran->srt_keterangan);
        Storage::delete($lampiran->spp);
        Storage::delete($lampiran->transkrip);
        Storage::delete($lampiran->lbr_pengesahan);
        Storage::delete($lampiran->foto);
        Storage::delete($lampiran->byr_wisuda);
      }
      elseif ($kode_frm == 'frm-16') {
        Storage::delete($lampiran->skl);
        Storage::delete($lampiran->byr_wisuda);
      }
      elseif ($kode_frm == 'frm-17') {
        Storage::delete($lampiran->foto);
      }

      // hapus lampiran di database
      DB::table($kode_frm)->where('id', $form_hapus->id_infrm)->delete();
      //hapus informasi di database
      Information::where('id', $form_hapus->information_id)->delete();
      //hapus data formulir di table application
      Application::where('id', $id)->delete();

      return redirect()->back();
    });
  }

  public function markAsRead()
  {
    foreach (\App\User::find(Session::get('id'))->unreadnotifications as $note)
    {
      $note->markAsRead();
    }
  }
}


  /*
  // check frm 09a
  public function checkFrm09aIsFill()
  {
    $id = Session::get('id');
    $isfill = Application::where('applicant_id', $id)->where('kode_frm', 'FRM-09a')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm09a', ['isfill' => $isfill]);
  }

  // check frm 09b
  public function checkFrm09bIsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-09b')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm09b', ['isfill' => $isfill]);
  }

  // check frm 10
  public function checkFrm10IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-10')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm10', ['isfill' => $isfill]);
  }

  // check frm 11
  public function checkFrm11IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-11')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm11', ['isfill' => $isfill]);
  }

  // check frm 12
  public function checkFrm12IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-12')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm12', ['isfill' => $isfill]);
  }

  // check frm 13
  public function checkFrm13IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-13')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm13', ['isfill' => $isfill]);
  }

  // check frm 14
  public function checkFrm14IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-14')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm14', ['isfill' => $isfill]);
  }

  // check frm 15
  public function checkFrm15IsFill()
  {
    $nim = Session::get('nim');
    $frmisfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-15')->where('status', '<>', 'telah selesai')->first();
    $questionisfill = Satisfaction::where('nim', $nim)->first();
    $gd_isfill = Graduate::where('nim', $nim)->first();
    return view('mahasiswa.frm.frm15', ['frmisfill' => $frmisfill, 'questionisfill' => $questionisfill, 'gd_isfill' => $gd_isfill]);
  }

  // check frm 16
  public function checkFrm16IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-16')->where('status', '<>', 'telah selesai')->first();
    $gd_isfill = Graduate::where('nim', $nim)->first();
    return view('mahasiswa.frm.frm16', ['isfill' => $isfill, 'gd_isfill' => $gd_isfill]);
  }

  // check frm 17
  public function checkFrm17IsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-17')->where('status', '<>', 'telah selesai')->first();
    return view('mahasiswa.frm.frm17', ['isfill' => $isfill]);
  }
  */
