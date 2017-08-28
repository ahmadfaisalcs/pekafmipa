<?php

namespace App\Http\Controllers;

use Session;
// use File;
// use Storage;
use App\User;
use App\Satisfaction;
use App\SatisfactionTable;
use App\Graduate;
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
class SatisfactionController extends Controller
{
  // untuk blade questionnaire
  public function checkQuestionnaire()
  {
    $nim = Session::get('nim');
    $isfill = Satisfaction::where('nim', $nim)->first();
    $data_graduate = Graduate::where('nim', $nim)->first();
    return view('mahasiswa.questionnaire', ['isfill' => $isfill, 'data_graduate' => $data_graduate]);
  }

  public function getSatisfaction(Request $request)
  {
    $dis_year = SatisfactionTable::orderBy('tahun_akademik', 'desc')->distinct()->get(['tahun_akademik'])->first();
    // echo $dis_year->tahun_akademik;
    $dropdown_year = SatisfactionTable::orderBy('tahun_akademik', 'desc')->distinct()->get(['tahun_akademik']);
    if ($request['tahun_akademik'] && $request['periode_wisuda']) {
      $tahun_akademik = $request['tahun_akademik'];
      $periode_wisuda = $request['periode_wisuda'];
      // echo "string";
    }
    else {
      $tahun_akademik = $dis_year->tahun_akademik;
      $last_periode_wisuda_ = SatisfactionTable::where('tahun_akademik', $tahun_akademik)->orderBy('periode_wisuda', 'desc')->distinct()->get(['periode_wisuda'])->first();
      $periode_wisuda = $last_periode_wisuda_->periode_wisuda;
      // echo $periode_wisuda;
    }

    $st = SatisfactionTable::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->first();
    $mipa_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->count();
    $stk_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'stk')->count();
    $gfm_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'gfm')->count();
    $bio_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'bio')->count();
    $kim_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'kim')->count();
    $mat_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'mat')->count();
    $kom_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'kom')->count();
    $fis_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'fis')->count();
    $bik_res = Satisfaction::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('departemen', 'bik')->count();

    return view('ktu.satisfaction', ['st' => $st, 'mipa_res' => $mipa_res, 'stk_res' => $stk_res, 'gfm_res' => $gfm_res, 'bio_res' => $bio_res, 'kim_res' => $kim_res, 'mat_res' => $mat_res, 'kom_res' => $kom_res, 'fis_res' => $fis_res, 'bik_res' => $bik_res, 'dis_year' => $dropdown_year, 'selected_year' => $tahun_akademik, 'drop_periode' => $periode_wisuda]);
  }

  // submit kuisioner tingkat kepuasan layanan
  public function submitQuestionnaire(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'tahun_masuk' => 'required',
      'tanggal_wisuda' => 'required',
      'tahun_akademik' => 'required',
      'ipk' => 'required|regex:/[0-4](.)[0-9]/',

      'kuliah' => 'required',
      'praktikum' => 'required',
      'penelitian' => 'required',
      'pembimbingan' => 'required',

      'administrasi_departemen' => 'required',
      'kebersihan_departemen' => 'required',
      'toilet_departemen' => 'required',
      'hotspot_departemen' => 'required',

      'administrasi_dekanat' => 'required',
      'kebersihan_dekanat' => 'required',
      'toilet_dekanat' => 'required',
      'hotspot_dekanat' => 'required',
    ]);

    return DB::transaction(function($request) use($request)
    {
      $input = new Satisfaction();

      $input->nama = $request['nama'];
      $input->nim = $request['nim'];
      $input->departemen = $request['departemen'];
      $input->jenis_kelamin = $request['jenis_kelamin'];
      $input->jalur_masuk = $request['jalur_masuk'];
      $input->periode_wisuda = $request['periode_wisuda'];
      $input->tanggal_wisuda = $request['tanggal_wisuda'];
      $input->tahun_akademik = $request['tahun_akademik'];
      $input->tahun_masuk = $request['tahun_masuk'];
      $input->ipk = $request['ipk'];

      $input->kuliah = $request['kuliah'];
      $input->praktikum = $request['praktikum'];
      $input->penelitian = $request['penelitian'];
      $input->pembimbingan = $request['pembimbingan'];

      $input->dep_adm = $request['administrasi_departemen'];
      $input->dep_keb = $request['kebersihan_departemen'];
      $input->dep_t = $request['toilet_departemen'];
      $input->dep_hot = $request['hotspot_departemen'];

      $input->dek_adm = $request['administrasi_dekanat'];
      $input->dek_keb = $request['kebersihan_dekanat'];
      $input->dek_t = $request['toilet_dekanat'];
      $input->dek_hot = $request['hotspot_dekanat'];

      $input->saran = $request['saran'];

      $input->save();
      // selesai input


      $data_satisfy = SatisfactionTable::where('periode_wisuda', $request['periode_wisuda'])->where('tahun_akademik', $request['tahun_akademik'])->first();
      $id_st = $data_satisfy['id'];
      // kalau data tingkat kepuasan thn akademik dan periode tsb blm ada, buat baru di SatisfactionTable

      if (!count($data_satisfy))
      {
        $new_satisfy = new SatisfactionTable();

        $new_satisfy->periode_wisuda = $request['periode_wisuda'];
        $new_satisfy->tanggal_wisuda = $request['tanggal_wisuda'];
        $new_satisfy->tahun_akademik = $request['tahun_akademik'];
        //mipa
        $new_satisfy->mipa_na1 = 0;
        $new_satisfy->mipa_na2 = 0;
        $new_satisfy->mipa_na3 = 0;
        $new_satisfy->mipa_na4 = 0;
        //stk
        $new_satisfy->stk_na1 = 0;
        $new_satisfy->stk_na2 = 0;
        $new_satisfy->stk_na3 = 0;
        $new_satisfy->stk_na4 = 0;
        $new_satisfy->stk_a1 = 0;
        $new_satisfy->stk_a2 = 0;
        $new_satisfy->stk_a3 = 0;
        $new_satisfy->stk_a4 = 0;
        //gfm
        $new_satisfy->gfm_na1 = 0;
        $new_satisfy->gfm_na2 = 0;
        $new_satisfy->gfm_na3 = 0;
        $new_satisfy->gfm_na4 = 0;
        $new_satisfy->gfm_a1 = 0;
        $new_satisfy->gfm_a2 = 0;
        $new_satisfy->gfm_a3 = 0;
        $new_satisfy->gfm_a4 = 0;
        //bio
        $new_satisfy->bio_na1 = 0;
        $new_satisfy->bio_na2 = 0;
        $new_satisfy->bio_na3 = 0;
        $new_satisfy->bio_na4 = 0;
        $new_satisfy->bio_a1 = 0;
        $new_satisfy->bio_a2 = 0;
        $new_satisfy->bio_a3 = 0;
        $new_satisfy->bio_a4 = 0;
        //kim
        $new_satisfy->kim_na1 = 0;
        $new_satisfy->kim_na2 = 0;
        $new_satisfy->kim_na3 = 0;
        $new_satisfy->kim_na4 = 0;
        $new_satisfy->kim_a1 = 0;
        $new_satisfy->kim_a2 = 0;
        $new_satisfy->kim_a3 = 0;
        $new_satisfy->kim_a4 = 0;
        //mat
        $new_satisfy->mat_na1 = 0;
        $new_satisfy->mat_na2 = 0;
        $new_satisfy->mat_na3 = 0;
        $new_satisfy->mat_na4 = 0;
        $new_satisfy->mat_a1 = 0;
        $new_satisfy->mat_a2 = 0;
        $new_satisfy->mat_a3 = 0;
        $new_satisfy->mat_a4 = 0;
        //kom
        $new_satisfy->kom_na1 = 0;
        $new_satisfy->kom_na2 = 0;
        $new_satisfy->kom_na3 = 0;
        $new_satisfy->kom_na4 = 0;
        $new_satisfy->kom_a1 = 0;
        $new_satisfy->kom_a2 = 0;
        $new_satisfy->kom_a3 = 0;
        $new_satisfy->kom_a4 = 0;
        //fis
        $new_satisfy->fis_na1 = 0;
        $new_satisfy->fis_na2 = 0;
        $new_satisfy->fis_na3 = 0;
        $new_satisfy->fis_na4 = 0;
        $new_satisfy->fis_a1 = 0;
        $new_satisfy->fis_a2 = 0;
        $new_satisfy->fis_a3 = 0;
        $new_satisfy->fis_a4 = 0;
        //bik
        $new_satisfy->bik_na1 = 0;
        $new_satisfy->bik_na2 = 0;
        $new_satisfy->bik_na3 = 0;
        $new_satisfy->bik_na4 = 0;
        $new_satisfy->bik_a1 = 0;
        $new_satisfy->bik_a2 = 0;
        $new_satisfy->bik_a3 = 0;
        $new_satisfy->bik_a4 = 0;
        // rata-rata
        $new_satisfy->mipa_rata = 0;
        $new_satisfy->stk_rata = 0;
        $new_satisfy->gfm_rata = 0;
        $new_satisfy->bio_rata = 0;
        $new_satisfy->kim_rata = 0;
        $new_satisfy->mat_rata = 0;
        $new_satisfy->kom_rata = 0;
        $new_satisfy->fis_rata = 0;
        $new_satisfy->bik_rata = 0;
        //done
        $new_satisfy->save();

        $id_st = $new_satisfy->id;
      }

      ////// hitung rataan rekapitulasi layanan pd talbe satiscation dgn data baru

      $satisfaction = SatisfactionTable::find($id_st);

      $mipa_na1 = Satisfaction::avg('dek_adm');
      $satisfaction->mipa_na1 = $mipa_na1;
      $mipa_na2 = Satisfaction::avg('dek_keb');
      $satisfaction->mipa_na2 = $mipa_na2;
      $mipa_na3 = Satisfaction::avg('dek_t');
      $satisfaction->mipa_na3 = $mipa_na3;
      $mipa_na4 = Satisfaction::avg('dek_hot');
      $satisfaction->mipa_na4 = $mipa_na4;
      $mipa_rata = ($mipa_na1+$mipa_na2+$mipa_na3+$mipa_na4)/4;
      $satisfaction->mipa_rata = $mipa_rata;

      if ($request['departemen'] == 'stk') {
        $stk_a1 = Satisfaction::where('departemen', 'stk')->avg('kuliah');
        $stk_a2 = Satisfaction::where('departemen', 'stk')->avg('praktikum');
        $stk_a3 = Satisfaction::where('departemen', 'stk')->avg('penelitian');
        $stk_a4 = Satisfaction::where('departemen', 'stk')->avg('pembimbingan');
        $stk_na1 = Satisfaction::where('departemen', 'stk')->avg('dep_adm');
        $stk_na2 = Satisfaction::where('departemen', 'stk')->avg('dep_keb');
        $stk_na3 = Satisfaction::where('departemen', 'stk')->avg('dep_t');
        $stk_na4 = Satisfaction::where('departemen', 'stk')->avg('dep_hot');
        $stk_rata = ($stk_a1+$stk_a2+$stk_a3+$stk_a4+$stk_na1+$stk_na2+$stk_na3+$stk_na4)/8;
        $satisfaction->stk_a1 = $stk_a1;
        $satisfaction->stk_a2 = $stk_a2;
        $satisfaction->stk_a3 = $stk_a3;
        $satisfaction->stk_a4 = $stk_a4;
        $satisfaction->stk_na1 = $stk_na1;
        $satisfaction->stk_na2 = $stk_na2;
        $satisfaction->stk_na3 = $stk_na3;
        $satisfaction->stk_na4 = $stk_na4;
        $satisfaction->stk_rata = $stk_rata;
      }
      elseif ($request['departemen'] == 'gfm') {
        $gfm_a1 = Satisfaction::where('departemen', 'gfm')->avg('kuliah');
        $gfm_a2 = Satisfaction::where('departemen', 'gfm')->avg('praktikum');
        $gfm_a3 = Satisfaction::where('departemen', 'gfm')->avg('penelitian');
        $gfm_a4 = Satisfaction::where('departemen', 'gfm')->avg('pembimbingan');
        $gfm_na1 = Satisfaction::where('departemen', 'gfm')->avg('dep_adm');
        $gfm_na2 = Satisfaction::where('departemen', 'gfm')->avg('dep_keb');
        $gfm_na3 = Satisfaction::where('departemen', 'gfm')->avg('dep_t');
        $gfm_na4 = Satisfaction::where('departemen', 'gfm')->avg('dep_hot');
        $gfm_rata = ($gfm_a1+$gfm_a2+$gfm_a3+$gfm_a4+$gfm_na1+$gfm_na2+$gfm_na3+$gfm_na4)/8;
        $satisfaction->gfm_a1 = $gfm_a1;
        $satisfaction->gfm_a2 = $gfm_a2;
        $satisfaction->gfm_a3 = $gfm_a3;
        $satisfaction->gfm_a4 = $gfm_a4;
        $satisfaction->gfm_na1 = $gfm_na1;
        $satisfaction->gfm_na2 = $gfm_na2;
        $satisfaction->gfm_na3 = $gfm_na3;
        $satisfaction->gfm_na4 = $gfm_na4;
        $satisfaction->gfm_rata = $gfm_rata;
      }
      elseif ($request['departemen'] == 'bio') {
        $bio_a1 = Satisfaction::where('departemen', 'bio')->avg('kuliah');
        $bio_a2 = Satisfaction::where('departemen', 'bio')->avg('praktikum');
        $bio_a3 = Satisfaction::where('departemen', 'bio')->avg('penelitian');
        $bio_a4 = Satisfaction::where('departemen', 'bio')->avg('pembimbingan');
        $bio_na1 = Satisfaction::where('departemen', 'bio')->avg('dep_adm');
        $bio_na2 = Satisfaction::where('departemen', 'bio')->avg('dep_keb');
        $bio_na3 = Satisfaction::where('departemen', 'bio')->avg('dep_t');
        $bio_na4 = Satisfaction::where('departemen', 'bio')->avg('dep_hot');
        $bio_rata = ($bio_a1+$bio_a2+$bio_a3+$bio_a4+$bio_na1+$bio_na2+$bio_na3+$bio_na4)/8;
        $satisfaction->bio_a1 = $bio_a1;
        $satisfaction->bio_a2 = $bio_a2;
        $satisfaction->bio_a3 = $bio_a3;
        $satisfaction->bio_a4 = $bio_a4;
        $satisfaction->bio_na1 = $bio_na1;
        $satisfaction->bio_na2 = $bio_na2;
        $satisfaction->bio_na3 = $bio_na3;
        $satisfaction->bio_na4 = $bio_na4;
        $satisfaction->bio_rata = $bio_rata;
      }
      elseif ($request['departemen'] == 'kim') {
        $kim_a1 = Satisfaction::where('departemen', 'kim')->avg('kuliah');
        $kim_a2 = Satisfaction::where('departemen', 'kim')->avg('praktikum');
        $kim_a3 = Satisfaction::where('departemen', 'kim')->avg('penelitian');
        $kim_a4 = Satisfaction::where('departemen', 'kim')->avg('pembimbingan');
        $kim_na1 = Satisfaction::where('departemen', 'kim')->avg('dep_adm');
        $kim_na2 = Satisfaction::where('departemen', 'kim')->avg('dep_keb');
        $kim_na3 = Satisfaction::where('departemen', 'kim')->avg('dep_t');
        $kim_na4 = Satisfaction::where('departemen', 'kim')->avg('dep_hot');
        $kim_rata = ($kim_a1+$kim_a2+$kim_a3+$kim_a4+$kim_na1+$kim_na2+$kim_na3+$kim_na4)/8;
        $satisfaction->kim_a1 = $kim_a1;
        $satisfaction->kim_a2 = $kim_a2;
        $satisfaction->kim_a3 = $kim_a3;
        $satisfaction->kim_a4 = $kim_a4;
        $satisfaction->kim_na1 = $kim_na1;
        $satisfaction->kim_na2 = $kim_na2;
        $satisfaction->kim_na3 = $kim_na3;
        $satisfaction->kim_na4 = $kim_na4;
        $satisfaction->kim_rata = $kim_rata;
      }
      elseif ($request['departemen'] == 'mat') {
        $mat_a1 = Satisfaction::where('departemen', 'mat')->avg('kuliah');
        $mat_a2 = Satisfaction::where('departemen', 'mat')->avg('praktikum');
        $mat_a3 = Satisfaction::where('departemen', 'mat')->avg('penelitian');
        $mat_a4 = Satisfaction::where('departemen', 'mat')->avg('pembimbingan');
        $mat_na1 = Satisfaction::where('departemen', 'mat')->avg('dep_adm');
        $mat_na2 = Satisfaction::where('departemen', 'mat')->avg('dep_keb');
        $mat_na3 = Satisfaction::where('departemen', 'mat')->avg('dep_t');
        $mat_na4 = Satisfaction::where('departemen', 'mat')->avg('dep_hot');
        $mat_rata = ($mat_a1+$mat_a2+$mat_a3+$mat_a4+$mat_na1+$mat_na2+$mat_na3+$mat_na4)/8;
        $satisfaction->mat_a1 = $mat_a1;
        $satisfaction->mat_a2 = $mat_a2;
        $satisfaction->mat_a3 = $mat_a3;
        $satisfaction->mat_a4 = $mat_a4;
        $satisfaction->mat_na1 = $mat_na1;
        $satisfaction->mat_na2 = $mat_na2;
        $satisfaction->mat_na3 = $mat_na3;
        $satisfaction->mat_na4 = $mat_na4;
        $satisfaction->mat_rata = $mat_rata;
      }
      elseif ($request['departemen'] == 'kom') {
        $kom_a1 = Satisfaction::where('departemen', 'kom')->avg('kuliah');
        $kom_a2 = Satisfaction::where('departemen', 'kom')->avg('praktikum');
        $kom_a3 = Satisfaction::where('departemen', 'kom')->avg('penelitian');
        $kom_a4 = Satisfaction::where('departemen', 'kom')->avg('pembimbingan');
        $kom_na1 = Satisfaction::where('departemen', 'kom')->avg('dep_adm');
        $kom_na2 = Satisfaction::where('departemen', 'kom')->avg('dep_keb');
        $kom_na3 = Satisfaction::where('departemen', 'kom')->avg('dep_t');
        $kom_na4 = Satisfaction::where('departemen', 'kom')->avg('dep_hot');
        $kom_rata = ($kom_a1+$kom_a2+$kom_a3+$kom_a4+$kom_na1+$kom_na2+$kom_na3+$kom_na4)/8;
        $satisfaction->kom_a1 = $kom_a1;
        $satisfaction->kom_a2 = $kom_a2;
        $satisfaction->kom_a3 = $kom_a3;
        $satisfaction->kom_a4 = $kom_a4;
        $satisfaction->kom_na1 = $kom_na1;
        $satisfaction->kom_na2 = $kom_na2;
        $satisfaction->kom_na3 = $kom_na3;
        $satisfaction->kom_na4 = $kom_na4;
        $satisfaction->kom_rata = $kom_rata;
      }
      elseif ($request['departemen'] == 'fis') {
        $fis_a1 = Satisfaction::where('departemen', 'fis')->avg('kuliah');
        $fis_a2 = Satisfaction::where('departemen', 'fis')->avg('praktikum');
        $fis_a3 = Satisfaction::where('departemen', 'fis')->avg('penelitian');
        $fis_a4 = Satisfaction::where('departemen', 'fis')->avg('pembimbingan');
        $fis_na1 = Satisfaction::where('departemen', 'fis')->avg('dep_adm');
        $fis_na2 = Satisfaction::where('departemen', 'fis')->avg('dep_keb');
        $fis_na3 = Satisfaction::where('departemen', 'fis')->avg('dep_t');
        $fis_na4 = Satisfaction::where('departemen', 'fis')->avg('dep_hot');
        $fis_rata = ($fis_a1+$fis_a2+$fis_a3+$fis_a4+$fis_na1+$fis_na2+$fis_na3+$fis_na4)/8;
        $satisfaction->fis_a1 = $fis_a1;
        $satisfaction->fis_a2 = $fis_a2;
        $satisfaction->fis_a3 = $fis_a3;
        $satisfaction->fis_a4 = $fis_a4;
        $satisfaction->fis_na1 = $fis_na1;
        $satisfaction->fis_na2 = $fis_na2;
        $satisfaction->fis_na3 = $fis_na3;
        $satisfaction->fis_na4 = $fis_na4;
        $satisfaction->fis_rata = $fis_rata;
      }
      elseif ($request['departemen'] == 'bik') {
        $bik_a1 = Satisfaction::where('departemen', 'bik')->avg('kuliah');
        $bik_a2 = Satisfaction::where('departemen', 'bik')->avg('praktikum');
        $bik_a3 = Satisfaction::where('departemen', 'bik')->avg('penelitian');
        $bik_a4 = Satisfaction::where('departemen', 'bik')->avg('pembimbingan');
        $bik_na1 = Satisfaction::where('departemen', 'bik')->avg('dep_adm');
        $bik_na2 = Satisfaction::where('departemen', 'bik')->avg('dep_keb');
        $bik_na3 = Satisfaction::where('departemen', 'bik')->avg('dep_t');
        $bik_na4 = Satisfaction::where('departemen', 'bik')->avg('dep_hot');
        $bik_rata = ($bik_a1+$bik_a2+$bik_a3+$bik_a4+$bik_na1+$bik_na2+$bik_na3+$bik_na4)/8;
        $satisfaction->bik_a1 = $bik_a1;
        $satisfaction->bik_a2 = $bik_a2;
        $satisfaction->bik_a3 = $bik_a3;
        $satisfaction->bik_a4 = $bik_a4;
        $satisfaction->bik_na1 = $bik_na1;
        $satisfaction->bik_na2 = $bik_na2;
        $satisfaction->bik_na3 = $bik_na3;
        $satisfaction->bik_na4 = $bik_na4;
        $satisfaction->bik_rata = $bik_rata;
      }
      $satisfaction->update();

      return view('mahasiswa.questionnaire', ['isfill' => 1]);
    });
  }
}
