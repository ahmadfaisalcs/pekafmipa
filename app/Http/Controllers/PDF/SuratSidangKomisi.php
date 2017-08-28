<?php
    namespace App\Http\Controllers\PDF;

	use Illuminate\Http\Request;
	use App\Http\Controllers\PDF\Surat;
	use Fpdf;

    class SuratSidangKomisi extends Surat {

        private $perihal;
        private $pembimbing;
        
        private $pembimbing1;
        private $pembimbing2;
        
        private $jabatan;
        private $saudara;
        private $hari_sidang;
        // private $tanggal;
        private $jam_sidang;
        private $tempat_sidang;
        private $nama_dekan;
        private $NRP;

        private $tanggal;
        private $bulan;
        private $tahun;

        // private $departement_pemohon;

        function SetPerihal($keperluan) {
            $this -> perihal = $keperluan;
        }

        // function SetDepartemenPemohon($dept)
        // {
        //     $this->departement_pemohon = $dept;
        // }

        function SetPembimbing($pembimbing1, $pembimbing2) {
            $this -> pembimbing1 = $pembimbing1;
            $this -> pembimbing2 = $pembimbing2;
        }

        function SetJabatanPembimbing($jabatan_pembimbing) {
            $this -> jabatan = $jabatan_pembimbing;
        }

        function SetJenisKelamin($jenis_kelamin) {
            if ($jenis_kelamin == 'L')
                $this -> saudara = 'Saudara';
            else
                $this -> saudara = 'Saudari';
        }

        function SetHari($hari) {
            $this -> hari_sidang = $hari;
        }

        function SetTanggalSidang($tanggal_sidang) {
            // $this -> tanggal = $tanggal_sidang;

            $this->tanggal = substr($tanggal_sidang,0,2);
            $bln = substr($tanggal_sidang,3,2);
            $this->tahun = substr($tanggal_sidang,6,4);
            $this->bulan = $this->IntToMonth($bln);

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

        function SetPukulSidang($pukul_sidang) {
            $this -> jam_sidang = $pukul_sidang;
        }

        function SetTempatSidang($tempat_sidang) {
            $this -> tempat_sidang = $tempat_sidang;
        }

        function SetNamaDekan($dekan) {
            $this -> nama_dekan = $dekan;
        }

        function SetNrpDekan($NRP_dekan) {
            $this -> NRP = $NRP_dekan;
        }

        function GenerateSuratSidangKomisi() {

            $pdf = new Fpdf('P', 'mm', 'A4');
            $pdf::AddPage();
            $pdf::SetMargins(30,50,30);
            $pdf::SetFont('Times', '', 11);
            $pdf::Ln(0);
            $pdf::Cell(130, 5, 'N o m o r      :   '.$this -> nomor_surat, 
            0, 0, "L");
            $pdf::Cell(20, 5, $this -> tanggal_pengajuan, 0, 1, "L");
            $pdf::Cell(25, 5, 'Perihal          :');
            $pdf::SetFont('Times', 'B', 11);
            $pdf::Cell(120, 5, 'Undangan Sidang Komisi Program Magister', 0, 1, "L");
            
            $pdf::SetFont('Times', '', 11);            
            $pdf::Cell(25, 5, "Yth               : ",
            0, 0, "L");
            $pdf::Cell(120, 5, "Komisi pembimbing mahasiswa a.n. ". $this->nama_pemohon, 0, 1, "L");
            
            $pdf::SetMargins(54.40,50,30);
            $pdf::Ln(0);
            // nama pembimbing dengan jabatan pembimbing.
            // for ($i = 0; $i < sizeof($this -> pembimbing); $i++){
            //     $nomor = $i + 1;
            //     $pdf::Cell(105,5,$nomor.'. '.$this -> pembimbing[$i], 
            //     0, 0, "J");
            //     $pdf::Cell(20, 5,'('.$this -> jabatan[$i].')', 0,  1, "J");
            // }

            $pdf::Cell(105,5,'1'.'. '.$this->pembimbing1, 0, 0, "J");
            $pdf::Cell(20, 5,'('.'Ketua'.')', 0,  1, "J");
            $pdf::Cell(105,5,'2'.'. '.$this->pembimbing2, 0, 0, "J");
            $pdf::Cell(20, 5,'('.'Anggota'.')', 0,  1, "J");


            $pdf::Cell(120, 5, 'di', 0, 1, 'L');
            $pdf::Cell(120, 5, 'B o g o r', 0, 1, 'L');
            $pdf::SetMargins(30,50,30);
            $pdf::Ln(10);
            $pdf::MultiCell(0, 5, 'Bersama ini kami mengundang '. $this -> saudara .' untuk dapat hadir pada rapat/pertemuan komisi pembimbing atas nama '. /*$this -> saudara .' '.*/ $this -> nama_pemohon .' NRP.'. $this->nrp_pemohon .' dari Program Studi '. $this->departement_pemohon .' yang akan dilaksanakan pada :', 0,'J');
            $pdf::Ln(8);
            $pdf::Cell(28, 5, '       H a r i            ', 0, 0, 'L');
            $pdf::Cell(120, 5, ' :   '. $this -> hari_sidang, 0, 1, 'L');
            $pdf::Cell(28, 5, '       Tanggal            ', 0, 0, 'L');
            $pdf::Cell(120, 5, ' :   '. $this->tanggal.' '.$this->bulan.' '.$this->tahun, 0, 1, 'L');
            $pdf::Cell(28, 5, '       Pukul            ', 0, 0, 'L');
            $pdf::Cell(120, 5, ' :   '. $this -> jam_sidang, 0, 1, 'L');
            $pdf::Cell(28, 5, '       Tempat            ', 0, 0, 'L');
            $pdf::Cell(120, 5, ' :   '. $this -> tempat_sidang, 0, 1, 'L');
            $pdf::Ln(8);
            $pdf::MultiCell(0, 5, 'Demikian disampaikan, atas perhatian dan kehadiran Saudara tepat pada waktunya kami ucapkan terima kasih.', 0,'J');
            $pdf::Ln(10);
            $pdf::Cell(100, 5, ' ', 0,0,'L');
            $pdf::Cell(20, 5, 'Plh D e k a n,', 0, 1, 'L');
            $pdf::SetMargins(30,50,30);
            $pdf::Ln(30);
            $pdf::Cell(100, 5, '', 0, 0, 'L');
            $pdf::Cell(20, 5, $this -> nama_dekan, 0, 1, 'L');
            $pdf::Cell(100, 5, '', 0, 0, 'L');
            $pdf::Cell(20, 5, 'NRP.'.$this -> NRP, 0, 1, 'L');
            $pdf::Ln(10);
            $pdf::SetFont('Times', '',9);
            $pdf::Cell(100, 3, 'Tembusan : ', 0, 1, 'L');
            $pdf::Cell(100, 3, 'Ketua Program Studi '. $this->departement_pemohon, 0, 0, 'L');

            $pdf::Output();
            exit;

        }
    }
?>