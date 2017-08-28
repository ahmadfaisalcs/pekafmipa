<?php

namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Form;
use App\Application;
use App\Applicant;
use App\Information;
use App\Graduate;
use Illuminate\Support\Facades\DB;

class PDFSurat
{	
	private $tanggal = '';
	private $tahunakademik = '';
	private $programstudi = '';
	private $departement = '';
	private $semestercuti = '6';
	private $tahunakademikcuti = '2016/2017';
	private $semesterdepan = '7';
	private $tahunakademikdepan = '2017/2018';
    private $TTL = "Panyakalan, 22/11/1988";
    private $minor = "-";
    private $IPK = "2.87";
    private $Yudisium = "Memuaskan";
    private $title = "Sarjana Sains";
    private $tanggalperpanjangan = "22 Maret 2019";
    private $semesterperpanjangan = "10";
    private $tahunakademikperpanjangan = "2018/2019";
    private $dospem = "Firman Ardiansyah, S.Kom., M.Si";
    private $jenis_kelamin = array('L','P');

    private $hari = 'Rabu';
    
    private $tanggal_sidang = '14 Juni 2017';
    private $pukul_sidang = '10.00 - 11.00';
    private $tempat_sidang = 'Ruang Baca Departemen Biokimia';
    
    private $jabatan_pembimbing = array('Ketua', 'Anggota');
    private $nama_pembimbing = array('Dr. Syamsul Falah, S.Hut., M.Si', 'Dr. Mega Safithri, S.Si., M.Si');
    
    private $dekan = 'Dr. Ir. Kgs Dahlan';
    private $NRP_dekan = '196005071987031003';

    // parameter yang ada b dibelakangnya hanya untuk ujicoba karena belom bisa akses ke database
    private $semestercutib = '5';
    private $tahunakademikcutib = '2016/2017';

    // yg faisal tambah
    private $perihal_srt_sidkkom = 'Undangan Sidang Komisi Program Magister';

    /*Encode program studi mahasiswa*/
    public function SetProdiMhs($data){
        if($data == "stk"){
            return "Statistika";
        }
        elseif($data == "gfm"){
            return "Geofisika dan Meteorologi";
        }
        elseif($data == "bio"){
            return "Biologi";   
        }
        elseif($data == "kim"){
            return "Kimia";
        }
        elseif($data == "mat"){
            return "Matematika";
        }
        elseif($data == "kom"){
            return "Ilmu Komputer";
        }
        elseif($data == "fis"){
            return "Fisika";
        }
        elseif($data == "bik"){
            return "Biokimia";
        }
        elseif($data == "akt"){
            return "Aktuaria";
        }
    }

    /*Setting asal departement mahasiswa*/
    public function SetDeptMhs($data){
        $data = strtolower($data);
        if($data == "statistika"){
            return "Statistika";
        }
        elseif($data == "geofisika dan meteorologi"){
            return "Geofisika dan Meteorologi";
        }
        elseif($data == "biologi"){
            return "Biologi";
        }
        elseif($data == "kimia"){
            return "Kimia";
        }
        elseif($data == "matematika" || $data == "aktuaria"){
            return "Matematika";
        }
        elseif($data == "ilmu komputer"){
            return "Ilmu Komputer";
        }
        elseif($data == "Fisika"){
            return "Fisika";
        }
        elseif($data == "biokimia"){
            return "Biokimia";
        }
    }

    /*Mengatur tanggal*/
    public function SetTanggal($data){
        if(date('m', strtotime($data)) == '01'){
            return date('d', strtotime($data)).' Januari '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '02'){
            return date('d', strtotime($data)).' Februari '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '03'){
            return date('d', strtotime($data)).' Maret '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '04'){
            return date('d', strtotime($data)).' April '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '05'){
            return date('d', strtotime($data)).' Mei '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '06'){
            return date('d', strtotime($data)).' Juni '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '07'){
            return date('d', strtotime($data)).' Juli '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '08'){
            return date('d', strtotime($data)).' Agustus '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '09'){
            return date('d', strtotime($data)).' September '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '10'){
            return date('d', strtotime($data)).' Oktober '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '11'){
            return date('d', strtotime($data)).' November '.date('Y', strtotime($data));
        } elseif(date('m', strtotime($data)) == '12'){
            return date('d', strtotime($data)).' Desember '.date('Y', strtotime($data));
        }
    }

    public function SetTahunAkademik($data){
        if(date('m', strtotime($data)) < '09'){
            return ((date('Y',strtotime($data))-1).'/'.date('Y', strtotime($data)));
        } else {
            return (date('Y',strtotime($data)).'/'.(date('Y', strtotime($data))+1));
        }
    }
    /*Surat*/
    public function SuratCutiController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratCuti($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetSemesterCuti($this->semestercuti, $this->tahunakademikcuti);
        $SK->SetSemesterDepan($this->semesterdepan, $this->tahunakademikdepan, $hasil->semester);
        $SK->SetAlasan($hasil->keperluan);
	    $SK->GenerateSuratCuti();
    }

    public function SuratAktifKuliahController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratAktifKuliah($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetKeperluan($hasil->keperluan);
        $SK->GenerateSuratAktifKuliah();
    }

    public function SuratAktifSetelahCutiController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratAktifSetelahCuti($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetSemesterCuti($this->semestercutib);
        $SK->SetSemesterAktif($hasil->semester);
        $SK->SetTahunAkademikCuti($this->tahunakademikcutib);
        $SK->GenerateSuratAktifSetelahCuti();
    }

    public function SuratKeteranganLulusController($id){
        $hasil = Form::where('id', $id)->first();
        $grad = Graduate::where('nim', $hasil->nim)->first();

        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratKeteranganLulus($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);

        $SK->SetTanggalLahir($grad->tanggal_lahir);
        $SK->SetTempatLahir($grad->tempat_lahir);

        $SK->SetData($this->TTL, $this->minor, $grad->ipk, $grad->predikat, $hasil->nim);
        $SK->GenerateSuratKeteranganLulus();
    }

    public function SuratPercepatanIjazahController($id){
        $hasil = Form::where('id', $id)->first();
        $grad = Graduate::where('nim', $hasil->nim)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratPercepatanIjazah($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        
        $SK->SetTanggalLahir($grad->tanggal_lahir);
        $SK->SetTempatLahir($grad->tempat_lahir);
        
        $SK->SetMinor($this->minor);
        $SK->SetTitle($hasil->nim);
        $SK->GenerateSuratPercepatanIjazah();
    }

    public function SuratPerpanjanganStudiController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratPerpanjanganStudi($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetPerpanjangan($hasil->foto,$this->semesterperpanjangan,$hasil->srt_undurdiri,$hasil->srt_sidkom);
        $SK->GenerateSuratPerpanjanganStudi();
    }

    public function SuratSidangKomisiController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratSidangKomisi($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time); 
        // $SK -> SetPerihal($this->perihal);
        // $SK -> SetPembimbing($this->nama_pembimbing);
        $SK -> SetPembimbing($hasil->ktm, $hasil->srt_pengantar);
        
        // $SK -> SetDepartemenPemohon($this->departement);

        $SK -> SetJabatanPembimbing($this->jabatan_pembimbing);
        $SK -> SetJenisKelamin($this->jenis_kelamin[0]);
        // $SK -> SetHari($this->hari);
        $SK -> SetHari($hasil->srt_rekomen);

        // $SK -> SetTanggalSidang($this->tanggal_sidang);
        $SK -> SetTanggalSidang($hasil->srt_cuti);

        // $SK -> SetPukulSidang($this->pukul_sidang);
        $SK -> SetPukulSidang($hasil->srt_undurdiri);

        // $SK -> SetTempatSidang($this->tempat_sidang);
        $SK -> SetTempatSidang($hasil->srt_rencanastudi);

        $SK -> SetNamaDekan($this->dekan);
        $SK -> SetNrpDekan($this->NRP_dekan);
        $SK -> GenerateSuratSidangKomisi();
    }

    public function SuratTunjanganAnakController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratTunjanganAnak($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetDataSurat($hasil->semester, $hasil->nama_ortu, $hasil->nip, $hasil->pangkat, $hasil->instansi);
        $SK->GenerateSuratTunjanganAnak();
    }

    public function SuratUndurDiriController($id){
        $hasil = Form::where('id', $id)->first();
        $this->programstudi = $this->SetProdiMhs($hasil->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new SuratUndurDiri($hasil->nomor_surat, $this->tanggal, $hasil->nama, $hasil->nim, $hasil->semester, $this->tahunakademik, $this->programstudi,$this->departement, $hasil->adm_catatan_tinjut, $hasil->adm_followup_time);
        $SK->SetKeperluan($hasil->keperluan);
        $SK->GenerateSuratUndurDiri();
    }
    /*FORM*/
    // Form Fmipa
    public function FrmFmipa09aController($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $frm_09a = DB::table('frm-09a')->where('id', $hasil->id_infrm)->first();
        $jenis_permohonan = $frm_09a->jenis_permohonan;
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa09a($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK -> SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email, $jenis_permohonan);
        $SK -> GenerateSurat();
    }

    public function FrmFmipa09bController($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $frm_09b = DB::table('frm-09b')->where('id', $hasil->id_infrm)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa09b($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK->SetDataFormOrangTua($frm_09b->nama_ortu, $frm_09b->nip, $frm_09b->pangkat, $frm_09b->instansi, $frm_09b->telp_ortu);
        $SK->GenerateSurat();
    }

    public function FrmFmipa10Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa10($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK->GenerateFRM_FMIPA_10();
    }

    public function FrmFmipa11Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa11($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK -> GenerateSurat();
    
    }

    public function FrmFmipa12Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa12($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK->GenerateSurat();
    }

    public function FrmFmipa13Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa13($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK -> GenerateSurat();
    }

    public function FrmFmipa14Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa14($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK->GenerateSurat();
    }

    public function FrmFmipa15Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa15($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK->SetProdiData($this->programstudi);
        $SK->GenerateSurat();
    }

    public function FrmFmipa16Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa16($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK -> GenerateSurat();
    }

    public function FrmFmipa17Controller($id){
        $hasil = Application::where('id',$id)->first();
        $applicant = Applicant::where('id', $hasil->applicant_id)->first();
        $info = Information::where('id', $hasil->information_id)->first();
        $this->programstudi = $this->SetProdiMhs($applicant->prodi);
        $this->departement = $this->SetDeptMhs($this->programstudi);
        $this->tanggal = $this->SetTanggal($hasil->changed_at);
        $this->tahunakademik = $this->SetTahunAkademik($hasil->changed_at);
        $SK = new FrmFmipa17($hasil->nomor_surat, $this->tanggal, $applicant->nama, $applicant->nim, $applicant->semester, $this->tahunakademik, $this->programstudi,$this->departement, $info->adm_catatan_tinjut, $info->adm_waktu_tinjut);
        $SK->SetDataFormMahasiswa($hasil->keperluan, $applicant->telp, $applicant->email);
        $SK -> GenerateSurat();
    }
}
