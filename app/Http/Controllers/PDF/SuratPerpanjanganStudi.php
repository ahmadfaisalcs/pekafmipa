<?php
	namespace App\Http\Controllers\PDF;

	use Illuminate\Http\Request;
	use App\Http\Controllers\PDF\Surat;
	use Fpdf;
	/* 	
		$pdf=new PDF('P', 'mm', 'A4') (Potrait, pengukur kertas dalam mm, Ukuran kertas)
		AddPage() = Menambahkan Page baru
		SetMargins() = Set Margin untuk tulisan dibawahnya (kiri, atas, kanan)
		Ln() = Tinggi dari Newline
		SetFont() = Set Font(jenis tulisan, Bold/Italic/Underline, ukuran tulisan)
		MultiCell = Menulis banyak cell / paragraph (lebar cell(default 0), tinggi cell, text, border, align)
		Output() = Menampilkan / download PDF
	*/
class SuratPerpanjanganStudi extends Surat
{
	private $tanggalperpanjangan_pemohon;
	private $semesterperpanjangan_pemohon;
	private $tahunakademikperpanjangan_pemohon;
	private $dospem_pemohon;

	private $tanggal;
	private $bulan;
	private $tahun;

	/*Set untuk sampai tanggal, semester, dan tahun akademik dimana perpanjangan surat diminta*/
	function SetPerpanjangan($tanggalperpanjangan,$semesterperpanjangan,$tahunakademikperpanjangan,$dospem)
	{
		$this->tanggal = substr($tanggalperpanjangan,0,2);
		$bln = substr($tanggalperpanjangan,3,2);
		$this->tahun = substr($tanggalperpanjangan,6,4);
		$this->bulan = $this->IntToMonth($bln);
		$this->semesterperpanjangan_pemohon = $this->CekSemester($bln);

		$this->dospem_pemohon = $dospem;

		// $this->semesterperpanjangan_pemohon = $this->SetGenapGanjil($semesterperpanjangan);	
		$this->tahunakademikperpanjangan_pemohon = $tahunakademikperpanjangan;
		$this->dospem_pemohon = $dospem;
	}

	function CekSemester($bln)
	{
		if ($bln == "01") { return $bln = "Ganjil"; }
		if ($bln == "02") { return $bln = "Genap"; }
		if ($bln == "03") { return $bln = "Genap"; }
		if ($bln == "04") { return $bln = "Genap"; }
		if ($bln == "05") { return $bln = "Genap"; }
		if ($bln == "06") { return $bln = "Genap"; }
		if ($bln == "07") { return $bln = "Genap"; }
		if ($bln == "08") { return $bln = "Ganjil"; }
		if ($bln == "09") { return $bln = "Ganjil"; }
		if ($bln == "10") { return $bln = "Ganjil"; }
		if ($bln == "11") { return $bln = "Ganjil"; }
		if ($bln == "12") { return $bln = "Ganjil"; }
	}

	function IntToMonth($month)
	{
		if ($month == "01") { return $month = "Januari"; }
		elseif ($month == "02") { return $month = "Februari"; }
		elseif ($month == "03") { return $month = "Maret"; }
		elseif ($month == "04") { return $month = "April"; }
		elseif ($month == "05") { return $month = "Mei"; }
		elseif ($month == "06") { return $month = "Juni"; }
		elseif ($month == "07") { return $month = "Juli"; }
		elseif ($month == "08") { return $month = "Agustus"; }
		elseif ($month == "09") { return $month = "September"; }
		elseif ($month == "10") { return $month = "Oktober"; }
		elseif ($month == "11") { return $month = "November"; }
		elseif ($month == "12") { return $month = "Desember"; }
	}

	/*Membuat PDF*/
	function GenerateSuratPerpanjanganStudi()
	{
		$pdf=new Fpdf('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetMargins(30,50,30);
		$pdf::Ln();
	    $pdf::SetFont('Times','BU',14);
	    $pdf::Cell(0,5,"SURAT IZIN PERPANJANGAN STUDI",0,1,'C');
	    $pdf::SetFont('Times','',11);
	    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
	    $pdf::Ln(10);
	    $pdf::MultiCell(0, 5, "Setelah mempertimbangkan permohonan mahasiswa untuk perpanjangan studi yang telah disetujui oleh Dosen Pembimbing, maka Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam IPB dengan ini memberi izin kepada:", 0, 'J');
	    $pdf::SetMargins(50,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(30,5,"Nama",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->nama_pemohon,0,1,'L');
	    $pdf::Cell(30,5,"NIM",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->nrp_pemohon,0,1,'L');
	    $pdf::Cell(30,5,"Program Studi",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->programstudi_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,5,"untuk perpanjangan studi sampai tanggal ".$this->tanggal." ". $this->bulan." ".$this->tahun." semester ".$this->semesterperpanjangan_pemohon." tahun akademik ".$this->tahunakademikperpanjangan_pemohon.", dengan ketentuan :",0,'J');
	    $pdf::Cell(5, 5,"1.",0,0,"L");
	    $pdf::MultiCell(0,5,"Sejak dikeluarkannya surat ini ybs. diwajibkan memberikan laporan tertulis setiap minggu mengenai kemajuan studi yang disetujui oleh Dosen Pembimbing kepada Wakil Dekan FMIPA IPB.",0,"J");
	    $pdf::Cell(5, 5,"2.",0,0,"L");
	    $pdf::MultiCell(0,5,"Menyelesaikan registrasi administrasi (SPP) semester ".$this->semesterperpanjangan_pemohon." tahun ".$this->tahunakademikperpanjangan_pemohon.".",0,"J");
	    $pdf::Cell(5, 5,"3.",0,0,"L");
	    $pdf::MultiCell(0,5,"Perpanjangan studi ini  agar dimanfaatkan  dengan  sebaik-baiknya.",0,"J");
	    $pdf::Cell(5, 5,"4.",0,0,"L");
	    $pdf::MultiCell(0,5,"Apabila tidak dapat menyelesaikan studinya (pembuatan SKL) sesuai waktu yang ditentukan, maka yang bersangkutan dinyatakan drop out / dikeluarkan dari IPB.",0,"J");
	    $pdf::MultiCell(0,5,"Demikian, untuk diketahui dan diindahkan.",0,'J');
	    $pdf::SetMargins(115,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,4,"Bogor,  ".$this->tanggal_pengajuan,0,'L');
	    $pdf::MultiCell(0,4,"a.n. Dekan,",0,'L');
	    $pdf::MultiCell(0,4,"Wakil Dekan",0,'L');
	    $pdf::MultiCell(0,4,"Bidang Akademik dan Kemahasiswaan,",0,'L');
	    $pdf::Ln(15);
	    $pdf::MultiCell(0,4,"Dr. Ir. Kgs Dahlan",0,'L');
	    $pdf::MultiCell(0,4,"NIP. 19600507 198703 1 003",0,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln();
	    $pdf::SetFont("Times",'',9);
	    $pdf::Cell(0,3,"Tembusan",0,1,'L');
	    $pdf::Cell(0,3,"1.   Direktur Administrasi IPB",0,1,'L');
	    $pdf::Cell(0,3,"2.   Ketua Departemen Ilmu Komputer",0,1,'L');
	    $pdf::Cell(0,3,"3.   ".$this->dospem_pemohon." (Dosen Pembimbing)",0,1,'L');
	    $pdf::Output();
		exit;
	}
}
?>