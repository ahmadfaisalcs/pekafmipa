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
	class SuratCuti extends Surat
	{
		private $alasan_pemohon;
		private $romawisemester;
		private $semsetercuti_pemohon;
		private $tahunakademikcuti_pemohon;
		private $semesterdepan_pemohon;
		private $tahunakademikdepan_pemohon;
		/*Set untuk keperluan apa surat tersebut*/
		function SetAlasan($alasan)
		{
			$this->alasan_pemohon = $alasan;
		}

		function SetSemesterDepan($semesterdepan, $tahunakademikdepan, $semester)
		{
			$this->semesterdepan_pemohon = $this->SetGenapGanjil($semesterdepan);	
			$this->tahunakademikdepan_pemohon = $tahunakademikdepan;
			$this->romawisemester = $this->SetRomawi($semester);
		}

		function SetSemesterCuti($semestercuti, $tahunakademikcuti)
		{
			$this->semsetercuti_pemohon = $this->SetGenapGanjil($semestercuti);
			$this->tahunakademikcuti_pemohon = $tahunakademikcuti;
		}

		/*Membuat PDF*/
		function GenerateSuratCuti()
		{
			$pdf = new Fpdf('P', 'mm', 'A4');
			$pdf::AddPage();
			$pdf::SetMargins(30,50,30);
			$pdf::Ln();
		    $pdf::SetFont('Times','BU',14);
		    $pdf::Cell(0,5,"SURAT KETERANGAN CUTI AKADEMIK",0,1,'C');
		    $pdf::SetFont('Times','',11);
		    $pdf::Cell(0,5,"Nomor :".$this->nomor_surat,0,1,'C');
		    $pdf::Ln(10);
		    $pdf::MultiCell(0, 5, "Setelah mempertimbangkan permohonan mahasiswa yang diketahui oleh Orangtua dan surat Ketua Departemen ".$this->departement_pemohon." tentang izin cuti kuliah, Dekan Fakultas Matematika dan Ilmu Pengetahuan Alam, Institut Pertanian Bogor dengan ini memberikan izin kepada :", 0, 'J');
		    $pdf::SetMargins(50,50,30);
		    $pdf::Ln(5);
		    $pdf::Cell(30,6,"N a m a",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->nama_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"N I M",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->nrp_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"Program Studi",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->programstudi_pemohon,0,1,'L');
		    $pdf::Cell(30,6,"Semester",0,0,'L');
		    $pdf::Cell(0,6,":   ".$this->romawisemester.' ('.$this->semesterstring_pemohon.')',0,1,'L');
		    $pdf::SetMargins(30,50,30);
		    $pdf::Ln(5);
		    $pdf::MultiCell(0,5,"Untuk menangguhkan kegiatan akademik (cuti) pada semester ".$this->semsetercuti_pemohon." tahun akademik ".$this->tahunakademikcuti_pemohon." dengan alasan ".$this->alasan_pemohon.".",0,'J');
		    $pdf::MultiCell(0,5,"Dengan ketentuan :",0,'J');
		    $pdf::Cell(7,5,"1.",0,0,"L");
		    $pdf::MultiCell(0,5,"Selama masa cuti dikenakan SPP 25 % dari nilai SPP tiap semesternya;",0,"J");
		    $pdf::Cell(7,5,"2.",0,0,"L");
		    $pdf::MultiCell(0,5,"Pada awal semester ".$this->semesterdepan_pemohon." tahun akademik ".$this->tahunakademikdepan_pemohon." (satu bulan sebelum awal kuliah pada semester yang akan berjalan ) yang bersangkutan harus lapor ke FMIPA IPB untuk dinyatakan sebagai mahasiswa aktif;",0,"J");
		    $pdf::Cell(7,5,"3.",0,0,"L");
		    $pdf::MultiCell(0,5,"Bila batas waktu cuti akademik telah berakhir tapi yang bersangkutan tidak mengajukan permohonan aktif kembali, maka pada semester ".$this->semesterdepan_pemohon." tahun akademik ".$this->tahunakademikdepan_pemohon." dinyatakan sebagai mahasiswa non aktif dan dikenakan kewajiban membayar SPP penuh.",0,"J");
		    $pdf::SetMargins(115,50,30);
		    $pdf::Ln(5);
		    $pdf::MultiCell(0,4,"Bogor,  ".$this->tanggal_pengajuan,0,'L');
		    $pdf::MultiCell(0,4,"a.n. Dekan",0,'L');
		    $pdf::MultiCell(0,4,"Wakil Dekan",0,'L');
		    $pdf::MultiCell(0,4,"Bidang Akademik dan Kemahasiswaan,",0,'L');
		    $pdf::Ln(15);
		    $pdf::MultiCell(0,4,"Dr. Ir. Kgs Dahlan",0,'L');
		    $pdf::MultiCell(0,4,"NIP. 19600507 198703 1 003",0,'L');
		    $pdf::SetMargins(30,50,30);
		    $pdf::SetFont('Times','',9);
		    $pdf::Ln();
		    $pdf::Cell(0,3,"Tembusan",0,1,'L');
		    $pdf::Cell(0,3,"1.   Direktur Administrasi Pendidikan IPB",0,1,'L');
		    $pdf::Cell(0,3,"2.   Direktur Keuangan IPB",0,1,'L');
		    $pdf::Cell(0,3,"3.   Ketua Departemen",0,1,'L');
		    $pdf::Output();
			exit;
		}
	}
?>