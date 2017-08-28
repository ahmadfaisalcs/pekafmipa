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
class SuratTunjanganAnak extends Surat
{
	private $alasan;
	private $romawisemester;
	private $namaorangtua_pemohon;
	private $niporangtua_pemohon;
	private $pangkatorangtua_pemohon;
	private $instansiorangtua_pemohon;

	/*Set untuk keperluan apa surat tersebut*/
	function SetDataSurat($semester, $namaorangtua, $niporangtua, $pangkatorangtua, $instansiorangtua)
	{
		$this->romawisemester = $this->SetRomawi($semester);
		$this->namaorangtua_pemohon = $namaorangtua;
		$this->niporangtua_pemohon = $niporangtua;
		$this->pangkatorangtua_pemohon = $pangkatorangtua;
		$this->instansiorangtua_pemohon = $instansiorangtua;
	}

	/*Membuat PDF*/
	function GenerateSuratTunjanganAnak()
	{
		$pdf=new Fpdf('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetFont('Times','',8);
		$pdf::SetMargins(100,50, 30);
		$pdf::Ln(1);
		$pdf::Cell(20,2.5,"Lampiran    :",0,0,"L");
		$pdf::MultiCell(0,2.5,"Surat Edaran bersama Menteri Keuangan dan Kepala BAKN.",0,"J");
		$pdf::Cell(20,2.5,"",0,0,"L");
		$pdf::MultiCell(0,2.5,"Nomor :  SE.1. 38/DJA/1.0/7/80 (No. SE/ 117/80)",0,"J");
		$pdf::Cell(20,2.5,"",0,0,"L");
		$pdf::MultiCell(0,2.5,"Nomor :  19/SE/1980  tanggal  7 Juli 1980",0,"J");
		$pdf::Cell(20,2.5,"",0,0,"L");
		$pdf::MultiCell(0,2.5,"------------------------------------------------------------",0,"J");
		$pdf::Ln(5);
		$pdf::SetMargins(30,50,30);
		$pdf::Ln();
	    $pdf::SetFont('Times','BU',14);
	    $pdf::Cell(0,5,"SURAT PERNYATAAN MASIH KULIAH",0,1,'C');
	    $pdf::SetFont('Times','B',12);
	    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
	    $pdf::SetFont('Times','',11);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0, 5, "Yang bertanda tangan di bawah ini :", 0, 'J');
	    $pdf::SetMargins(35,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(50,5,"1.  N a m a",0,0,'L');
	    $pdf::Cell(0,5,":   Dr. Ir. Kgs Dahlan",0,1,'L');
	    $pdf::Cell(50,5,"2.  NIP",0,0,'L');
	    $pdf::Cell(0,5,":   19600507 198703 1 003",0,1,'L');
	    $pdf::Cell(50,5,"3.  Pangkat/Gol. ruang",0,0,'L');
	    $pdf::Cell(0,5,":   Pembina Tk. I/ IV/b",0,1,'L');
	    $pdf::Cell(50,5,"4.  J a b a t a n",0,0,'L');
	    $pdf::Cell(0,5,":   Wakil Dekan Bidang Akademik dan Kemahasiswaan",0,1,'L');
	    $pdf::Cell(50,5,"5.  P a d a",0,0,'L');
	    $pdf::Cell(0,5,":   Fakultas Matematika dan Ilmu Pengetahuan Alam-IPB",0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0, 5, "dengan ini menyatakan dengan sesungguhnya, bahwa :", 0, 'J');
	    $pdf::SetMargins(35,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(50,5,"6.  N a m a",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->nama_pemohon,0,1,'L');
	    $pdf::Cell(50,5,"7.  Nomor pokok/Semester",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->nrp_pemohon."/".$this->romawisemester,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0, 5, "adalah benar mahasiswa Fakultas Matematika dan Ilmu Pengetahuan Alam - IPB program : S1", 0, 'J');
	    $pdf::SetMargins(35,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(50,5,"8.  Kuliah pada Departemen",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->departement_pemohon,0,1,'L');
	    $pdf::Cell(50,5,"9.  Pada tahun akademik",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->tahunakademik_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0, 5, "dari orangtua/wali mahasiswa tersebut adalah        :", 0, 'J');
	    $pdf::SetMargins(35,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(50,5,"10.  N a m a",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->namaorangtua_pemohon,0,1,'L');
	    $pdf::Cell(50,5,"11.  NIP/NRP",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->niporangtua_pemohon,0,1,'L');
	    $pdf::Cell(50,5,"12.  Pangkat/Gol. ruang",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->pangkatorangtua_pemohon,0,1,'L');
	    $pdf::Cell(50,5,"13.  I n s t a n s i",0,0,'L');
	    $pdf::Cell(0,5,":   ".$this->instansiorangtua_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0, 5, "Demikian surat pernyataan ini dibuat dengan sesungguhnya, dan apabila dikemudian hari surat pernyataan ini ternyata tidak benar yang mengakibatkan kerugian terhadap Negara Republik Indonesia, maka saya bersedia menanggung kerugian tersebut.", 0, 'J');
	    $pdf::SetMargins(115,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,4,"Bogor,  ".$this->tanggal_pengajuan,0,'L');
	    $pdf::MultiCell(0,4,"a.n. Dekan",0,'L');
	    $pdf::MultiCell(0,4,"Wakil Dekan",0,'L');
	    $pdf::MultiCell(0,4,"Bidang Akademik dan Kemahasiswaan,",0,'L');
	    $pdf::Ln(15);
	    $pdf::MultiCell(0,4,"Dr. Ir. Kgs Dahlan",0,'L');
	    $pdf::MultiCell(0,4	,"NIP. 19600507 198703 1 003",0,'L');
	    $pdf::Output();
		exit;
	}
}
?>