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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// PAGOS
Route::resource('pagos', 'PagoController');
Route::get('/pagos', 'PagoController@index')->name('pagos');
//------------------------------------------------------------------------------------


Route::get('pagosMiembro/{miembro_id}', ['as' => 'pagosMiembro', 'uses' => 'PagosMiembroController@index']);
Route::resource('pagosMiembro', 'PagosMiembroController');

Route::resource('equipos', 'EquipoController');

Route::resource('categorias', 'CategoriaController');

Route::resource('miembros', 'MiembroController');

Route::resource('documentos', 'DocumentoController');

Route::resource('reconocimientos', 'ReconocimientoController');

Route::get('/reconocimientos/create/{miembro_id}', 'ReconocimientoController@create');
Route::get('/reconocimientos/{miembro_id}', 'MiembroController@show')->name('recosMiembro');



Route::resource('equipaciones', 'EquipacionController');

Route::resource('equipacioneMiembroTalla', 'EquipacioneMiembroTallaController');


Route::get('documentosMiembros/{id}/docsMiembro', 'DocumentosMiembroController@docsMiembro')->name('docsMiembro');

Route::resource('documentosMiembros', 'DocumentosMiembroController');



Route::get('/home', 'HomeController@index')->name('home');

Route::get('/categorias', 'CategoriaController@index')->name('categorias');

Route::get('/equipos', 'EquipoController@index')->name('equipos');

Route::get('/miembros', 'MiembroController@index')->name('miembros');



Route::get('/equipaciones', 'EquipacionController@index')->name('equipaciones');

Route::get('/documentos', 'DocumentoController@index')->name('documentos');

Route::get('/equipacionesMiembro/{miembro_id}', 'MiembroController@equipacionesMiembro')->name('equipacionesMiembro');

Route::get('/equipacioneMiembroTalla/{miembro_id}', 'EquipacioneMiembroTallaController@edit')->name('equipacioneMiembroTalla');

Route::get('/equipos/{equipo_id}/{miembro_id}/{tipo}/asignar', 'EquipoController@asignar')->name('asignar');

Route::get('/equipos/{equipo_id}/{miembro_id}/{tipo}/deasignar', 'EquipoController@deasignar')->name('deasignar');

Route::get('/export-miembros', 'ExcelController@exportMiembros');

Route::get('/export-preinscripciones', 'ExcelController@exportPreinscripciones');

Route::get('/export-probados', 'ExcelController@exportProbados');

Route::get('/export-probadosPrenda', 'ExcelController@exportProbadosPrenda');

Route::get('/export-estadoDNI', 'ExcelController@exportEstadoDNI');

Route::get('/pdf-preinscripcion/{miembro_id}', 'PdfController@preinscripcion');

Route::get('/pdf-equipacion/{miembro_id}', 'PdfController@equipacion');

Route::resource('mail', 'MailController');
Route::get('/preinsAntiguos/{id}', 'MailController@preinsAntiguos')->name('preinsAntiguos');
Route::get('/insAntiguos/{id}/{pendiente}', 'MailController@insAntiguos')->name('insAntiguos');
Route::get('/preinsEquipo/{id}', 'MailController@preinsEquipo')->name('preinsEquipo');

Route::get('/preinsGenerica/{id}', 'MailController@preinsGenerica')->name('preinsGenerica');
Route::get('/insGenerica/{id}', 'MailController@insGenerica')->name('insGenerica');

Route::resource('preinscripciones', 'PreinscripcionController');

Route::get('/preinscripciones', 'PreinscripcionController@index')->name('preinscripciones');
Route::post('/preinscripcionOficina', 'PreinscripcionController@oficinaStore');

Route::get('/preinscripciones/{preinscripcion}/pagado', 'PreinscripcionController@pagado')->name('pagado');
Route::get('/preinscripciones/{preinscripcion}/prePago', 'PreinscripcionController@prePago')->name('prepago');
Route::get('/preinscripciones/{preinscripcion}/deshacerPago', 'PreinscripcionController@deshacerPago')->name('deshacerPago');

Route::get('/pdf-preinscripcionPagada/{preinscripcion}', 'PdfController@preinscripcionPagada')->name('pdf-preinscripcionPagada');

Route::get('crear-preins/{miembro_id}', ['as' => 'crear-preins', 'uses' => 'PreinscripcionController@create']);

Route::get('preins-oficina/{miembro}', ['as' => 'preins-oficina', 'uses' => 'PreinscripcionController@preinsOficinaCreate']);

Route::get('/miembros/baja/{miembro}', 'MiembroController@baja')->name('miembroBaja');
Route::get('/miembros/activar/{miembro}', 'MiembroController@activar')->name('miembroActivar');

Route::get('/pdf-certFedereco/{miembro}', 'PdfController@certFedeReco')->name('pdf-certFedeReco');
Route::get('/pdf-certFederecoEquipo/{equipo}', 'PdfController@certFedeRecoEquipo')->name('pdf-certFedeRecoEquipo');
Route::get('/pdf-cuotas/{temporada}', 'PdfController@cuotas')->name('pdf-cuotas');
Route::get('/pdf-reciboPago/{pago_id}/{cuota}/{pagado}', 'PdfController@reciboPago')->name('pdf-reciboPago');

//Correo de envío de un recibo
Route::get('/reciboPago/{pago_id}/{cuota}/{pagado}/{correo}', 'MailController@reciboPago')->name('reciboPago');
