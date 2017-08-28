<?php

namespace App\Http\Controllers;

use Fpdf;
// use Fpdi;
// use DateTime;
use Session;
use File;
use Storage;
use App\User;
use App\Form;
use App\Test;
use App\Http\Controllers\Input;
use App\Http\Requests;
use Illuminate\Http\Request; //5.4
use Illuminate\Http\UploadedFile; //5.4

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

// use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

// require ('public/fpdf/fpdf.php');
// require ('public/fpdi/fpdi.php');
/**
 *
 */
class CobaController extends Controller
{
  public function cobaCekFile(Request $request)
  {
    $nim = "G64130026";
    // $path = "coba".'/'."Maher Zain - Allah Ya Moulan".".mp3";
    $path = "lampiran".'/'.$nim.'/'."Surat Pengantar".".pdf";
    if(!Storage::exists($path))
    {
      echo $path;
      echo 'file ga ada';
    }
    else {
      echo $path;
      echo 'file ada';
    }
  }

  public function rollbackAndCommi(Request $request)
  {
    // if ($request->hasFile('spp') or $request->hasFile('ktm'))
    // {
    DB::transaction(function($request) use($request)
    {
                      /// coba weekend
                      // function isWeekend($date)
                      // {
                      //   return (date('N', strtotime($date)) >=6 );
                      // }
                      // $date = Carbon::now();
                      // $dayofweek = date("w", strtotime($date));
                      //
                      // echo $dayofweek;
      // $nim = 'G64130026';
      //
      // $current_date = Carbon::now();
      // $close_date = Carbon::now();
      // date_time_set($close_date, 16, 00, 00);
      //
      // if ($close_date < $current_date) {
      //   $request = Form::where('nim', $nim)->orderBy('updated_at', 'desc')->first();
      //   $isexist = sizeof($request);
      //   if ($isexist) {
      //     $last_request_date = $request['updated_at'];
      //     // $last_request_date = strtotime($last_request_date);
      //     $last_request_date_day = $last_request_date->format('Y-m-d');
      //     $current_date_day = $current_date->format('Y-m-d');
      //     if ($last_request_date_day == $current_date_day) {
      //       $input_date = $current_date;
      //       date_add($input_date, date_interval_create_from_date_string('1 days'));
      //       date_time_set($input_date, 00, 00, 01);
      //     }
      //     elseif ($last_request_date_day < $current_date_day) {
      //       $input_date = $current_date;
      //       date_add($input_date, date_interval_create_from_date_string('1 days'));
      //       date_time_set($input_date, 00, 00, 01);
      //       $thatday = date("D", strtotime($input_date));
      //       if ($thatday == 'Sat') {
      //         date_add($input_date, date_interval_create_from_date_string('2 days'));
      //         date_time_set($input_date, 00, 00, 01);
      //       }
      //       elseif ($thatday == 'Sun') {
      //         date_add($input_date, date_interval_create_from_date_string('1 days'));
      //         date_time_set($input_date, 00, 00, 01);
      //       }
      //     }
      //     else {
      //       $input_date = $request['updated_at'];
      //       date_add($input_date, date_interval_create_from_date_string('1 seconds'));
      //     }
      //   }
      //   else {
      //     $input_date = $current_date;
      //     date_add($input_date, date_interval_create_from_date_string('1 days'));
      //     date_time_set($input_date, 00, 00, 01);
      //     $thatday = date("D", strtotime($input_date));
      //     if ($thatday == 'Sat') {
      //       date_add($input_date, date_interval_create_from_date_string('2 days'));
      //       date_time_set($input_date, 00, 00, 01);
      //     }
      //     elseif ($thatday == 'Sun') {
      //       date_add($input_date, date_interval_create_from_date_string('1 days'));
      //       date_time_set($input_date, 00, 00, 01);
      //     }
      //     // echo $thatday;
      //   }
      // }
      // else {
      //   $input_date = $current_date;
      //   $thatday = date("D", strtotime($input_date));
      //   if ($thatday == 'Sat') {
      //     date_add($input_date, date_interval_create_from_date_string('2 days'));
      //     date_time_set($input_date, 00, 00, 01);
      //   }
      //   elseif ($thatday == 'Sun') {
      //     date_add($input_date, date_interval_create_from_date_string('1 days'));
      //     date_time_set($input_date, 00, 00, 01);
      //   }
      // }

      echo $input_date; echo "  "; echo $current_date_day;

    });
  }

  public function rollbackAndCommit(Request $request)
  {
    // $pdf = new \FPDI();
    // $pdf->AddPage();
    // $pdf->setSourceFile('/frm_template/fpdf.pdf');
    // $tplIdx = $pdf->importPage(1);
    // $pdf->useTemplate($tplIdx, 10, 10, 100);
    // $pdf->Output();
    // exit;

    $string1 = "G64130026";
    $date = "20".substr($string1,3,2)."/09"."/01";
    // echo $date;
    $date = strtotime($date);
    $date = date('Y/m/d', $date);
    $date = date_create($date);

    // $date1 = new DateTime();
    // $date1 = DateTime::createFromFormat('Y/m/d', $date);

    $tanggal = $request['tanggal'];
    // $date2 = new DateTime();
    // $date2 = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');

    // $date2 = substr($date,6,4)."-".substr($date,3,2)."-".substr($date,0,2); echo $date2;
    // $date2 = DateTime::createFromFormat('Y-m-d', $date2);
    //

    $tanggal = substr($tanggal,6,4)."/".substr($tanggal,3,2)."/".substr($tanggal,0,2);
    $tanggal = strtotime($tanggal);
    $tanggal = date('Y/m/d', $tanggal);
    $tanggal = date_create($tanggal);

    // echo $date1->format('d-m-Y');
    // echo "   ";
    // echo $date;

    $diff = $date->diff($tanggal);
    //  echo $diff;
    // 2013-09-01 2017-08-07
    $y = $diff->y; $m = $diff->m;
    $inmonth = $y*12 + $m;
    echo $inmonth;
  }



// require_once('fpdf.php');
// require_once('fpdi.php');
//
// // initiate FPDI
// $pdf = new FPDI();
// // add a page
// $pdf->AddPage();
// // set the source file
// $pdf->setSourceFile('PdfDocument.pdf');
// // import page 1
// $tplIdx = $pdf->importPage(1);
// // use the imported page and place it at position 10,10 with a width of 100 mm
// $pdf->useTemplate($tplIdx, 10, 10, 100);
//
// // now write some text above the imported page
// $pdf->SetFont('Helvetica');
// $pdf->SetTextColor(255, 0, 0);
// $pdf->SetXY(30, 30);
// $pdf->Write(0, 'This is just a simple text');
//
// $pdf->Output();
}
