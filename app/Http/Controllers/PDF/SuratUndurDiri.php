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
class SuratUndurDiri extends Surat
{
	private $alasan;

	/*Set untuk keperluan apa surat tersebut*/
	function SetKeperluan($alasan)
	{
		$this->alasan = $alasan;
	}

	/*Membuat PDF*/
	function GenerateSuratUndurDiri()
	{
		$pdf=new Fpdf('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetMargins(30,50,30);
		$pdf::Ln(1);
	    $pdf::SetFont('Times','BU',14);
	    $pdf::Cell(0,5,"S U R A T  K E T E R A N G A N",0,1,'C');
	    $pdf::SetFont('Times','',11);
	    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
	    $pdf::Ln(10);
	    $pdf::MultiCell(0, 5, "Setelah memperhatikan permohonan mahasiswa yang diketahui orang tua dan persetujuan Ketua Departemen ".$this->departement_pemohon." tentang Pengunduran Diri :", 0, 'J');
	    $pdf::SetMargins(50,50,30);
	    $pdf::Ln(5);
	    $pdf::Cell(30,6,"N a m a",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nama_pemohon,0,1,'L');
	    $pdf::Cell(30,6,"N I M",0,0,'L');
	    $pdf::Cell(0,6,":   ".$this->nrp_pemohon,0,1,'L');
	    $pdf::SetMargins(30,50,30);
	    $pdf::Ln(5);
	    $pdf::MultiCell(0,5,"Dengan ini Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor menetapkan terhitung tanggal ".$this->tanggal_pengajuan." tahun akademik ".$this->tahunakademik_pemohon." yang bersangkutan dicabut hak dan kewajibannya sebagai mahasiswa Institut Pertanian Bogor. Yang bersangkutan terakhir tercatat sebagai mahasiswa program studi ".$this->programstudi_pemohon." tahun akademik ".$this->tahunakademik_pemohon.".",0,'J');
	    $pdf::MultiCell(0,5,"Keterangan ini dibuat untuk dipergunakan seperlunya dan sebagai persyaratan bila yang bersangkutan akan melanjutkan studi ke Perguruan Tinggi lain.",0,'J');
	    $pdf::SetMargins(132,50,30);
	    $pdf::Ln(10);
	    $pdf::MultiCell(0,4,"Bogor,  ".$this->tanggal_pengajuan,0,'L');
	    $pdf::MultiCell(0,4,"Dekan,",0,'L');
	    $pdf::Ln(20);
	    $pdf::MultiCell(0,4,"Dr. Ir. Sri Nurdiati, M.Sc",0,'L');
	    $pdf::MultiCell(0,4,"NIP 19601126 198601 2 001",0,'L');
	    $pdf::SetMargins(31.8,25.4, 31.8);
	    $pdf::Ln(20);
	    $pdf::SetFont("Times","U",9);
	    $pdf::Cell(0,3,"Tembusan:",0,1,"L");
	    $pdf::SetFont("Times","",9);
	    $pdf::Cell(5,3,"1.",0,0,"L");
	    $pdf::Cell(0,3,"Direktur Administrasi Pendidikan IPB",0,1,"L");
	    $pdf::Cell(5,3,"2.",0,0,"L");
	    $pdf::Cell(0,3,"Ketua Departemen ".$this->departement_pemohon."",0,1,"L");
	    $pdf::Output();
		exit;
	}
}
?>