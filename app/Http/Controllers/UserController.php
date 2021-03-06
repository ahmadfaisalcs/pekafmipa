<?php

namespace App\Http\Controllers;

use App\Applicant;

use Session;
use App\User;
use App\Http\Controllers\Input;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

/**
 *
 */
class UserController extends Controller
{
  public function logout(Request $request)
  {
    Session::flush();
    return Redirect::to('/');
  }

  public function login(Request $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');

    $validation = Validator::make($request->all(), [
      'username' => 'required|exists:users,username',
      'password' => 'required|exists:users,password'
    ]);

    if($validation->fails()){
      return Redirect::to('/')->withErrors($validation)->withInput();
    }

    /*
    if (0) {
      // disedikan kondisi untuk login SSO ke IPB

      Session::put(['NIM' => $result->nim, 'studentName' => $result->nama]);
    }
    */

    else{
      /*
      kalau user belum punya data di applicant (baru pertama kali masuk) maka user ga akan bisa masuk
      */

      $get = Applicant::where('username', $username)->first();
      
      if (count($get) > 0) {
        Session::put(['username' => $get->username, 'id' => $get->id, 'nim' => $get->nim, 'mhs_name' => $get->nama, 'role' => $get->role, 'prodi' => $get->prodi, 'semester' => $get->semester, 'email' => $get->email, 'telp' => $get->telp]);
        $nim = $get->nim;
        $char = strtolower($nim[0]);
        // if ($char == 'g') {
        //   return Redirect::to('/status_permohonan');
        //   // echo $char;
        // }
        if ($char <> 'g') {
          Session::flash('warning', 'Mohon maaf, sistem ini hanya untuk mahasiswa FMIPA. Terimakasih telah berkunjung (^_^)');
          return redirect()->back();
          // echo "string";
        }
        else {
          return Redirect::to('/status_permohonan');
        }
      }

      /*
      // Get Role
      if($get->role == 'mhs'){
        // Auth::attempt(['username' => $request['username'], 'password' => $request['password']]);
        Session::put(['username' => $get->username, 'id' => $get->id, 'nim' => $get->nim, 'mhs_name' => $get->name, 'role' => $get->role, 'prodi' => $get->prodi]);
        $nim = $get->nim;
        $char = strtolower($nim[0]);
        if ($char == 'g') {
          return Redirect::to('/status_permohonan');
        }
        else {
          Session::flash('warning', 'Mohon maaf, sistem ini hanya untuk mahasiswa FMIPA. Terimakasih telah berkunjung (^_^)');
          return redirect()->back();
        }
      }
      */
      else {
        $get = User::where('username', $username)->first();

        if($get->role == 'adm'){
          Session::put(['id' => $get->id,'username' => $get->username, 'adm_name' => $get->name, 'role' => $get->role]);
          return Redirect::to('/adm_daftar_permohonan');
        }
        elseif($get->role == 'ktu'){
          Session::put(['id' => $get->id, 'username' => $get->username, 'ktu_name' => $get->name, 'role' => $get->role]);
          return Redirect::to('/ktu_daftar_permohonan');
        }
        elseif($get->role == 'srt'){
          Session::put(['id' => $get->id, 'username' => $get->username, 'srt_name' => $get->name, 'role' => $get->role]);
          return Redirect::to('/srt_daftar_permohonan');
        }
      }
    }
  }

  public function makeOne(Request $request)
  {
    $username = $request['username'];
    $name = $request['name'];
    $password = bcrypt($request['password']);
    $role = $request['role'];
    $nim = $request['nim'];

    $user = new User();
    $user->username = $username;
    $user->name = $name;
    $user->password = $password;
    $user->role = $role;
    $user->nim = $nim;

    $user->save();

    Session::flash('success', '#makeNewOne Berhasil (^_^)');
    return redirect()->back();

  }
}
