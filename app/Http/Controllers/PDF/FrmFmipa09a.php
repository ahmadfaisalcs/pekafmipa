<?php
    namespace App\Http\Controllers\PDF;
	
    use Illuminate\Http\Request;
	use App\Http\Controllers\PDF\Surat;
	use Fpdf;
    use Carbon\Carbon;
	/* 	
		$pdf=new PDF('P', 'mm', 'A4') (Potrait, pengukur kertas dalam mm, Ukuran kertas)
		AddPage() = Menambahkan Page baru
		SetMargins() = Set Margin untuk tulisan dibawahnya (kiri, atas, kanan)
		Ln() = Tinggi dari Newline
		SetFont() = Set Font(jenis tulisan, Bold/Italic/Underline, ukuran tulisan)
		MultiCell = Menulis banyak cell / paragraph (lebar cell(default 0), tinggi cell, text, border, align)
		Output() = Menampilkan / download PDF
	*/

    class FrmFmipa09a extends Surat {

        private $alasan_pemohon;
        private $email_pemohon;
        private $tlpn_pemohon;
        private $jenis_permohonan;

        /*Set untuk keperluan apa surat tersebut*/
        function SetDataFormMahasiswa($alasan, $tlpn, $email, $jenis_permohonan)
        {
            $this->alasan_pemohon = $alasan;
            $this->email_pemohon = $email;
            $this->tlpn_pemohon = $tlpn;
            $this->jenis_permohonan = $jenis_permohonan;
        }

        function GenerateSurat() {

            $pdf = new FPDF();
            $pdf:: AddPage();
            $pdf:: SetMargins(25.40, 8.89, 25.40);
            $pdf:: SetFont('Arial', '', 10);
            $pdf:: Cell(120, 5, ' ', 0,0, 'L');
            $pdf:: Cell(30, 5, 'No. Surat : '. $this-> nomor_surat, 0, 1, 'L');
            $pdf:: Ln(5);
            $pdf:: SetFont('Arial', 'BU', 11);
            $pdf:: Cell(0, 5, 'PERMOHONAN SURAT KETERANGAN', 0, 1, 'C');
            $pdf:: SetFont('Arial', '',10);
            $pdf:: Cell(0, 5,'POB/FMIPA-ADM/09/FRM-01a-01 ; Tgl. 01/10/2015', 0,1, 'C');
            $pdf:: Ln(5);
            $pdf:: SetFont('Arial', 'B', 10);
            $pdf:: Cell(0, 5, 'Data Mahasiswa', 0, 1, 'L');
            $pdf:: Ln(5);
            $pdf:: SetFont('Arial', '', 10);
            
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
            
            $pdf:: Ln(3);
            $pdf:: Cell(100, 5, ' ', 0, 0, 'L');
            $pdf:: Cell(0, 5, 'Bogor, '. $this -> tanggal_pengajuan, 0, 1, 'L');
            $pdf:: Ln(5);
            $pdf:: Cell(100, 5, ' ', 0, 0, 'L');
            $pdf:: Cell(0, 5, 'Pemohon,', 0, 1, 'L');
            $pdf:: Ln(15); 
            $pdf:: Cell(100, 5, ' ', 0, 0, 'L');
            $pdf:: Cell(0, 5, $this -> nama_pemohon , 0, 1, 'L');

            $pdf:: Ln(20);
            $pdf:: Cell(90, 5, '', 0, 0, 'L');
            $pdf:: Cell(0, 5, 'Akademik', 0, 1, 'L');
            $pdf:: Ln(3);
            $pdf:: Cell(60, 5, '*      Persyaratan surat Pembuatan Visa', 0, 1, 'L');
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       1.   Surat Pengantar Departemen', 0, 0, 'L');
            if ($this->jenis_permohonan == "Pembuatan Visa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       2.   Fotocopy SPP', 0, 0, 'L');
            if ($this->jenis_permohonan == "Pembuatan Visa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       3.   Fotocopy KTM', 0, 0, 'L');
            if ($this->jenis_permohonan == "Pembuatan Visa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }

            $pdf:: Ln(3);
            $pdf:: Cell(60, 5, '*      Persyaratan surat Aktif / Beasiswa (tuliskan)', 0, 1, 'L');
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       1.   Surat rekomendasi dari departemen', 0, 0, 'L');
            if ($this->jenis_permohonan == "Beasiswa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       2.   Fotocopy SPP', 0, 0, 'L');
            if ($this->jenis_permohonan == "Beasiswa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       3.   Fotocopy KTM', 0, 0, 'L');
            if ($this->jenis_permohonan == "Beasiswa") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }

            $pdf:: Ln(3);
            $pdf:: Cell(60, 5, '*      Persyaratan kehilangan KTM (tuliskan)', 0, 1, 'L');
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       1.   Surat keterangan dari kepolisian', 0, 0, 'L');
            if ($this->jenis_permohonan == "Kehilangan KTM") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }
            $pdf:: Ln(1);
            $pdf:: Cell(95, 5, '       2.   Fotocopy SPP', 0, 0, 'L');
            if ($this->jenis_permohonan == "Kehilangan KTM") { $pdf:: Cell(5, 5, 'V', 1, 1, 'L'); }
            else { $pdf:: Cell(5, 5, '', 1, 1, 'L'); }

            $pdf:: Ln(10);
            $pdf:: Cell(0, 5, 'Paraf petugas : ..................................');

            $pdf:: SetMargins(25.4, 8.89, 25.4);
            $pdf:: AddPage();
            $pdf:: Ln(0.5);
            $pdf:: SetFont('Arial', 'BU', 14);
            $pdf:: Cell(0,5, "Verifikasi Dokumen Surat Keterangan", 0, 1, 'C');
            $pdf:: SetFont('Arial', '', 10);
            $pdf:: Cell(0,5,'POB/FMIPA-ADM/09/FRM-02-02; Tgl. 01/10/2015', 0, 0, 'C');
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