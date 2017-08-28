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
class SuratKeteranganLulus extends Surat
{
	private $alasan;

	private $tanggal_lahir_pemohon;
	private $tanggal = "";
	private $bulan = "";
	private $tahun = "";
	private $tempat_lahir_pemohon;
	
	private $minor_pemohon;

	private $IPK_pemohon;
	private $yudisium_pemohon;
	private $title_pemohon;

	function IntToMonth($month)
	{
		if ($month == "1") { return $month = "Januari"; }
		elseif ($month == "2") { return $month = "Februari"; }
		elseif ($month == "3") { return $month = "Maret"; }
		elseif ($month == "4") { return $month = "April"; }
		elseif ($month == "5") { return $month = "Mei"; }
		elseif ($month == "6") { return $month = "Juni"; }
		elseif ($month == "7") { return $month = "Juli"; }
		elseif ($month == "8") { return $month = "Agustus"; }
		elseif ($month == "9") { return $month = "September"; }
		elseif ($month == "10") { return $month = "Oktober"; }
		elseif ($month == "11") { return $month = "November"; }
		elseif ($month == "12") { return $month = "Desember"; }
	}

	function SeparateDate($tanggal_lahir)
	{
		$this->tanggal = substr($tanggal_lahir, 0,2);
		$bulan = substr($tanggal_lahir, 3,2);
		$this->bulan = $this->IntToMonth($bulan);
		$this->tahun = substr($tanggal_lahir, 6,4);
		// echo $tanggal_lahir;
	}

	function SetTanggalLahir($tanggal_lahir)
	{
		// $tgl = "18-07-1995";
		$this->SeparateDate($tanggal_lahir);
	}

	function SetTempatLahir($tempat_lahir)
	{
		$this->tempat_lahir_pemohon = $tempat_lahir;
	}

	/*Set untuk keperluan apa surat tersebut*/
	function SetData($TTL, $minor, $IPK, $Yudisium, $nim)
	{
		$this->TTL_pemohon = $TTL;
		$this->minor_pemohon = $minor;
		$this->IPK_pemohon = $IPK;
		$this->yudisium_pemohon = $Yudisium;
		// $this->title_pemohon = $title;
		$this->SetTitleSarjana($nim);
	}

	function SetTitleSarjana($nim)
	{
		$getDeptFromNim = substr($nim, 1,1);
		$this->title_pemohon = $this->getTitleDept($getDeptFromNim);
	}

	function getTitleDept($dept)
	{
		if ($dept == "1") { return $dept = "Sarjana Statistika"; }
		elseif ($dept == "6") { return $dept = "Sarjana Komputer"; }
		else { return $dept = "Sarjana Sains"; }
	}

	/*Membuat PDF*/
	function GenerateSuratKeteranganLulus()
	{
		$pdf=new Fpdf('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetMargins(30,50, 30);
		$pdf::Ln();
	    $pdf::SetFont('Times','BU',14);
	    $pdf::Cell(0,9,"KETERANGAN LULUS SARJANA",0,1,'C');
	    $pdf::SetFont('Times','',11);
	    $pdf::Cell(0,5,"No. ".$this->nomor_surat,0,1,'C');
	    $pdf::Ln(10);
	    $pdf::MultiCell(0, 5, "Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor menerangkan bahwa :", 0, 'J');
	    $pdf::SetMargins(50,50, 30);
	    $pdf::Ln(5);
	    $pdf::Cell(50,6,"N a m a",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nama_pemohon,0,1,'L');
	    $pdf::Cell(50,6,"Tempat & Tgl. Lahir",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->tempat_lahir_pemohon.", ".$this->tanggal." ".$this->bulan." ".$this->tahun,0,1,'L');
	    $pdf::Cell(50,6,"Nomor Pokok (NIM)",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nrp_pemohon,0,1,'L');
	    $pdf::Cell(50,6,"Program Studi",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->programstudi_pemohon,0,1,'L');
	    $pdf::Cell(50,6,"Mayor",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->departement_pemohon,0,1,'L');
	    $pdf::Cell(50,6,"Minor",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->minor_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::WriteHTML("telah memenuhi persyaratan akademik dan administrasi, sehingga dinyatakan <b>Lulus ".$this->title_pemohon."</b> dengan catatan prestasi sebagai berikut :");
	    $pdf::SetMargins(50,50, 30);
	    $pdf::Ln(10);
	    $pdf::Cell(50,6,"IPK",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->IPK_pemohon,0,1,'L');
	    $pdf::Cell(50,6,"Yudisium",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->yudisium_pemohon,0,1,'L');
	    $pdf::SetMargins(105,50, 30);
	    $pdf::Ln(15);
	    $pdf::Cell(30,4,"Diputuskan di",0,0,"L");
	    $pdf::Cell(0,4,":   B O G O R",0,1,"L");
	    $pdf::Cell(30,4,"Pada Tanggal",0,0,'L');
	    $pdf::Cell(0,4,":   ".$this->tanggal_pengajuan,0,1,'L');
	    $pdf::Cell(0,4,"a.n. Dekan",0,1,'L');
	    $pdf::Cell(0,4,"Wakil Dekan",0,1,'L');
	    $pdf::Cell(0,4,"Bidang Akademik dan Kemahasiswaan,",0,1,'L');
	    $pdf::Ln(20);
	    $pdf::Cell(0,4,"Dr. Ir. Kgs Dahlan",0,1,'L');
	    $pdf::Cell(0,4,"NIP. 19600507 198703 1 003",0,1,'L');
	    $pdf::Output();
		exit;
	}
}
?>