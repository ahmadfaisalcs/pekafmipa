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
class FrmFmipa15 extends Surat
{
	private $alasan_pemohon;
	private $email_pemohon;
	private $tlpn_pemohon;
	private $prodi_stk = "";
	private $prodi_gfm = "";
	private $prodi_bio = "";
	private $prodi_kim = "";
	private $prodi_mtk = "";
	private $prodi_kom = "";
	private $prodi_fis = "";
	private $prodi_bik = "";

	/*Set untuk keperluan apa surat tersebut*/
	function SetDataFormMahasiswa($alasan, $tlpn, $email)
	{
		$this->alasan_pemohon = $alasan;
		$this->email_pemohon = $email;
		$this->tlpn_pemohon = $tlpn;
	}

	function SetProdiData($prodi)
	{
        $prodi = strtolower($prodi);
		if($prodi == "statistika")
		{
			$this->prodi_stk = "V";
		}
		else if($prodi == "geofisika meteorologi")
		{
			$this->prodi_gfm = "V";
		}
		else if($prodi == "biologi")
		{
			$this->prodi_bio = "V";
		}
		else if($prodi == "kimia")
		{
			$this->prodi_kim = "V";
		}
		else if($prodi == "matematika")
		{
			$this->prodi_mtk = "V";
		}
		else if($prodi == "ilmu komputer")
		{
			$this->prodi_kom = "V";
		}
		else if($prodi == "fisika")
		{
			$this->prodi_fis = "V";
		}
		else
		{
			$this->prodi_bik = "V";
		}
	}

	/*Membuat PDF*/
	function GenerateSurat()
	{
		$pdf=new FPDF('P', 'mm', 'A4');
		$pdf::AddPage();
		$pdf::SetMargins(25.4,8.9, 25.4);
		$pdf::Ln(0);
		$pdf::SetFont('Arial','',10);
		$pdf::Cell(0,5,"No. Surat :".$this->nomor_surat,0,1,'R');
		$pdf::Ln(3);
	    $pdf::SetFont('Arial','BU',10);
	    $pdf::Cell(0,7,"FORMULIR DATA MAHASISWA YANG MENGAJUKAN SURAT KETERANGAN LULUS",0,1,'C');
	    $pdf::SetFont('Arial','',10);
	    $pdf::Cell(0,4,"POB/FMIPA-ADM/15/FRM-01-01 ; Tgl. 01/10/2015",0,1,'C');
	    $pdf::Ln(0);
	    $pdf::SetFont('Arial','B',10);
	    $pdf::MultiCell(0, 7, "Data Mahasiswa", 0, 'J');
	    $pdf::SetFont('Arial','',10);
	    $pdf::Cell(40, 5, "1.  Nama", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->nama_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "2.  NIM", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->nrp_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "3.  Program Studi", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->programstudi_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "4.  Semester", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->semester_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "5.  Untuk Keperluan", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->alasan_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "6.  Tlp/HP", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->tlpn_pemohon, 0,1,'L');
	    $pdf::Cell(40, 5, "7.  E-mail", 0,0,'L');
	    $pdf::Cell(0, 5, ":  ".$this->email_pemohon, 0,1,'L');
	    $pdf::SetMargins(118,0, 20);
	    $pdf::Ln(0);
	    $pdf::Cell(0,7,"Bogor,  ".$this->tanggal_pengajuan,0,1,'L');
	    $pdf::Cell(0,7,"Pemohon",0,1,'L');
	    $pdf::Ln(10);
	    $pdf::Cell(0,7,$this->nama_pemohon,0,1,'L');
	    $pdf::SetMargins(25.4,8.9, 25.4);
		$pdf::Ln(0);
	    $pdf::MultiCell(0,4, "CHECKLIST PEMERIKSAAN KELENGKAPAN BERKAS SURAT KETERANGAN LULUS (SKL) PROGRAM SARJANA (S-1) FMIPA - IPB", 0, 'C');
	    $pdf::SetLineWidth(0.5);
	    $pdf::Line(25, 143, 185, 143);
	    $pdf::Ln(2);
	    $pdf::SetFont('Arial','B',10);
	    $pdf::Cell(5, 4, "A.", 0,0,'L');
	    $pdf::Cell(0, 4, "Mengisi Biodata yang telah disediakan Fakultas, dengan melampirkan :", 0,1,'L');
	    $pdf::SetFont('Arial','',10);
	  	$pdf:: SetWidths(array(10,130,10));
        $pdf:: Row(array(
            '1.', 
            ' Pas Foto terbaru ukuran 3 x 4 cm (hitam putih) sebanyak 2 lembar (1 lembar ditempel di Biodata).', 
            'V'
        ));
        $pdf:: Row(array(
            '2.', 
            ' Surat keterangan dari ketua Departemen yang menyatakan telah menyelesaikan semua kewajiban administrasi dan akademik.', 
            'V'
        ));
        $pdf:: Row(array(
            '3.', 
            'Tanda bukti pembayaran SPP sampai semester terakhir (asli).', 
            'V'
        ));
        $pdf:: Row(array(
            '4.', 
            'Transkrip kumulatif dari departemen (asli) 1 (satu) lembar.', 
            'V'
        ));
        $pdf:: Row(array(
            '5.', 
            'Foto copy lembar pengesahan skripsi yang telah ditandatangani Pembimbing dan Ketua Departemen.', 
            'V'
        ));
        $pdf:: Row(array(
            '6.', 
            'Skripsi dan CD 1  (satu) buah.', 
            'V'
        ));
        $pdf:: Row(array(
            '7.', 
            'Foto Copy Bukti Pembayaran Wisuda.', 
            'V'
        ));
        $pdf:: Row(array(
            '8.', 
            'Kuisioner Survey Tingkat Kepuasan Lulusan FMIPA.', 
            'V'
        ));
	    $pdf::Ln(2);
	    $pdf::SetFont('Arial','B',10);
	    $pdf::Cell(5, 4, "B.", 0,0,'L');
	    $pdf::Cell(0, 4, "Berkas di atas dimasukkan ke dalam map folio :", 0,1,'L');
	    $pdf::SetFont('Arial','',10);
	    $pdf:: SetWidths(array(70,70,10));
	    $pdf:: Row(array(
            'Program Studi Kimia', 
            'warna kuning', 
            $this->prodi_kim
        ));
         $pdf:: Row(array(
            'Program Studi Meteorologi', 
            'warna merah', 
            $this->prodi_gfm
        ));
          $pdf:: Row(array(
            'Program Studi Statistika', 
            'warna biru', 
            $this->prodi_stk
        ));
           $pdf:: Row(array(
            'Program Studi Biologi', 
            'warna hijau', 
            $this->prodi_bio
        ));
            $pdf:: Row(array(
            'Program Studi Matematika', 
            'warna coklat', 
            $this->prodi_mtk
        ));
             $pdf:: Row(array(
            'Program Studi Ilmu Komputer', 
            'warna krem', 
            $this->prodi_kom
        ));
              $pdf:: Row(array(
            'Program Studi Fisika', 
            'warna pink (merah muda)', 
            $this->prodi_fis
        ));
               $pdf:: Row(array(
            'Program Studi Biokimia', 
            'warna Kuning', 
            $this->prodi_bik
        ));
	  	$pdf::Cell(6, 15, "Paraf Petugas   : .....................................", 0,0,'L');
	  	$pdf:: AddPage();
	  	$pdf::SetMargins(25.4,8.9, 25.4);
	  	$pdf::Ln(0);
            $pdf:: SetMargins(25.4, 8.89, 25.4);
            $pdf:: Ln(0.5);
            $pdf:: SetFont('Arial', 'BU', 14);
            $pdf:: Cell(0,5, "Verifikasi Dokumen Surat Keterangan Lulus", 0, 1, 'C');
            $pdf:: SetFont('Arial', '', 10);
            $pdf:: Cell(0,5,'POB/FMIPA-ADM/15/FRM-02-02 ; Tgl. 01/10/2015', 0, 0, 'C');
            $pdf:: Ln(10);
            
            $pdf:: Ln();
            $pdf:: SetWidths(array(56.71,46.88,55.70));
            $pdf:: SetFont('Arial', 'I', 9);
            
            $pdf:: Row(array(
                ' Bagian Administrasi Pendidikan', 
                ' Kepala Tata Usaha / 
 Sekretaris Fakultas', 
                ' Dekan / Wakil Dekan'
            ));
            $pdf:: SetFont('Arial', '', 9);
            $pdf:: Row(array(
                ' Tanggal  : '.$this->tgl_tinjut. '  Jam  : '.$this->jam_tinjut. '
                ',
                ' Tanggal  :              Jam  :
                ',
                ' Tanggal  :                      Jam  :
                '
            ));
            $pdf:: Row(array(
                ' Paraf      :
                ',
                ' Paraf      :
                ',
                ' Paraf      :
                '
            ));
            $pdf:: Row(array(
                ' Catatan tindak lanjut :
 '.$this->adm_catatan_tinjut.
                '
                ',
                ' Catatan tindak lanjut :
                
                ',
                ' Catatan tindak lanjut :
                
                '
            ));
            $pdf:: SetFont('Arial', 'I', 9);
            $pdf:: Row(array(
                ' Bagian Administrasi Pendidikan', 
                ' Kepala Tata Usaha / 
 Sekretaris Fakultas', 
                ' Dekan / Wakil Dekan'
            ));
            $pdf:: SetFont('Arial', '', 9);
            $pdf:: Row(array(
                ' Tanggal  :                      Jam  :
                ',
                ' Tanggal  :              Jam  :
                ',
                ' Tanggal  :                      Jam  :
                '
            ));
            $pdf:: Row(array(
                ' Paraf      :
                ',
                ' Paraf      :
                ',
                ' Paraf      :
                '
            ));
            $pdf:: Row(array(
                ' Catatan tindak lanjut :
                
                ',
                ' Catatan tindak lanjut :
                
                ',
                ' Catatan tindak lanjut :
                
                '
            ));
            $pdf:: SetWidths(array(159.30));
            $pdf:: Row(array(
            '
 Persetujuan pemohon untuk penyelesaian dokumen  : ..................... hari
                
                
 Paraf  pemohon : .................................
                '
            ));
            $pdf:: Output();
            exit;
	}
}
?>