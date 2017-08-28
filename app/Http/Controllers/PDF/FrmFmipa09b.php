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
class FrmFmipa09b extends Surat
{
	private $alasan_pemohon;
	private $email_pemohon;
	private $tlpn_pemohon;
	private $nama_orangtua;
	private $nip_orangtua;
	private $pangkat_orangtua;
	private $instansi_orangtua;
	private $tlpn_orangtua;

	/*Set untuk keperluan apa surat tersebut*/
	function SetDataFormMahasiswa($alasan, $tlpn, $email)
	{
		$this->alasan_pemohon = $alasan;
		$this->email_pemohon = $email;
		$this->tlpn_pemohon = $tlpn;
	}

	function SetDataFormOrangTua($nama, $nip, $pangkat, $instansi, $tlpn)
	{
		$this->nama_orangtua = $nama;
		$this->nip_orangtua = $nip;
		$this->pangkat_orangtua = $pangkat;
		$this->instansi_orangtua = $instansi;
		$this->tlpn_orangtua = $tlpn;
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
		$pdf::Ln(5);
	    $pdf::SetFont('Arial','BU',14);
	    $pdf::Cell(0,7,"SURAT KETERANGAN AKTIF KULIAH UNTUK TUNJANGAN ANAK",0,1,'C');
	    $pdf::SetFont('Arial','',10);
	    $pdf::Cell(0,5,"POB/FMIPA-ADM/ 09/FRM-01b-01; Tgl. 01/10/2015",0,1,'C');
	    $pdf::Ln(2);
	    $pdf::MultiCell(0, 9, "Data Mahasiswa", 0, 'J');
	    $pdf::Cell(40, 7, "1.  Nama", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->nama_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "2.  NIM", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->nrp_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "3.  Program Studi", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->programstudi_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "4.  Semester", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->semester_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "5.  Untuk Keperluan", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->alasan_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "6.  Tlp/HP", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->tlpn_pemohon, 0,1,'L');
	    $pdf::Cell(40, 7, "7.  E-mail", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->email_pemohon, 0,1,'L');
	    $pdf::MultiCell(0, 9, "Data Orang Tua", 0, 'J');
	    $pdf::Cell(40, 7, "1.  Nama", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->nama_orangtua, 0,1,'L');
	    $pdf::Cell(40, 7, "2.  NIP", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->nip_orangtua, 0,1,'L');
	    $pdf::Cell(40, 7, "3.  Pangkat, Golongan", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->pangkat_orangtua, 0,1,'L');
	    $pdf::Cell(40, 7, "4.  Instansi", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->instansi_orangtua, 0,1,'L');
	    $pdf::Ln(7);
	    $pdf::Cell(40, 7, "5.  Telp/HP", 0,0,'L');
	    $pdf::Cell(0, 7, ":  ".$this->tlpn_orangtua, 0,1,'L');
	    $pdf::SetMargins(118,0, 20);
	    $pdf::Ln(3);
	    $pdf::Cell(0,7,"Bogor,  ".$this->tanggal_pengajuan,0,1,'L');
	    $pdf::Cell(0,7,"Pemohon",0,1,'L');
	    $pdf::Ln(14);
	    $pdf::Cell(0,7,$this->nama_pemohon,0,1,'L');
	    $pdf::SetMargins(110,0, 20);
	    $pdf::Ln(4);
	    $pdf::Cell(0, 4, "Akademik", 0,1,'L');
	    $pdf::SetMargins(25.4,0, 20);
	    $pdf::Ln(0);
	    $pdf::Cell(8, 4, "*", 0,0,'L');
	    $pdf::Cell(0, 4, "Persyaratan", 0,1,'L');
	    $pdf::Ln(4);
	  	$pdf::Cell(8, 4, "", 0,0,'L');
	  	$pdf::Cell(8, 4, "1.", 0,0,'L');
	    $pdf::Cell(75, 4, "Fotocopy SPP", 0,0,'L');
	    $pdf::SetFont('Arial','',12);
	    $pdf::Cell(5, 4, 'V', 1,1,'L');
	    $pdf::SetFont('Arial','',10);
	    $pdf::Cell(8, 4, "", 0,0,'L');
	  	$pdf::Cell(8, 4, "2.", 0,0,'L');
	    $pdf::Cell(75, 4, "Fotocopy KTM", 0,0,'L');
	    $pdf::SetFont('Arial','',12);
	    $pdf::Cell(5, 4, 'V', 1,1,'L');
	    $pdf::SetFont('Arial','',10);
	    $pdf::Ln(10);
	    $pdf::Cell(8, 4, "", 0,0,'L');
	  	$pdf::Cell(8, 4, "Paraf Petugas   : .....................................", 0,0,'L');
	  	$pdf:: AddPage();
	  	$pdf::SetMargins(25.4,8.9, 25.4);
	  	$pdf::Ln(0);
            $pdf:: SetMargins(25.4, 8.89, 25.4);
            $pdf:: Ln(0.5);
            $pdf:: SetFont('Arial', 'BU', 14);
            $pdf:: Cell(0,5, "Verifikasi Dokumen Surat Keterangan", 0, 1, 'C');
            $pdf:: SetFont('Arial', '', 10);
            $pdf:: Cell(0,5,'POB/FMIPA-ADM/09/FRM-02-02 ; Tgl. 01/10/2015', 0, 0, 'C');
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