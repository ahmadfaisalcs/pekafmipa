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

use Carbon\Carbon;

/**
 *
 */
class StdRequestController extends Controller
{
  /// Student Dashboard
  public function studentDashboard()
  {
    $user = Session::get('nim');
    $requests = Form::where('nim', $user)->orderBy('updated_at', 'desc')->get();
    $callout = Form::where('nim', $user)->where('status', 'Pengecekan kelengkapan berkas')->first();
    $isexist = sizeof($requests);
    // echo $user; echo "   "; echo $requests; echo "   "; echo $callout; echo "   "; echo $isexist;
    return view('mahasiswa.dashboard', ['requests' => $requests, 'count' => 1, 'callout' => $callout, 'isexist' => $isexist]);
  }

  /// UNTUK FRM 09a - 17
  // check frm 09a
  public function checkFrm09aIsFill()
  {
    $nim = Session::get('nim');
    $isfill = Form::where('nim', $nim)->where('kode_frm', 'FRM-09a')->where('status', '<>', 'telah selesai')->first();
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

  /// SUBMIT REQUEST
  // frm 09a
  public function submitRequest09a(Request $request)
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

    if (($request->hasFile('srt_pengantar') or $request->hasFile('srt_rekomen')) && $request->hasFile('spp') && $request->hasFile('ktm'))
    // if ($request->hasFile('srt_pengantar'))
    {
      return DB::transaction(function($request) use($request)
      {
        $nim = $request['nim'];

        //ambil file dr request
        $file_srt_pengantar = $request->file('srt_pengantar');
        $file_srt_rekomen = $request->file('srt_rekomen');
        $file_spp = $request->file('spp');
        $file_ktm = $request->file('ktm');
      
        if($request->hasFile('srt_pengantar')){
          $srt_pengantar_ext = $this->checkExtention($file_srt_pengantar);
          //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
          $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm09a".'.'.$srt_pengantar_ext;
        }
        if($request->hasFile('srt_rekomen')){
          $srt_rekomen_ext = $this->checkExtention($file_srt_rekomen);
          $path_srt_rekomen = "lampiran".'/'.$nim.'/'."Surat Rekomendasi dari Departemen - frm09a".'.'.$srt_rekomen_ext;
        }

        $spp_ext = $this->checkExtention($file_spp);
        $ktm_ext = $this->checkExtention($file_ktm);

        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;

        $upload_srt_pengantar = 0;
        $upload_srt_rekomen = 0;
        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //  jika Storage::put berahasil, maka akan mengembalikan nilai true
        if ($request->hasFile('srt_pengantar')){
          $upload_srt_pengantar = Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
        }

        if ($request->hasFile('srt_rekomen')){
          $upload_srt_rekomen = Storage::put ($path_srt_rekomen, file_get_contents($file_srt_rekomen->getRealPath()));
        }

        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));

        $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));


        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if (($upload_srt_pengantar or $upload_srt_rekomen) && $upload_spp && $upload_ktm)
        {
          $frm = new Form();

          $frm->jenis_frm = "Surat Keterangan";
          $frm->kode_frm = "FRM-09a";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          if ($request->hasFile('srt_pengantar')){
            $frm->srt_pengantar = $path_srt_pengantar;
          }
          if ($request->hasFile('srt_rekomen')){
            $frm->srt_rekomen = $path_srt_rekomen;
          }
          $frm->spp = $path_spp;
          $frm->ktm = $path_ktm;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

          return redirect()->route('status_permohonan');
          // echo $input_date;
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

  // frm 09b
  public function submitRequest09b(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email',

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
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;

        $upload_spp = 0;
        $upload_ktm = 0;

        //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
          //jika Storage::put berahasil, maka akan mengembalikan nilai true
        $upload_spp = Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
        $upload_ktm = Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));

        //kalau semua file tersimpan di folder sistem, lakukan pengisian database:
        if ($upload_spp && $upload_ktm)
        {
          $frm = new Form();

          $frm->jenis_frm = "Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak";
          $frm->kode_frm = "FRM-09b";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->nama_ortu = $request['nama_ortu'];
          $frm->nip = $request['nip'];
          $frm->pangkat = $request['pangkat'];
          $frm->instansi = $request['instansi'];
          $frm->telp_ortu = $request['telp_ortu'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->spp = $path_spp;
          $frm->ktm = $path_ktm;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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

  // frm 10
  public function submitRequest10(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;

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
          $frm = new Form();

          $frm->jenis_frm = "Surat Cuti Akademik";
          $frm->kode_frm = "FRM-10";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->srt_cuti = $path_srt_cuti;
          $frm->srt_pengantar = $path_srt_pengantar;
          $frm->spp = $path_spp;
          $frm->ktm = $path_ktm;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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

  // frm 11
  public function submitRequest11(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;

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
          $frm = new Form();

          $frm->jenis_frm = "Surat Aktif Kembali";
          $frm->kode_frm = "FRM-11";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->srt_cuti = $path_srt_cuti;
          $frm->srt_pengantar = $path_srt_pengantar;
          $frm->spp = $path_spp;
          $frm->ktm = $path_ktm;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
          $frm = new Form();

          $frm->jenis_frm = "Surat Undur Diri";
          $frm->kode_frm = "FRM-12";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->srt_undurdiri = $path_srt_undurdiri;
          $frm->srt_pengantar = $path_srt_pengantar;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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

  // frm 13
  public function submitRequest13(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
          $frm = new Form();

          $frm->jenis_frm = "Surat Sidang Komisi Pasca Sarjana";
          $frm->kode_frm = "FRM-13";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->srt_sidkom = $path_srt_sidkom;
          $frm->spp = $path_spp;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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

  // frm 14
  public function submitRequest14(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
          $frm = new Form();

          $frm->jenis_frm = "Surat Perpanjangan Studi";
          $frm->kode_frm = "FRM-14";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->semester = $request['semester'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->srt_rencanastudi = $path_srt_rencanastudi;
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

    if ($request->hasFile('srt_keterangan') && $request->hasFile('foto') && $request->hasFile('spp') && $request->hasFile('lembar_pengesahan') && $request->hasFile('transkrip') && $request->hasFile('bayar_wisuda'))
    {
      // cek kuisioner tingkat kepuasan layanan sudah diisi atau belum
      $chek_questionnaire = Satisfaction::where('nim', $request['nim'])->first();
      $chek_graduate = Graduate::where('nim', $request['nim'])->first();
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
            $frm = new Form();

            $frm->jenis_frm = "Surat Keterangan Lulus";
            $frm->kode_frm = "FRM-15";
            $frm->nama = $request['nama'];
            $frm->nim = $request['nim'];
            $frm->prodi = $request['program_studi'];
            $frm->semester = $request['semester'];
            $frm->keperluan = $request['utk_keperluan'];
            $frm->telp = $request['telp'];
            $frm->email = $request['email'];

            $frm->srt_keterangan = $path_srt_keterangan;
            $frm->foto = $path_foto;
            $frm->spp = $path_spp;
            $frm->lbr_pengesahan = $path_lembar_pengesahan;
            $frm->transkrip = $path_transkrip;
            $frm->byr_wisuda = $path_bayar_wisuda;

            $frm->adm_keterangan = "";
            $frm->adm_catatan_tinjut = "";

            $frm->status = 'Berhasil diupload';

            $input_date = $this->checkRequestDate($nim);

            $frm->changed_at = $input_date;
            $frm->updated_at = $input_date;

            if($frm->save())
            {
              $this->pushNotifToAdm($frm);
            }

            return redirect()->route('status_permohonan');
          }
        });
      }
      else {
        Session::flash('warning', 'Anda belum mengisi kuisioner tingkat kepuasan layanan / pendataan wisuda, silahkan isi untuk melanjutkan');
        return redirect()->back()->withInput();
      }
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

  // frm 16
  public function submitRequest16(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'semester' => 'required|numeric|max:16',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
            $frm = new Form();

            $frm->jenis_frm = "Surat Percepatan Ijazah";
            $frm->kode_frm = "FRM-16";
            $frm->nama = $request['nama'];
            $frm->nim = $request['nim'];
            $frm->prodi = $request['program_studi'];
            $frm->semester = $request['semester'];
            $frm->keperluan = $request['utk_keperluan'];
            $frm->telp = $request['telp'];
            $frm->email = $request['email'];

            $frm->adm_keterangan = "";
            $frm->adm_catatan_tinjut = "";

            $frm->skl = $path_skl;
            $frm->byr_wisuda = $path_bayar_wisuda;
            $frm->status = 'Berhasil diupload';

            $input_date = $this->checkRequestDate($nim);

            $frm->changed_at = $input_date;
            $frm->updated_at = $input_date;

            if($frm->save())
            {
              $this->pushNotifToAdm($frm);
            }

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

  // frm 17 -> cek sebelumnya pernah upload legalisir juga ga? kalau pernah tambah keterangan file ke berapa (#?)
  public function submitRequest17(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'program_studi' => 'required',
      'utk_keperluan' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'email' => 'required|email'
    ]);

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
          $frm = new Form();

          $frm->jenis_frm = "Legalisir";
          $frm->kode_frm = "FRM-17";
          $frm->nama = $request['nama'];
          $frm->nim = $request['nim'];
          $frm->prodi = $request['program_studi'];
          $frm->keperluan = $request['utk_keperluan'];
          $frm->telp = $request['telp'];
          $frm->email = $request['email'];

          $frm->adm_keterangan = "";
          $frm->adm_catatan_tinjut = "";

          $frm->foto = $path_foto;
          $frm->banyaknya = $request['banyaknya'];
          $frm->status = 'Berhasil diupload';

          $input_date = $this->checkRequestDate($nim);

          $frm->changed_at = $input_date;
          $frm->updated_at = $input_date;

          if($frm->save())
          {
            $this->pushNotifToAdm($frm);
          }

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


  /// LINK UPDATE REQUEST
  public function updatefrm($id)
  {
    $kode_frm = Form::where('id', $id)->pluck('kode_frm');
    $form = Form::where('id', $id)->first();

    if($kode_frm == '["FRM-09a"]') {
      return view('mahasiswa.frm.frm09a_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-09b"]') {
      return view('mahasiswa.frm.frm09b_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-10"]') {
      return view('mahasiswa.frm.frm10_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-11"]') {
      return view('mahasiswa.frm.frm11_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-12"]') {
      return view('mahasiswa.frm.frm12_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-13"]') {
      return view('mahasiswa.frm.frm13_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-14"]') {
      return view('mahasiswa.frm.frm14_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-15"]') {
      return view('mahasiswa.frm.frm15_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-16"]') {
      return view('mahasiswa.frm.frm16_update', ['id' => $id, 'form' => $form]);
    }
    elseif($kode_frm == '["FRM-17"]') {
      return view('mahasiswa.frm.frm17_update', ['id' => $id, 'form' => $form]);
    }
  }


  /// UPDATE OLD REQUEST
  // update frm 09a
  public function updateRequest09a(Request $request)
  {
    return DB::transaction(function($request) use($request)
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
      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_pengantar = $request->file('srt_pengantar');
      $file_srt_rekomen = $request->file('srt_rekomen');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('srt_pengantar')){
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar".'.'.$pengantar_ext;
      }
      if ($request->hasFile('srt_rekomen')){
        $rekomen_ext = $this->checkExtention($file_srt_rekomen);
        $path_srt_rekomen = "lampiran".'/'.$nim.'/'."Surat Rekomendasi".'.'.$rekomen_ext;
      }
      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
      }
      if ($request->hasFile('ktm')){
        $ktm_ext = $this->checkExtention($file_ktm);
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;
      }

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true
      if ($request->hasFile('srt_pengantar')){
        Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
      }

      if ($request->hasFile('srt_rekomen')){
        Storage::put($path_srt_rekomen, file_get_contents($file_srt_rekomen->getRealPath()));
      }

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      if ($request->hasFile('ktm')){
        Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_pengantar')){
        $frm->srt_pengantar = $path_srt_pengantar;
      }
      if ($request->hasFile('srt_rekomen')){
        $frm->srt_rekomen = $path_srt_rekomen;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('ktm')){
        $frm->ktm = $path_ktm;
      }
      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 09b
  public function updateRequest09b(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validate($request, [
        'nama' => 'required',
        'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
        'program_studi' => 'required',
        'semester' => 'required|numeric|max:16',
        'utk_keperluan' => 'required',
        'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
        'email' => 'required|email',

        'nama_ortu' => 'required',
        'nip' => 'required|digits:18',
        'pangkat' => 'required',
        'instansi' => 'required',
        'telp_ortu' => 'required|min:10|max:13|regex:/(08)[0-9]/'
      ]);

      $nim = $request['nim'];

      //ambil file dr request
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
      }
      if ($request->hasFile('ktm')){
        $ktm_ext = $this->checkExtention($file_ktm);
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;
      }
      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)

      $upload_spp = 0;
      $upload_ktm = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      if ($request->hasFile('ktm')){
        Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->nama_ortu = $request['nama_ortu'];
      $frm->nip = $request['nip'];
      $frm->pangkat = $request['pangkat'];
      $frm->instansi = $request['instansi'];
      $frm->telp_ortu = $request['telp_ortu'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('ktm')){
        $frm->ktm = $path_ktm;
      }
      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 10
  public function updateRequest10(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_cuti = $request->file('srt_cuti');
      $file_srt_pengantar = $request->file('srt_pengantar');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('srt_cuti')){
        $cuti_ext = $this->checkExtention($file_srt_cuti);
        $path_srt_cuti = "lampiran".'/'.$nim.'/'."Surat Permohonan Cuti Dari Mahasiswa dan Wali - frm10".'.'.$cuti_ext;
      }
      if ($request->hasFile('srt_pengantar')){
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm10".'.'.$pengantar_ext;
      }
      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
      }
      if ($request->hasFile('ktm')){
        $ktm_ext = $this->checkExtention($file_ktm);
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)

      $upload_srt_cuti = 0;
      $upload_srt_pengantar = 0;
      $upload_spp = 0;
      $upload_ktm = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_cuti')){
        Storage::put($path_srt_cuti, file_get_contents($file_srt_cuti->getRealPath()));
      }

      if ($request->hasFile('srt_pengantar')){
        Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
      }

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      if ($request->hasFile('ktm')){
        Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_cuti')){
        $frm->srt_cuti = $path_srt_cuti;
      }
      if ($request->hasFile('srt_pengantar')){
        $frm->srt_pengantar = $path_srt_pengantar;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('ktm')){
        $frm->ktm = $path_ktm;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 11
  public function updateRequest11(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_cuti = $request->file('srt_cuti');
      $file_srt_pengantar = $request->file('srt_pengantar');
      $file_spp = $request->file('spp');
      $file_ktm = $request->file('ktm');

      if ($request->hasFile('srt_cuti')){
        $cuti_ext = $this->checkExtention($file_srt_cuti);
        $path_srt_cuti = "lampiran".'/'.$nim.'/'."Surat Cuti - frm11".'.'.$cuti_ext;
      }
      if ($request->hasFile('srt_pengantar')){
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm11".'.'.$pengantar_ext;
      }
      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."SPP".'.'.$spp_ext;
      }
      if ($request->hasFile('ktm')){
        $ktm_ext = $this->checkExtention($file_ktm);
        $path_ktm = "lampiran".'/'.$nim.'/'."KTM".'.'.$ktm_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)

      $upload_srt_cuti = 0;
      $upload_srt_pengantar = 0;
      $upload_spp = 0;
      $upload_ktm = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_cuti')){
        Storage::put($path_srt_cuti, file_get_contents($file_srt_cuti->getRealPath()));
      }

      if ($request->hasFile('srt_pengantar')){
        Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
      }

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      if ($request->hasFile('ktm')){
        Storage::put($path_ktm, file_get_contents($file_ktm->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_cuti')){
        $frm->srt_cuti = $path_srt_cuti;
      }
      if ($request->hasFile('srt_pengantar')){
        $frm->srt_pengantar = $path_srt_pengantar;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('ktm')){
        $frm->ktm = $path_ktm;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 12
  public function updateRequest12(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_undurdiri = $request->file('srt_undurdiri');
      $file_srt_pengantar = $request->file('srt_pengantar');

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      if ($request->hasFile('srt_undurdiri')){
        $undurdiri_ext = $this->checkExtention($file_srt_undurdiri);
        $path_srt_undurdiri = "lampiran".'/'.$nim.'/'."Surat Permohonan Undur Diri Dari Mahasiswa dan Orangtua Wali - frm12".'.'.$undurdiri_ext;
      }
      if ($request->hasFile('srt_pengantar')){
        $pengantar_ext = $this->checkExtention($file_srt_pengantar);
        $path_srt_pengantar = "lampiran".'/'.$nim.'/'."Surat Pengantar Departemen - frm12".'.'.$pengantar_ext;
      }
      
      $upload_srt_undurdiri = 0;
      $upload_srt_pengantar = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_undurdiri')){
        Storage::put($path_srt_undurdiri, file_get_contents($file_srt_undurdiri->getRealPath()));
      }

      if ($request->hasFile('srt_pengantar')){
        Storage::put($path_srt_pengantar, file_get_contents($file_srt_pengantar->getRealPath()));
      }

      $frm = Form::find($request->id);

      // $frm->jenis_frm = "Surat Keterangan Aktif Kuliah Untuk Tunjangan Anak";
      // $frm->kode_frm = "FRM-09b";
      // $frm->id_mahasiswa = '-';
      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_cuti')){
        $frm->srt_cuti = $path_srt_cuti;
      }
      if ($request->hasFile('srt_pengantar')){
        $frm->srt_pengantar = $path_srt_pengantar;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('ktm')){
        $frm->ktm = $path_ktm;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 13
  public function updateRequest13(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_sidkom = $request->file('srt_sidkom');
      $file_spp = $request->file('spp');

      if ($request->hasFile('srt_sidkom')){
        $sidkom_ext = $this->checkExtention($file_srt_sidkom);
        $path_srt_sidkom = "lampiran".'/'.$nim.'/'."Surat Pengajuan Sidang Komisi dari Program Studi - frm13".'.'.$sidkom_ext;
      }
      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."Bukti Lunas SPP - frm13".'.'.$spp_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      $upload_srt_sidkom = 0;
      $upload_spp = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_sidkom')){
        Storage::put($path_srt_sidkom, file_get_contents($file_srt_sidkom->getRealPath()));
      }

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_sidkom')){
        $frm->srt_sidkom = $path_srt_sidkom;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 14
  public function updateRequest14(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_rencanastudi = $request->file('srt_rencanastudi');

      if ($request->hasFile('srt_rencanastudi')){
        $rencanastudi_ext = $this->checkExtention($file_srt_rencanastudi);
        $path_srt_rencanastudi = "lampiran".'/'.$nim.'/'."Surat Pernyataan Rencana Penyelesaian Studi - frm14".'.'.$rencanastudi_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      $upload_srt_rencanastudi = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_rencanastudi')){
        Storage::put($path_srt_rencanastudi, file_get_contents($file_srt_rencanastudi->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_rencanastudi')){
        $frm->srt_rencanastudi = $path_srt_rencanastudi;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 15
  public function updateRequest15(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_srt_keterangan = $request->file('srt_keterangan');
      $file_foto = $request->file('foto');
      $file_spp = $request->file('spp');
      $file_lembar_pengesahan = $request->file('lembar_pengesahan');
      $file_transkrip = $request->file('transkrip');
      $file_bayar_wisuda = $request->file('bayar_wisuda');

      if ($request->hasFile('srt_keterangan')){
        $keterangan_ext = $this->checkExtention($file_srt_keterangan);
        $path_srt_keterangan = "lampiran".'/'.$nim.'/'."Surat keterangan dari Ketua Departemen - frm15".'.'.$keterangan_ext;
      }
      if ($request->hasFile('foto')){
        $foto_ext = $this->checkExtention($file_foto);
        $path_foto = "lampiran".'/'.$nim.'/'."Pas Foto - frm15".'.'.$foto_ext;
      }
      if ($request->hasFile('spp')){
        $spp_ext = $this->checkExtention($file_spp);
        $path_spp = "lampiran".'/'.$nim.'/'."Bukti Pembayaran SPP - frm15".'.'.$spp_ext;
      }
      if ($request->hasFile('lembar_pengesahan')){
        $pengesahan_ext = $this->checkExtention($file_lembar_pengesahan);
        $path_lembar_pengesahan = "lampiran".'/'.$nim.'/'."Lembar Pengesahan Skripsi - frm15".'.'.$pengesahan_ext;
      }
      if ($request->hasFile('transkrip')){
        $transkrip_ext = $this->checkExtention($file_transkrip);
        $path_transkrip = "lampiran".'/'.$nim.'/'."Transkrip Kumulatif dari Departemen - frm15".'.'.$transkrip_ext;
      }
      if ($request->hasFile('bayar_wisuda')){
        $wisuda_ext = $this->checkExtention($file_bayar_wisuda);
        $path_bayar_wisuda = "lampiran".'/'.$nim.'/'."Bukti Pembayaran Wisuda - frm15".'.'.$wisuda_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      
      $upload_srt_keterangan = 0;
      $upload_foto = 0;
      $upload_spp = 0;
      $upload_lembar_pengesahan = 0;
      $upload_transkrip = 0;
      $upload_bayar_wisuda = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('srt_keterangan')){
        Storage::put($path_srt_keterangan, file_get_contents($file_srt_keterangan->getRealPath()));
      }

      if ($request->hasFile('foto')){
        Storage::put($path_foto, file_get_contents($file_foto->getRealPath()));
      }

      if ($request->hasFile('spp')){
        Storage::put($path_spp, file_get_contents($file_spp->getRealPath()));
      }

      if ($request->hasFile('lembar_pengesahan')){
        Storage::put($path_lembar_pengesahan, file_get_contents($file_lembar_pengesahan->getRealPath()));
      }

      if ($request->hasFile('transkrip')){
        Storage::put($path_transkrip, file_get_contents($file_transkrip->getRealPath()));
      }

      if ($request->hasFile('bayar_wisuda')){
        Storage::put($path_bayar_wisuda, file_get_contents($file_bayar_wisuda->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('srt_keterangan')){
        $frm->srt_keterangan = $path_srt_keterangan;
      }
      if ($request->hasFile('foto')){
        $frm->foto = $path_foto;
      }
      if ($request->hasFile('spp')){
        $frm->spp = $path_spp;
      }
      if ($request->hasFile('lembar_pengesahan')){
        $frm->lbr_pengesahan = $path_lembar_pengesahan;
      }
      if ($request->hasFile('srt_rencanastudi')){
        $frm->transkrip = $path_transkrip;
      }
      if ($request->hasFile('bayar_wisuda')){
        $frm->byr_wisuda = $path_bayar_wisuda;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 16
  public function updateRequest16(Request $request)
  {
    return DB::transaction(function($request) use($request)
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

      $nim = $request['nim'];

      //ambil file dr request
      $file_skl = $request->file('skl');
      $file_bayar_wisuda = $request->file('bayar_wisuda');

      if ($request->hasFile('skl')){
        $skl_ext = $this->checkExtention($file_skl);
        $path_skl = "lampiran".'/'.$nim.'/'."Scan Surat Keterangan Lulus Sarjana - frm16".'.'.$skl_ext;
      }
      if ($request->hasFile('bayar_wisuda')){
        $wisuda_ext = $this->checkExtention($file_bayar_wisuda);
        $path_bayar_wisuda = "lampiran".'/'.$nim.'/'."Bukti Pembayaran Wisuda - frm16".'.'.$wisuda_ext;
      }
      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      
      $upload_skl = 0;
      $upload_bayar_wisuda = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('skl')){
        Storage::put($path_skl, file_get_contents($file_skl->getRealPath()));
      }
      if ($request->hasFile('bayar_wisuda')){
        Storage::put($path_bayar_wisuda, file_get_contents($file_bayar_wisuda->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->semester = $request['semester'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('skl')){
        $frm->skl = $path_skl;
      }
      if ($request->hasFile('srt_rencanastudi')){
        $frm->byr_wisuda = $path_bayar_wisuda;
      }

      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  // update frm 17
  public function updateRequest17(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $this->validate($request, [
        'nama' => 'required',
        'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
        'program_studi' => 'required',
        'utk_keperluan' => 'required',
        'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
        'email' => 'required|email',
      ]);

      $nim = $request['nim'];

      //ambil file dr request
      $file_foto = $request->file('foto');

      if ($request->hasFile('foto')){
        $foto_ext = $this->checkExtention($file_foto);
        $path_foto = "lampiran".'/'.$nim.'/'."Dokumen Legalisir".'.'.$foto_ext;
      }

      //nama file yg akan disimpan di folder sistem (peka.fmipa/Storage/app/Request)
      
      $upload_foto = 0;

      //simpan file di folder sistem (peka.fmipa/Storage/app/Request/[nim])
        //jika Storage::put berahasil, maka akan mengembalikan nilai true

      if ($request->hasFile('foto')){
        Storage::put($path_foto, file_get_contents($file_foto->getRealPath()));
      }

      $frm = Form::find($request->id);

      $frm->nama = $request['nama'];
      $frm->nim = $request['nim'];
      $frm->prodi = $request['program_studi'];
      $frm->keperluan = $request['utk_keperluan'];
      $frm->telp = $request['telp'];
      $frm->email = $request['email'];

      $frm->adm_keterangan = "";

      if ($request->hasFile('foto')){
        $frm->foto = $path_foto;
      }

      $frm->banyaknya = $request['banyaknya'];
      $frm->status = 'Berhasil diupload';

      $input_date = $this->checkRequestDate($nim);

      $frm->changed_at = $input_date;
      $frm->updated_at = $input_date;

      if($frm->update())
      {
        $this->pushNotifToAdm($frm);
      }

      return redirect()->route('status_permohonan');
    });
  }

  public function deleteRequest(Request $request)
  {
    return DB::transaction(function($request) use($request)
    {
      $id = $request['id'];
      $form_hapus = Form::where('id', $id)->first();
      
      if ($form_hapus->spp) {
        Storage::delete($form_hapus->spp);
      }
      if ($form_hapus->ktm) {
        Storage::delete($form_hapus->ktm);
      }
      if ($form_hapus->srt_pengantar) {
        Storage::delete($form_hapus->srt_pengantar);
      }
      if ($form_hapus->srt_rekomen) {
        Storage::delete($form_hapus->srt_rekomen);
      }
      if ($form_hapus->srt_cuti) {
        Storage::delete($form_hapus->srt_cuti);
      }
      if ($form_hapus->srt_undurdiri) {
        Storage::delete($form_hapus->srt_undurdiri);
      }
      if ($form_hapus->srt_sidkom) {
        Storage::delete($form_hapus->srt_sidkom);
      }
      if ($form_hapus->srt_rencanastudi) {
        Storage::delete($form_hapus->srt_rencanastudi);
      }
      if ($form_hapus->foto) {
        Storage::delete($form_hapus->foto);
      }
      if ($form_hapus->srt_keterangan) {
        Storage::delete($form_hapus->srt_keterangan);
      }
      if ($form_hapus->transkrip) {
        Storage::delete($form_hapus->transkrip);
      }
      if ($form_hapus->lbr_pengesahan) {
        Storage::delete($form_hapus->lbr_pengesahan);
      }
      if ($form_hapus->byr_wisuda) {
        Storage::delete($form_hapus->byr_wisuda);
      }
      if ($form_hapus->skl) {
        Storage::delete($form_hapus->skl);
      }

      Form::where('id', $id)->delete();
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
