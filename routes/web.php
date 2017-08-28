<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::post('/auth', 'UserController@login');
Route::get('/logout', 'UserController@logout');

Route::get('/', function () {
    return view('welcome');
});


// VIEW Mahasiswa
Route::group(['middleware' => 'student'], function(){
  Route::get('/status_permohonan', [
  	'uses' => 'StdRequestController@studentDashboard',
  	'as' => 'status_permohonan'
  ]);
  Route::get('/pelayanan_online', function() {
    return view('mahasiswa.online-services');
  });
  // Route::get('/kuisioner_pelayanan', function() {
  //   return view('mahasiswa.questionnaire');
  // });
  Route::get('/kuisioner_pelayanan', [
  		'uses' => 'SatisfactionController@checkQuestionnaire',
  		'as' => 'kuisioner_pelayanan'
  	]);
  Route::get('/pendataan_wisuda', [
  	'uses' => 'GraduateController@checkGraduateData',
  	'as' => 'pendataan_wisuda'
  ]);
  // Route::get('/pendataan_lulusan', function () {
  //     return view('mahasiswa.biodata');
  // });
  Route::get('/pendataan_lulusan', [
    'uses' => 'GraduateController@checkGraduateData',
    'as' => 'pendataan_lulusan'
  ]);

  // frm
  Route::get('/jenis_frm_09a', function () {
      return view('mahasiswa.frm.frm09a_choose');
  });
  Route::get('/frm_09a/{id}', [
  	'uses' => 'StdRequestController@checkFrm09a'
  	// 'as' => 'frm_09a'
  ]);
  Route::get('/frm_09b', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_09b'
  ]);
  Route::get('/frm_10', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_10'
  ]);
  Route::get('/frm_11', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_11'
  ]);
  Route::get('/frm_12', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_12'
  ]);
  Route::get('/frm_13', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_13'
  ]);
  Route::get('/frm_14', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_14'
  ]);
  Route::get('/frm_15', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_15'
  ]);
  Route::get('/frm_16', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_16'
  ]);
  Route::get('/frm_17', [
  	'uses' => 'StdRequestController@checkFrmIsFill',
  	'as' => 'frm_17'
  ]);
  Route::get('/frm_notavailable', function() {
    return view('mahasiswa.frm.frm_notavailable');
  });

  // link frm update
  Route::get('/frm_update/{id}', 'StdRequestController@updatefrm');


  // submit request
  Route::post('/submit_frm_09a', [
  	'uses' => 'StdRequestController@submitRequest09a',
  	'as' => 'submit_frm_09a'
  ]);
  Route::post('/submit_frm_09b', [
  	'uses' => 'StdRequestController@submitRequest09b',
  	'as' => 'submit_frm_09b'
  ]);
  Route::post('/submit_frm_10', [
  	'uses' => 'StdRequestController@submitRequest10',
  	'as' => 'submit_frm_10'
  ]);
  Route::post('/submit_frm_11', [
  	'uses' => 'StdRequestController@submitRequest11',
  	'as' => 'submit_frm_11'
  ]);
  Route::post('/submit_frm_12', [
  	'uses' => 'StdRequestController@submitRequest12',
  	'as' => 'submit_frm_12'
  ]);
  Route::post('/submit_frm_13', [
  	'uses' => 'StdRequestController@submitRequest13',
  	'as' => 'submit_frm_13'
  ]);
  Route::post('/submit_frm_14', [
  	'uses' => 'StdRequestController@submitRequest14',
  	'as' => 'submit_frm_14'
  ]);
  Route::post('/submit_frm_15', [
  	'uses' => 'StdRequestController@submitRequest15',
  	'as' => 'submit_frm_15'
  ]);
  Route::post('/submit_frm_16', [
  	'uses' => 'StdRequestController@submitRequest16',
  	'as' => 'submit_frm_16'
  ]);
  Route::post('/submit_frm_17', [
  	'uses' => 'StdRequestController@submitRequest17',
  	'as' => 'submit_frm_17'
  ]);


  // update old request
  Route::post('/update_frm_09a', [
  	'uses' => 'StdRequestController@updateRequest09a',
  	'as' => 'update_frm_09a'
  ]);
  Route::post('/update_frm_09b', [
  	'uses' => 'StdRequestController@updateRequest09b',
  	'as' => 'update_frm_09b'
  ]);
  Route::post('/update_frm_10', [
  	'uses' => 'StdRequestController@updateRequest10',
  	'as' => 'update_frm_10'
  ]);
  Route::post('/update_frm_11', [
  	'uses' => 'StdRequestController@updateRequest11',
  	'as' => 'update_frm_11'
  ]);
  Route::post('/update_frm_12', [
  	'uses' => 'StdRequestController@updateRequest12',
  	'as' => 'update_frm_12'
  ]);
  Route::post('/update_frm_13', [
  	'uses' => 'StdRequestController@updateRequest13',
  	'as' => 'update_frm_13'
  ]);
  Route::post('/update_frm_14', [
  	'uses' => 'StdRequestController@updateRequest14',
  	'as' => 'update_frm_14'
  ]);
  Route::post('/update_frm_15', [
  	'uses' => 'StdRequestController@updateRequest15',
  	'as' => 'update_frm_15'
  ]);
  Route::post('/update_frm_16', [
  	'uses' => 'StdRequestController@updateRequest16',
  	'as' => 'update_frm_16'
  ]);
  Route::post('/update_frm_17', [
  	'uses' => 'StdRequestController@updateRequest17',
  	'as' => 'update_frm_17'
  ]);

  Route::post('/delete', [
    'uses' => 'StdRequestController@deleteRequest',
    'as' => 'delete'
  ]);

  // Kuisioner tingkat kepuasa layanan
  Route::post('/submit_kuisioner', [
  	'uses' => 'SatisfactionController@submitQuestionnaire',
  	'as' => 'submit_kuisioner'
  ]);

  // Pendataan wisuda
  Route::post('/submit_wisuda', [
  	'uses' => 'GraduateController@submitGraduateData',
  	'as' => 'submit_wisuda'
  ]);

  // Notifikasi
  Route::get('stdMarkAsRead', 'StdRequestController@markAsRead');
});


// VIEW Tendik administrasi akademik
Route::group(['middleware' => 'adm'], function(){
  Route::get('/adm_daftar_permohonan', [
  	'uses' => 'AdmRequestController@admDashboard',
  	'as' => 'adm_daftar_permohonan'
  ]);
  Route::get('/adm_daftar_permohonan_keterangan', [
  	'uses' => 'AdmRequestController@admRequestInfo',
  	'as' => 'adm_daftar_permohonan_keterangan'
  ]);
  Route::get('/adm_perbaikan_ktu', [
  	'uses' => 'AdmRequestController@admKtuCorrection',
  	'as' => 'adm_perbaikan_ktu'
  ]);

  // link cek request adm
  Route::get('/frm_admcheck/{id}', 'AdmRequestController@admCheck');

  // adm update frm
  Route::post('/adm_update', [
  	'uses' => 'AdmRequestController@updateRequest',
  	'as' => 'adm_update'
  ]);

  Route::get('markAsRead', 'AdmRequestController@markAsRead');

  Route::post('/adm_print_form/{id}', [
    'uses' => 'AdmRequestController@printForm',
    'as' => 'adm_print_form'
  ]);
});


// VIEW KTU
Route::group(['middleware' => 'ktu'], function(){
  Route::get('/ktu_daftar_permohonan', [
  	'uses' => 'KtuRequestController@ktuDashboard',
  	'as' => 'ktu_daftar_permohonan'
  ]);
  Route::get('/ktu_daftar_keterangan_perbaikan', [
  	'uses' => 'KtuRequestController@ktuRequestInfo',
  	'as' => 'ktu_daftar_keterangan_perbaikan'
  ]);
  // Route::get('/kepuasan_layanan', function() {
  //   return view('ktu.satisfaction');
  // });
  // Route::get('/kepuasan_layanan', [
  // 	'uses' => 'SatisfactionController@getSatisfaction',
  // 	'as' => 'kepuasan_layanan'
  // ]);
  Route::match(['get', 'post'], '/kepuasan_layanan', [
    'uses' => 'SatisfactionController@getSatisfaction',
    'as' => 'kepuasan_layanan'
  ]);

  // Route::get('/rekapitulasi_lulusan', [
  // 	'uses' => 'GraduateController@getRecapitulation',
  // 	'as' => 'rekapitulasi_lulusan'
  // ]);
  Route::match(['get', 'post'], '/rekapitulasi_lulusan', [
    'uses' => 'GraduateController@getRecapitulation',
    'as' => 'rekapitulasi_lulusan'
  ]);

  // link cek request ktu
  Route::get('/frm_ktucheck/{id}', 'KtuRequestController@ktuCheck');

  // adm update frm
  Route::post('/ktu_update', [
  	'uses' => 'KtuRequestController@updateRequest',
  	'as' => 'ktu_update'
  ]);

  // ---sasaran mutu
  // Route::get('/qo_09a', function() {
  //   return view('ktu.qo.09a');
  // });
  Route::match(['get', 'post'], '/qo_09a', [
  	'uses' => 'QualityObjectiveController@get_qo_09a',
  	'as' => 'qo_09a'
  ]);
  Route::match(['get', 'post'], '/qo_09b', [
  	'uses' => 'QualityObjectiveController@get_qo_09b',
  	'as' => 'qo_09b'
  ]);
  Route::match(['get', 'post'], '/qo_10', [
  	'uses' => 'QualityObjectiveController@get_qo_10',
  	'as' => 'qo_10'
  ]);
  Route::match(['get', 'post'], '/qo_11', [
  	'uses' => 'QualityObjectiveController@get_qo_11',
  	'as' => 'qo_11'
  ]);
  Route::match(['get', 'post'], '/qo_12', [
  	'uses' => 'QualityObjectiveController@get_qo_12',
  	'as' => 'qo_12'
  ]);
  Route::match(['get', 'post'], '/qo_13', [
  	'uses' => 'QualityObjectiveController@get_qo_13',
  	'as' => 'qo_13'
  ]);
  Route::match(['get', 'post'], '/qo_14', [
  	'uses' => 'QualityObjectiveController@get_qo_14',
  	'as' => 'qo_14'
  ]);
  Route::match(['get', 'post'], '/qo_15', [
  	'uses' => 'QualityObjectiveController@get_qo_15',
  	'as' => 'qo_15'
  ]);
  Route::match(['get', 'post'], '/qo_16', [
  	'uses' => 'QualityObjectiveController@get_qo_16',
  	'as' => 'qo_16'
  ]);
  Route::match(['get', 'post'], '/qo_17', [
  	'uses' => 'QualityObjectiveController@get_qo_17',
  	'as' => 'qo_17'
  ]);

  Route::post('/ktu_print_form/{id}', [
    'uses' => 'KtuRequestController@printForm',
    'as' => 'ktu_print_form'
  ]);

  Route::post('/get_qo', [
    'uses' => 'QualityObjectiveController@check_to_get_qo',
    'as' => 'get_qo'
  ]);

  // Notifikasi
  Route::get('ktuMarkAsRead', 'KtuRequestController@markAsRead');
});


// VIEW TENDIK. PERSURATAN
Route::group(['middleware' => 'srt'], function(){
  // daftar permohonan
  Route::get('/srt_daftar_permohonan', [
  	'uses' => 'SrtRequestController@SrtDashboard',
  	'as' => 'srt_daftar_permohonan'
  ]);
  Route::get('/srt_daftar_permohonan_selesai', [
  	'uses' => 'SrtRequestController@SrtRequestDone',
  	'as' => 'srt_daftar_permohonan_selesai'
  ]);
  Route::post('/srt_update', [
  	'uses' => 'SrtRequestController@updateRequest',
  	'as' => 'srt_update'
  ]);
  Route::get('/sendmail/{id}', 'MyMailController@sendEmail')->name('sendmail');
});


////////// COBA COBA COBA COBA ///////////

Route::get('/make_a_new_one', function () {
    return view('register');
});
Route::post('/makeone', 'UserController@makeOne');

Route::get('/coba1', function() {
  return view('coba.coba1');
});
Route::post('/coba1_submit', [
	'uses' => 'CobaController@rollbackAndCommit',
	'as' => 'coba1_submit'
]);

Route::get('admin', function () {
    return view('admin_template');
});

// Route::get('/home', 'HomeController@index');
/*View Surat PDF*/
Route::get('/SuratCutiPDF/{id}', 'PDF\PDFSurat@SuratCutiController');
Route::get('/SuratAktifKuliahPDF/{id}', 'PDF\PDFSurat@SuratAktifKuliahController');
Route::get('/SuratAktifSetelahCutiPDF/{id}', 'PDF\PDFSurat@SuratAktifSetelahCutiController');
Route::get('/SuratKeteranganLulusPDF/{id}', 'PDF\PDFSurat@SuratKeteranganLulusController');
Route::get('/SuratPercepatanIjazahPDF/{id}', 'PDF\PDFSurat@SuratPercepatanIjazahController');
Route::get('/SuratPerpanjanganStudiPDF/{id}', 'PDF\PDFSurat@SuratPerpanjanganStudiController');
Route::get('/SuratSidangKomisiPDF/{id}', 'PDF\PDFSurat@SuratSidangKomisiController');
Route::get('/SuratTunjanganAnakPDF/{id}', 'PDF\PDFSurat@SuratTunjanganAnakController');
Route::get('/SurtaUndurDiriPDF/{id}', 'PDF\PDFSurat@SuratUndurDiriController');

Route::get('/FrmFmipa09a/{id}', 'PDF\PDFSurat@FrmFmipa09aController');
Route::get('/FrmFmipa09b/{id}', 'PDF\PDFSurat@FrmFmipa09bController');
Route::get('/FrmFmipa10/{id}', 'PDF\PDFSurat@FrmFmipa10Controller');
Route::get('/FrmFmipa11/{id}', 'PDF\PDFSurat@FrmFmipa11Controller');
Route::get('/FrmFmipa12/{id}', 'PDF\PDFSurat@FrmFmipa12Controller');
Route::get('/FrmFmipa13/{id}', 'PDF\PDFSurat@FrmFmipa13Controller');
Route::get('/FrmFmipa14/{id}', 'PDF\PDFSurat@FrmFmipa14Controller');
Route::get('/FrmFmipa15/{id}', 'PDF\PDFSurat@FrmFmipa15Controller');
Route::get('/FrmFmipa16/{id}', 'PDF\PDFSurat@FrmFmipa16Controller');
Route::get('/FrmFmipa17/{id}', 'PDF\PDFSurat@FrmFmipa17Controller');
