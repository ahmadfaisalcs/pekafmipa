<?php
namespace App\Http\Controllers\PDF;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Surat extends Controller
{
	protected $nomor_surat;
	protected $tanggal_pengajuan;
	protected $nama_pemohon;
	protected $nrp_pemohon;
	protected $semester_pemohon;
	protected $tahunakademik_pemohon;
	protected $programstudi_pemohon;
	protected $departement_pemohon;
	protected $semesterstring_pemohon;
	
	protected $adm_catatan_tinjut;
	protected $adm_followup_time;

	protected $tgl_tinjut;
	protected $jam_tinjut;

	function __construct($no='', $tanggal='', $nama='', $nrp='', $semester='', $tahunakademik='', $programstudi='', $departement, $adm_catatan_tinjut, $adm_followup_time)
	{
		$this->nomor_surat = $no;
		$this->tanggal_pengajuan = $tanggal;
		$this->nama_pemohon = $nama;
		$this->nrp_pemohon = $nrp;
		$this->semester_pemohon = $semester;
		$this->tahunakademik_pemohon = $tahunakademik;
		$this->programstudi_pemohon = $programstudi;
		$this->departement_pemohon = $departement;
		$this->Semester2String($semester);

		$this->adm_catatan_tinjut = $adm_catatan_tinjut;
		$this->adm_followup_time = $adm_followup_time;
		$this->SetTanggalCatatanTinjut($adm_followup_time);
		$this->SetJamCatatanTinjut($adm_followup_time);
	}

	function SetNomorSurat($nomor)
	{
		$this->nomor_surat = $nomor;
	}

	function SetTanggalPengajuan($tanggal)
	{
		$this->tanggal_pengajuan = $tanggal;
	}

	function SetNama($nama)
	{
		$this->nama_pemohon = $nama;
	}

	function SetNRP($nrp)
	{
		$this->nrp_pemohon = $nrp;
	}

	function SetSemester($semester)
	{
		$this->semester_pemohon = $semester;
	}

	function SetTahunAkademik($tahunakademik)
	{
		$this->tahunakademik_pemohon = $tahunakademik;
	}

	function SetProgramStudi($programstudi)
	{
		$this->programstudi_pemohon = $programstudi;
	}

	function SetDepartement($departement)
	{
		$this->departement_pemohon = $departement;
	}

	function SetGenapGanjil($data)
	{
		if($data % 2 == 0)
		{
			return "Genap";
		}
		else
		{
			return "Ganjil";
		}
	}
	function Semester2String($semseter)
	{
		if($this->semester_pemohon == '3')
		{
			$this->semesterstring_pemohon = 'tiga';
		}
		else if ($this->semester_pemohon == '4')
		{
			$this->semesterstring_pemohon = 'empat';
		}
		else if ($this->semester_pemohon == '5')
		{
			$this->semesterstring_pemohon = 'lima';
		}
		else if ($this->semester_pemohon == '6')
		{
			$this->semesterstring_pemohon ='enam';
		}
		else if ($this->semester_pemohon == '7')
		{
			$this->semesterstring_pemohon = 'tujuh';
		}
		else if ($this->semester_pemohon == '8')
		{
			$this->semesterstring_pemohon = 'delapan';
		}
		else if ($this->semester_pemohon == '9')
		{
			$this->semesterstring_pemohon = 'sembilan';
		}
		else if ($this->semester_pemohon == '10')
		{
			$this->semesterstring_pemohon = 'sepuluh';
		}
		else if ($this->semester_pemohon == '11')
		{
			$this->semesterstring_pemohon = 'sebelas';
		}
		else if ($this->semester_pemohon == '12')
		{
			$this->semesterstring_pemohon = 'dua belas';
		} 
	}

	function SetRomawi($data)
	{
		if($data == '3')
		{
			return 'III';
		} 
		else if($data == '4')
		{
			return 'IV';	
		}
		else if($data == '5')
		{
			return 'V';	
		}
		else if($data == '6')
		{
			return 'VI';	
		}
		else if($data == '7')
		{
			return 'VII';	
		}
		else if($data == '8')
		{
			return 'VIII';	
		}
		else if($data == '9')
		{
			return 'IX';	
		}
		else if($data == '10')
		{
			return 'X';	
		}
		else if($data == '11')
		{
			return 'XI';	
		}
		else if($data == '12')
		{
			return 'XII';	
		}
	}

	function SetTanggalCatatanTinjut($tgl_tinjut)
	{
		$this->tgl_tinjut = substr($tgl_tinjut,8,2)."/".substr($tgl_tinjut,5,2)."/".substr($tgl_tinjut,0,4);
		// echo $this->tgl_tinjut;
	}

	function SetJamCatatanTinjut($jam_tinjut)
	{
		$this->jam_tinjut = substr($jam_tinjut,11,5);
	}
}
?>