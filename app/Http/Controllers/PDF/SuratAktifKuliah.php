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
class SuratAktifKuliah extends Surat
{
	private $alasan;

	/*Set untuk keperluan apa surat tersebut*/
	function SetKeperluan($alasan)
	{
		$this->alasan = $alasan;
	}

	/*Membuat PDF*/
	function GenerateSuratAktifKuliah()
	{
		$pdf=new Fpdf('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetMargins(30,50, 30);
		$pdf::Ln();
	    $pdf::SetFont('Times','BU',14);
	    $pdf::Cell(0,5,"S U R A T K E T E R A N G A N",0,1,'C');
	    $pdf::SetFont('Times','',11);
	    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
	    $pdf::Ln(10);
	    $pdf::MultiCell(0, 5, "Yang bertanda tangan di bawah ini, Wakil Dekan Bidang Akademik dan Kemahasiswaan Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor menerangkan dengan sesungguhnya bahwa:", 0, 'J');
	    $pdf::SetMargins(45,30, 30);
	    $pdf::Ln(5);
	    $pdf::Cell(30,6,"N a m a",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nama_pemohon,0,1,'L');
	    $pdf::Cell(30,6,"N R P",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nrp_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50, 30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,5,"Pada semester ".$this->semester_pemohon." (".$this->semesterstring_pemohon.") tahun akademik ".$this->tahunakademik_pemohon." tercatat sebagai mahasiswa aktif Program Studi ".$this->departement_pemohon." Fakultas Matematika dan Ilmu Pengetahuan Alam Institut Pertanian Bogor. Keterangan ini dibuat untuk keperluan : ".$this->alasan.".",0,'J');
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,5,"Demikian untuk diketahui dan digunakan sebagaimana mestinya.",0,'J');
	    $pdf::SetMargins(115,50, 30);
	    $pdf::Ln(10);
	    $pdf::MultiCell(0,4,"Bogor,  ".$this->tanggal_pengajuan,0,'L');
	    $pdf::MultiCell(0,4,"a.n. Dekan",0,'L');
	    $pdf::MultiCell(0,4,"Wakil Dekan",0,'L');
	    $pdf::MultiCell(0,4,"Bidang Akademik dan Kemahasiswaan,",0,'L');
	    $pdf::Ln(20);
	    $pdf::MultiCell(0,4,"Dr. Ir. Kgs Dahlan",0,'L');
	    $pdf::MultiCell(0,4,"NIP. 19600507 198703 1 003",0,'L');
	    $pdf::Output();
		exit;
	}
}
?>