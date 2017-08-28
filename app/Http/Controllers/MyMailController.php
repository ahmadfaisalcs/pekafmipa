<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Mail\Mailer ;
use App\Form;

class MyMailController extends Controller
{
    public $mailer;

	public function __construct(Mailer $mailer)
	{
    	$this->mailer = $mailer;
	}

    public function sendEmail($id)
    {
        // $connected = @fsockopen("www.google.com", 80);
        // if ($connected)
        // {
        // 	$hasil = Form::where('id',$id)->first();
        //     $this->mailer 
        //         -> to($hasil->email)
        //         -> send(new \App\Mail\MyMail($hasil));
        // }
        return redirect()->route('srt_daftar_permohonan_selesai');
    }
}
