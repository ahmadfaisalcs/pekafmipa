<?php

namespace App\Http\Controllers;

use Session;
// use File;
// use Storage;
use App\User;
use App\Graduate;
use App\Satisfaction;
use App\SatisfactionTable;
use App\GraduateTable;
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

use App\Biodata;
use App\Applicant;

/**
 *
 */
class GraduateController extends Controller
{
  public function getRecapitulation(Request $request)
  {
    // return DB::transaction
    $dis_year = GraduateTable::orderBy('tahun_akademik', 'desc')->distinct()->get(['tahun_akademik'])->first();
    // echo $dis_year->tahun_akademik;
    $dropdown_year = GraduateTable::orderBy('tahun_akademik', 'desc')->distinct()->get(['tahun_akademik']);
    if ($request['tahun_akademik'] && $request['periode_wisuda']) {
      $tahun_akademik = $request['tahun_akademik'];
      $periode_wisuda = $request['periode_wisuda'];
    }
    else {
      $tahun_akademik = $dis_year->tahun_akademik;
      $last_periode_wisuda_ = GraduateTable::where('tahun_akademik', $tahun_akademik)->orderBy('periode_wisuda', 'desc')->distinct()->get(['periode_wisuda'])->first();
      $periode_wisuda = $last_periode_wisuda_->periode_wisuda;
      // echo $periode_wisuda;
    }
    // $dropdown_periode = GraduateTable::where('tahun_akademik', $tahun_akademik)->orderBy('periode_wisuda', 'desc')->distinct()->get(['periode_wisuda']);
    $grad = GraduateTable::where('periode_wisuda', $periode_wisuda)->where('tahun_akademik', $tahun_akademik)->first();
    $mipa_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->count();
    $stk_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'stk')->count();
    $gfm_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'gfm')->count();
    $bio_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'bio')->count();
    $kim_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'kim')->count();
    $mat_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'mat')->count();
    $kom_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'kom')->count();
    $fis_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'fis')->count();
    $bik_res = Graduate::where('tahun_akademik', $tahun_akademik)->where('periode_wisuda', $periode_wisuda)->where('program_studi', 'bik')->count();

    $st = SatisfactionTable::where('periode_wisuda', $periode_wisuda)->where('tahun_akademik', $tahun_akademik)->first();

    return view('ktu.recapitulation', ['grad' => $grad, 'mipa_res' => $mipa_res, 'stk_res' => $stk_res, 'gfm_res' => $gfm_res, 'bio_res' => $bio_res, 'kim_res' => $kim_res, 'mat_res' => $mat_res, 'kom_res' => $kom_res, 'fis_res' => $fis_res, 'bik_res' => $bik_res, 'st' => $st, 'dis_year' => $dropdown_year, 'selected_year' => $tahun_akademik, 'drop_periode' => $periode_wisuda]);
  }

  public function checkGraduateData()
  {
    $nim = Session::get('nim');
    $isfill = Biodata::where('nim', $nim)->first();
    $data_satisfy = Satisfaction::where('nim', $nim)->first();
    return view('mahasiswa.biodata', ['isfill' => $isfill, 'data_satisfy' => $data_satisfy]);
  }

  public function submitGraduateData(Request $request)
  {
    $this->validate($request, [
      'nama' => 'required',
      'nim' => 'required|min:9|max:9|alpha_num|regex:/(G)[0-9]{8}/',
      'tempat_lahir' => 'required',
      'tanggal_lahir' => 'required|regex:/[0-3][0-9](-)[0-1][0-9](-)[0-9]{4}/',
      'email' => 'required|email',

      'asal_sd' => 'required',
      'asal_smp' => 'required',
      'asal_sma' => 'required',
      'tahun_lulus_sd' => 'required',
      'tahun_lulus_smp' => 'required',
      'tahun_lulus_sma' => 'required',

      'tahun_masuk' => 'required',
      'tanggal_lulus' => 'required|regex:/[0-3][0-9](-)[0-1][0-9](-)[0-9]{4}/',
      'tahun_lulus' => 'required|max:4|regex:/(20)[0-9]/',
      'judul_laporan' => 'required',
      'dosbing1' => 'required',
      
      'ipk_tingkat_1' => 'required|regex:/[0-4](.)[0-9]/',
      'ipk_tingkat_2' => 'required|regex:/[0-4](.)[0-9]/',
      'ipk_tingkat_3' => 'required|regex:/[0-4](.)[0-9]/',
      'ipk_tingkat_4' => 'required|regex:/[0-4](.)[0-9]/',
      'ipk' => 'required|regex:/[0-4](.)[0-9]/',
      'predikat' => 'required',
      'jumlah_sks' => 'required',

      'alamat_lengkap' => 'required',
      'telp' => 'required|min:10|max:13|regex:/(08)[0-9]/',
      'pekerjaan' => 'required',
      'alamat_tempat_kerja' => 'required',
      'nama_ortu' => 'required',
      'alamat_ortu' => 'required',
      
      'tanggal_wisuda' => 'required',
      'tahun_akademik' => 'required',
    ]);

    return DB::transaction(function($request) use($request)
    {
      $input = new Biodata();

      $input->applicant_id = Session::get('id');
      $input->nim = $request['nim'];
      $input->tempat_lahir = $request['tempat_lahir'];
      $input->tanggal_lahir = $request['tanggal_lahir'];
      $input->jenis_kelamin = $request['jenis_kelamin'];
      $input->agama = $request['agama'];
      // $input->email

      $input->asal_sd = $request['asal_sd'];
      $input->asal_smp = $request['asal_smp'];
      $input->asal_sma = $request['asal_sma'];
      $input->tahun_lulus_sd = $request['tahun_lulus_sd'];
      $input->tahun_lulus_smp = $request['tahun_lulus_smp'];
      $input->tahun_lulus_sma = $request['tahun_lulus_sma'];

      $input->jalur_masuk_ipb = $request['jalur_masuk'];
      $input->tahun_masuk_ipb = $request['tahun_masuk'];
      $input->tanggal_lulus_fmipa = $request['tanggal_lulus'];
      $input->tahun_lulus_fmipa = $request['tahun_lulus'];
      $input->judul_skripsi = $request['judul_laporan'];
      $input->dosbing1 = $request['dosbing1'];
      $input->dosbing2 = $request['dosbing2'];
      $input->dosbing3 = $request['dosbing3'];

      $input->ipk_tingkat_1 = $request['ipk_tingkat_1'];
      $input->ipk_tingkat_2 = $request['ipk_tingkat_2'];
      $input->ipk_tingkat_3 = $request['ipk_tingkat_3'];
      $input->ipk_tingkat_4 = $request['ipk_tingkat_4'];
      $input->ipk = $request['ipk'];
      $input->predikat = $request['predikat'];
      $input->jumlah_sks = $request['jumlah_sks'];

      $input->alamat_sekarang = $request['alamat_lengkap'];
      $input->pekerjaan = $request['pekerjaan'];
      $input->alamat_tempat_kerja = $request['alamat_tempat_kerja'];
      $input->nama_ortu = $request['nama_ortu'];
      $input->alamat_ortu = $request['alamat_ortu'];

      $input->periode_wisuda = $request['periode_wisuda'];
      $input->tanggal_wisuda = $request['tanggal_wisuda'];
      $input->tahun_akademik = $request['tahun_akademik'];

      $nim = $request['nim'];
      $tgl_msk = "20".substr($nim,3,2)."/09"."/01";
      $tgl_msk = strtotime($tgl_msk);
      $tgl_msk = date('Y/m/d', $tgl_msk);
      $tgl_msk = date_create($tgl_msk);

      $tgl_lls = $request['tanggal_lulus'];
      $tgl_lls = substr($tgl_lls,6,4)."/".substr($tgl_lls,3,2)."/".substr($tgl_lls,0,2);
      $tgl_lls = strtotime($tgl_lls);
      $tgl_lls = date('Y/m/d', $tgl_lls);
      $tgl_lls = date_create($tgl_lls);
      $diff = $tgl_msk->diff($tgl_lls);
      $y = $diff->y; $m = $diff->m;
      $inmonth = $y*12 +$m;

      $input->lama_studi = $inmonth;

      $input->save();

      $user = Applicant::where('nim', $nim)->first();
      $user_id = $user->id;
      $applicant = Applicant::find($user_id);
      $applicant->nim = $request['nim'];
      $applicant->nama = $request['nama'];
      $applicant->prodi = $request['program_studi'];
      $applicant->email = $request['email'];
      $applicant->telp = $request['telp'];
      $applicant->update();

      /// cek rekapitulasi lulusan periode wisuda yg sama
      // $data_rekap = GraduateTable::where('periode_wisuda', '0')->where('tahun_akademik', '2000/2001')->first();
      $data_rekap = GraduateTable::where('periode_wisuda', $request['periode_wisuda'])->where('tahun_akademik', $request['periode_wisuda'])->first();

      $id_gd = $data_rekap['id'];

      if (!count($data_rekap))
      {
        $new_rekap = new GraduateTable();
        $new_rekap->periode_wisuda = $request['periode_wisuda'];
        $new_rekap->tanggal_wisuda = $request['tanggal_wisuda'];
        $new_rekap->tahun_akademik = $request['tahun_akademik'];
        //fmipa
        $new_rekap->g0_ipk_rata = 0;
        $new_rekap->g0_ipk_max = 0;
        $new_rekap->g0_ipk_min = 0;
        $new_rekap->g0_studi_rata = 0;
        $new_rekap->g0_studi_max = 0;
        $new_rekap->g0_studi_min = 0;
        //stk
        $new_rekap->g1_ipk_rata = 0;
        $new_rekap->g1_ipk_max = 0;
        $new_rekap->g1_ipk_min = 0;
        $new_rekap->g1_studi_rata = 0;
        $new_rekap->g1_studi_max = 0;
        $new_rekap->g1_studi_min = 0;
        //gfm
        $new_rekap->g2_ipk_rata = 0;
        $new_rekap->g2_ipk_max = 0;
        $new_rekap->g2_ipk_min = 0;
        $new_rekap->g2_studi_rata = 0;
        $new_rekap->g2_studi_max = 0;
        $new_rekap->g2_studi_min = 0;
        //bio
        $new_rekap->g3_ipk_rata = 0;
        $new_rekap->g3_ipk_max = 0;
        $new_rekap->g3_ipk_min = 0;
        $new_rekap->g3_studi_rata = 0;
        $new_rekap->g3_studi_max = 0;
        $new_rekap->g3_studi_min = 0;
        //kim
        $new_rekap->g4_ipk_rata = 0;
        $new_rekap->g4_ipk_max = 0;
        $new_rekap->g4_ipk_min = 0;
        $new_rekap->g4_studi_rata = 0;
        $new_rekap->g4_studi_max = 0;
        $new_rekap->g4_studi_min = 0;
        //mat
        $new_rekap->g5_ipk_rata = 0;
        $new_rekap->g5_ipk_max = 0;
        $new_rekap->g5_ipk_min = 0;
        $new_rekap->g5_studi_rata = 0;
        $new_rekap->g5_studi_max = 0;
        $new_rekap->g5_studi_min = 0;
        //kom
        $new_rekap->g6_ipk_rata = 0;
        $new_rekap->g6_ipk_max = 0;
        $new_rekap->g6_ipk_min = 0;
        $new_rekap->g6_studi_rata = 0;
        $new_rekap->g6_studi_max = 0;
        $new_rekap->g6_studi_min = 0;
        //fis
        $new_rekap->g7_ipk_rata = 0;
        $new_rekap->g7_ipk_max = 0;
        $new_rekap->g7_ipk_min = 0;
        $new_rekap->g7_studi_rata = 0;
        $new_rekap->g7_studi_max = 0;
        $new_rekap->g7_studi_min = 0;
        //bik
        $new_rekap->g8_ipk_rata = 0;
        $new_rekap->g8_ipk_max = 0;
        $new_rekap->g8_ipk_min = 0;
        $new_rekap->g8_studi_rata = 0;
        $new_rekap->g8_studi_max = 0;
        $new_rekap->g8_studi_min = 0;
        //done
        $new_rekap->save();

        $id_gd = $new_rekap->id;
        // echo "sip";
      }

      // hitung rekapitulasi lulusan

      $grad = GraduateTable::find($id_gd);

      $g0_ipk_rata = Graduate::avg('ipk');
      $g0_ipk_max = Graduate::max('ipk');
      $g0_ipk_min = Graduate::min('ipk');
      $g0_studi_rata = Graduate::avg('lama_studi');
      $g0_studi_max = Graduate::max('lama_studi');
      $g0_studi_min = Graduate::min('lama_studi');
      $grad->g0_ipk_rata = $g0_ipk_rata;
      $grad->g0_ipk_max = $g0_ipk_max;
      $grad->g0_ipk_min = $g0_ipk_min;
      $grad->g0_studi_rata = $g0_studi_rata;
      $grad->g0_studi_max = $g0_studi_max;
      $grad->g0_studi_min = $g0_studi_min;

      if ($request['program_studi'] == 'stk') {
        $g1_ipk_rata = Graduate::where('program_studi', 'stk')->avg('ipk');
        $g1_ipk_max = Graduate::where('program_studi', 'stk')->max('ipk');
        $g1_ipk_min = Graduate::where('program_studi', 'stk')->min('ipk');
        $g1_studi_rata = Graduate::where('program_studi', 'stk')->avg('lama_studi');
        $g1_studi_max = Graduate::where('program_studi', 'stk')->max('lama_studi');
        $g1_studi_min = Graduate::where('program_studi', 'stk')->min('lama_studi');
        $grad->g1_ipk_rata = $g1_ipk_rata;
        $grad->g1_ipk_max = $g1_ipk_max;
        $grad->g1_ipk_min = $g1_ipk_min;
        $grad->g1_studi_rata = $g1_studi_rata;
        $grad->g1_studi_max = $g1_studi_max;
        $grad->g1_studi_min = $g1_studi_min;
      }
      elseif ($request['program_studi'] == 'gfm') {
        $g2_ipk_rata = Graduate::where('program_studi', 'gfm')->avg('ipk');
        $g2_ipk_max = Graduate::where('program_studi', 'gfm')->max('ipk');
        $g2_ipk_min = Graduate::where('program_studi', 'gfm')->min('ipk');
        $g2_studi_rata = Graduate::where('program_studi', 'gfm')->avg('lama_studi');
        $g2_studi_max = Graduate::where('program_studi', 'gfm')->max('lama_studi');
        $g2_studi_min = Graduate::where('program_studi', 'gfm')->min('lama_studi');
        $grad->g2_ipk_rata = $g2_ipk_rata;
        $grad->g2_ipk_max = $g2_ipk_max;
        $grad->g2_ipk_min = $g2_ipk_min;
        $grad->g2_studi_rata = $g2_studi_rata;
        $grad->g2_studi_max = $g2_studi_max;
        $grad->g2_studi_min = $g2_studi_min;
      }
      elseif ($request['program_studi'] == 'bio') {
        $g3_ipk_rata = Graduate::where('program_studi', 'bio')->avg('ipk');
        $g3_ipk_max = Graduate::where('program_studi', 'bio')->max('ipk');
        $g3_ipk_min = Graduate::where('program_studi', 'bio')->min('ipk');
        $g3_studi_rata = Graduate::where('program_studi', 'bio')->avg('lama_studi');
        $g3_studi_max = Graduate::where('program_studi', 'bio')->max('lama_studi');
        $g3_studi_min = Graduate::where('program_studi', 'bio')->min('lama_studi');
        $grad->g3_ipk_rata = $g3_ipk_rata;
        $grad->g3_ipk_max = $g3_ipk_max;
        $grad->g3_ipk_min = $g3_ipk_min;
        $grad->g3_studi_rata = $g3_studi_rata;
        $grad->g3_studi_max = $g3_studi_max;
        $grad->g3_studi_min = $g3_studi_min;
      }
      elseif ($request['program_studi'] == 'kim') {
        $g4_ipk_rata = Graduate::where('program_studi', 'kim')->avg('ipk');
        $g4_ipk_max = Graduate::where('program_studi', 'kim')->max('ipk');
        $g4_ipk_min = Graduate::where('program_studi', 'kim')->min('ipk');
        $g4_studi_rata = Graduate::where('program_studi', 'kim')->avg('lama_studi');
        $g4_studi_max = Graduate::where('program_studi', 'kim')->max('lama_studi');
        $g4_studi_min = Graduate::where('program_studi', 'kim')->min('lama_studi');
        $grad->g4_ipk_rata = $g4_ipk_rata;
        $grad->g4_ipk_max = $g4_ipk_max;
        $grad->g4_ipk_min = $g4_ipk_min;
        $grad->g4_studi_rata = $g4_studi_rata;
        $grad->g4_studi_max = $g4_studi_max;
        $grad->g4_studi_min = $g4_studi_min;
      }
      elseif ($request['program_studi'] == 'mat') {
        $g5_ipk_rata = Graduate::where('program_studi', 'mat')->avg('ipk');
        $g5_ipk_max = Graduate::where('program_studi', 'mat')->max('ipk');
        $g5_ipk_min = Graduate::where('program_studi', 'mat')->min('ipk');
        $g5_studi_rata = Graduate::where('program_studi', 'mat')->avg('lama_studi');
        $g5_studi_max = Graduate::where('program_studi', 'mat')->max('lama_studi');
        $g5_studi_min = Graduate::where('program_studi', 'mat')->min('lama_studi');
        $grad->g5_ipk_rata = $g5_ipk_rata;
        $grad->g5_ipk_max = $g5_ipk_max;
        $grad->g5_ipk_min = $g5_ipk_min;
        $grad->g5_studi_rata = $g5_studi_rata;
        $grad->g5_studi_max = $g5_studi_max;
        $grad->g5_studi_min = $g5_studi_min;
      }
      elseif ($request['program_studi'] == 'kom') {
        $g6_ipk_rata = Graduate::where('program_studi', 'kom')->avg('ipk');
        $g6_ipk_max = Graduate::where('program_studi', 'kom')->max('ipk');
        $g6_ipk_min = Graduate::where('program_studi', 'kom')->min('ipk');
        $g6_studi_rata = Graduate::where('program_studi', 'kom')->avg('lama_studi');
        $g6_studi_max = Graduate::where('program_studi', 'kom')->max('lama_studi');
        $g6_studi_min = Graduate::where('program_studi', 'kom')->min('lama_studi');
        $grad->g6_ipk_rata = $g6_ipk_rata;
        $grad->g6_ipk_max = $g6_ipk_max;
        $grad->g6_ipk_min = $g6_ipk_min;
        $grad->g6_studi_rata = $g6_studi_rata;
        $grad->g6_studi_max = $g6_studi_max;
        $grad->g6_studi_min = $g6_studi_min;
      }
      elseif ($request['program_studi'] == 'fis') {
        $g7_ipk_rata = Graduate::where('program_studi', 'fis')->avg('ipk');
        $g7_ipk_max = Graduate::where('program_studi', 'fis')->max('ipk');
        $g7_ipk_min = Graduate::where('program_studi', 'fis')->min('ipk');
        $g7_studi_rata = Graduate::where('program_studi', 'fis')->avg('lama_studi');
        $g7_studi_max = Graduate::where('program_studi', 'fis')->max('lama_studi');
        $g7_studi_min = Graduate::where('program_studi', 'fis')->min('lama_studi');
        $grad->g7_ipk_rata = $g7_ipk_rata;
        $grad->g7_ipk_max = $g7_ipk_max;
        $grad->g7_ipk_min = $g7_ipk_min;
        $grad->g7_studi_rata = $g7_studi_rata;
        $grad->g7_studi_max = $g7_studi_max;
        $grad->g7_studi_min = $g7_studi_min;
      }
      elseif ($request['program_studi'] == 'bik') {
        $g8_ipk_rata = Graduate::where('program_studi', 'bik')->avg('ipk');
        $g8_ipk_max = Graduate::where('program_studi', 'bik')->max('ipk');
        $g8_ipk_min = Graduate::where('program_studi', 'bik')->min('ipk');
        $g8_studi_rata = Graduate::where('program_studi', 'bik')->avg('lama_studi');
        $g8_studi_max = Graduate::where('program_studi', 'bik')->max('lama_studi');
        $g8_studi_min = Graduate::where('program_studi', 'bik')->min('lama_studi');
        $grad->g8_ipk_rata = $g8_ipk_rata;
        $grad->g8_ipk_max = $g8_ipk_max;
        $grad->g8_ipk_min = $g8_ipk_min;
        $grad->g8_studi_rata = $g8_studi_rata;
        $grad->g8_studi_max = $g8_studi_max;
        $grad->g8_studi_min = $g8_studi_min;
      }

      $grad->update();

      return view('mahasiswa.biodata', ['isfill' => 1]);
    });
    // echo $data_rekap['id'];
  }
}
