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
	class SuratAktifSetelahCuti extends Surat
	{
		private $semsetercuti_pemohon;
		private $semseteraktif_pemohon;
		private $tahunakademikcuti_pemohon;

		/*Membuat PDF*/
		function GenerateSuratAktifSetelahCuti()
		{
			$pdf=new Fpdf('P', 'mm', 'A4');
			$pdf::AddPage();
			$pdf::SetMargins(30,50, 30);
			$pdf::Ln();
		    $pdf::SetFont('Times','BU',14);
		    $pdf::Cell(0,5,"SURAT KETERANGAN AKTIF KULIAH",0,1,'C');
		    $pdf::SetFont('Times','',11);
		    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
		    $pdf::Ln(10);
		    $pdf::MultiCell(0, 5, "Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor dengan ini menerangkan bahwa,", 0, 'J');
		    $pdf::SetMargins(50,50, 30);
		    $pdf::Ln(5);
		    $pdf::Cell(30,6,"N a m a",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->nama_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"N I M",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->nrp_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"Semester",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->semester_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"Program Studi",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->programstudi_pemohon,0,1,'L');
		    $pdf::SetMargins(30,50, 30);
		    $pdf::Ln(5);
		    $pdf::MultiCell(0,5,"Telah melapor ke Fakultas pada tanggal ".$this->tanggal_pengajuan." setelah Cuti Akademik pada semester ".$this->semsetercuti_pemohon." tahun akademik ".$this->tahunakademikcuti_pemohon.".",0,'J');
		    $pdf::Ln(5);
		    $pdf::MultiCell(0,5,"Surat keterangan ini sebagai pernyataan bahwa mahasiswa tersebut akan aktif kembali kuliah pada semester ".$this->semseteraktif_pemohon." tahun akademik ".$this->tahunakademik_pemohon." dan yang bersangkutan telah menyelesaikan administrasi pendidikan.",0,'J');
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
		    $pdf::SetMargins(30,50,30);
		    $pdf::SetFont('Times','',9);
		    $pdf::Ln(10);
    	    $pdf::Cell(0,3,"Tembusan",0,1,'L');
		    $pdf::Cell(0,3,"1.   Direktur Administrasi Pendidikan IPB",0,1,'L');
		    $pdf::Cell(0,3,"2.   Ketua Departement ".$this->departement_pemohon);
		    $pdf::Output();
		}
		/*Setting kapan cuti*/
		function SetSemesterCuti($semester)
		{
			$this->semsetercuti_pemohon = $this->SetGenapGanjil($semester);
		}
		/*Setting kapan aktif kembali*/
		function SetSemesterAktif($semester)
		{
			$this->semseteraktif_pemohon = $this->SetGenapGanjil($semester);
		}
		/*Set tahun akademik Cuti*/
		function SetTahunAkademikCuti($tahunakademik)
		{
			$this->tahunakademikcuti_pemohon = $tahunakademik;
		}
	}
?>