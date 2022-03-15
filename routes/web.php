<?php

use App\Http\Controllers\Auth\CustomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\EspecialidadeXMedicosController;
use App\Http\Controllers\ExameController;
use App\Http\Controllers\ExamesXPlanosController;
use App\Http\Controllers\PlanoController;
use App\Http\Controllers\ResultadoExameController;
use App\Http\Controllers\ItensExameController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PainelMedicoController;
use App\Http\Controllers\AgendamentoController;
use App\Http\Controllers\ExamePacienteController;
use App\Http\Controllers\RegistrarUsuarioController;

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

Route::get('/inicio', [App\Http\Controllers\InicioController::class, 'index'])->name('inicio');
Route::get('/perfil', [App\Http\Controllers\PerfilController::class, 'index'])->name('perfil');
Route::put('/perfil/{usuario_id}', [App\Http\Controllers\PerfilController::class, 'update']);
Route::put('perfil_img/{usuario_id}', [App\Http\Controllers\PerfilController::class, 'upload_imagem']);
Route::put('perfil/alterarSenha/{usuario_id}', [App\Http\Controllers\PerfilController::class, 'alterarSenha']);


Route::get('dashboard', [CustomAuthControlleroller::class, 'dashboard']); 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


Route::get('auth/google', [App\Http\Controllers\GoogleController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [App\Http\Controllers\GoogleController::class, 'handleGoogleCallback']);

Route::get('login/facebook', [App\Http\Controllers\FacebookController::class, 'redirectToProvider']);
Route::get('login/facebook/callback', [App\Http\Controllers\FacebookController::class, 'handleProviderCallback']);

Route::get('/', function () {
    return redirect('login');
});


//Route::get('/inicio', function () {
//    return view('inicio');
//});

Route::get('/exames', function () {
    return view('exames');
});


Route::get('/cadastro', function () {
    return view('createUser');
});

/* Exame - Paciente */

Route::get('/exames', [ExamePacienteController::class, 'index']);

Route::get('exames/gerarExame/{id_exame}', [ExamePacienteController::class, 'createExame']);

/* Cadastro de Convenios */

Route::get('/cadastroConvenios', [ConvenioController::class, 'index']);

Route::post('/cadastroConvenios/create', [ConvenioController::class, 'create']);

Route::put('/cadastroConvenios/{convenio}/update', [ConvenioController::class, 'update']);

Route::get('/cadastroConvenios/{convenio}/show', [ConvenioController::class, 'show']);

Route::delete('/cadastroConvenios/{convenio}/delete', [ConvenioController::class, 'delete']);

Route::get('/cadastroConvenios/search', [ConvenioController::class, 'search']);

Route::delete('/desativarAll', [ConvenioController::class, 'desativarAll']);

Route::delete('/ativarAll', [ConvenioController::class, 'ativarAll']);

/* Cadastro de Planos */

Route::get('/cadastroPlanos', [PlanoController::class, 'index']);

Route::get('/cadastroPlanos/search', [PlanoController::class, 'search']);

Route::post('/cadastroPlanos/create', [PlanoController::class, 'create']);

Route::get('/cadastroPlanos/{planos}/show', [PlanoController::class, 'show']);

Route::put('/cadastroPlanos/{planos}/update', [PlanoController::class, 'update']);

Route::put('/cadastroPlanos/{planos}/delete', [PlanoController::class, 'delete']);

Route::delete('/desativarAllPlanos', [PlanoController::class, 'desativarAllPlanos']);

Route::delete('/ativarAllPlanos', [PlanoController::class, 'ativarAllPlanos']);


/* Cadastro de Exames */

Route::get('/cadastroExames', [ExameController::class, 'index']);

Route::get('/cadastroExames/search', [ExameController::class, 'search']);

Route::get('/cadastroExames/create', [ExameController::class, 'create']);

Route::get('/cadastroExames/{exame}/show', [ExameController::class, 'show']);

Route::put('/cadastroExames/{exame}/update', [ExameController::class, 'update']);

Route::delete('/cadastroExames/{exame}/delete', [ExameController::class, 'delete']);

Route::delete('/desativarAllExames', [ExameController::class, 'desativarAllExames']);

Route::delete('/ativarAllExames', [ExameController::class, 'ativarAllExames']);

/* Cadastro de Itens de Exames */

Route::get('/cadastroItensExame', [ItensExameController::class, 'index']);

Route::get('/cadastroItensExame/search', [ItensExameController::class, 'search']);

Route::get('/cadastroItensExame/create', [ItensExameController::class, 'create']);

Route::put('/cadastroItensExame/{itemExame}/update', [ItensExameController::class, 'update']);

Route::get('/cadastroItensExame/{itemExame}/show', [ItensExameController::class, 'show']);

Route::delete('/cadastroItensExame/{itemExame}/delete', [ItensExameController::class, 'delete']);

Route::delete('/desativarAllItensExames', [ItensExameController::class, 'desativarAllItensExames']);

Route::delete('/ativarAllItensExames', [ItensExameController::class, 'ativarAllItensExames']);


/* Cadastro de Resultado de Exames */

Route::get('/cadastroResulExames', [ResultadoExameController::class, 'index']);

Route::put('/cadastroResulExames/{resulExame}/confirmarColeta', [ResultadoExameController::class, 'confirmarColeta']);

Route::put('/cadastroResulExames/inserirResultado/{id_item}', [ResultadoExameController::class, 'inserirResultado']);

Route::get('cadastroResulExames/gerarExame/{id_exame}', [ResultadoExameController::class, 'createExame']);

/* Cadastro de Especialidades */

Route::get('/cadastroEspecialidades', [EspecialidadesController::class, 'index']);

Route::get('/cadastroEspecialidades/search', [EspecialidadesController::class, 'search']);

Route::post('/cadastroEspecialidades/create', [EspecialidadesController::class, 'create']);

Route::put('/cadastroEspecialidades/{especialidade}/update', [EspecialidadesController::class, 'update']);

Route::get('/cadastroEspecialidades/{especialidade}/show', [EspecialidadesController::class, 'show']);

Route::put('/cadastroEspecialidades/{especialidade}/delete', [EspecialidadesController::class, 'delete']);

Route::delete('/desativarAllEspecialidades', [EspecialidadesController::class, 'desativarAllEspecialidades']);

Route::delete('/ativarAllEspecialidades', [EspecialidadesController::class, 'ativarAllEspecialidades']);

/* Cadastro de Especialidades  X Medicos */

Route::get('/cadastroEspecialidadesXMedicos', [EspecialidadeXMedicosController::class, 'index']);

Route::get('/cadastroEspecialidadesXMedicos/search', [EspecialidadeXMedicosController::class, 'search']);

Route::post('/cadastroEspecialidadesXMedicos/create', [EspecialidadeXMedicosController::class, 'create']);

Route::put('/cadastroEspecialidadesXMedicos/{amarracaoEspMed}/update', [EspecialidadeXMedicosController::class, 'update']);

Route::get('/cadastroEspecialidadesXMedicos/{amarracaoEspMed}/show', [EspecialidadeXMedicosController::class, 'show']);

Route::put('/cadastroEspecialidadesXMedicos/{amarracaoEspMed}/delete', [EspecialidadeXMedicosController::class, 'delete']);

Route::delete('/desativarAllEspecialidadesMedicos', [EspecialidadeXMedicosController::class, 'desativarAllEspecialidadesMedicos']);

Route::delete('/ativarAllEspecialidadesMedicos', [EspecialidadeXMedicosController::class, 'ativarAllEspecialidadesMedicos']);

/* Cadastro de Exame X Planos */

Route::get('/cadastroExamesXPlanos', [ExamesXPlanosController::class, 'index']);

Route::get('/cadastroExamesXPlanos/search', [ExamesXPlanosController::class, 'search']);

Route::post('/cadastroExamesXPlanos/create', [ExamesXPlanosController::class, 'create']);

Route::put('/cadastroExamesXPlanos/{amarracaoExameXplano}/update', [ExamesXPlanosController::class, 'update']);

Route::get('/cadastroExamesXPlanos/{amarracaoExameXplano}/show', [ExamesXPlanosController::class, 'show']);

Route::delete('/cadastroExamesXPlanos/{amarracaoExameXplano}/delete', [ExamesXPlanosController::class, 'delete']);

Route::delete('/desativarAllExameXPlano', [ExamesXPlanosController::class, 'desativarAllExameXPlano']);

Route::delete('/ativarAllExameXPlano', [ExamesXPlanosController::class, 'ativarAllExameXPlano']);

/* Cadastro de Usuarios */

Route::get('/cadastrarUsuarios/pegarCidades/{convenio_id}', [UsuariosController::class, 'pegarCidades']);

Route::get('/cadastrarUsuarios', [UsuariosController::class, 'index']);

Route::post('/cadastrarUsuarios/create', [UsuariosController::class, 'store']);

Route::put('/cadastrarUsuarios/{usuario_id}/update', [UsuariosController::class, 'update']);

Route::get('/cadastrarUsuarios/{usuario_id}/show', [UsuariosController::class, 'show']);

Route::delete('/cadastrarUsuarios/{usuario_id}/delete', [UsuariosController::class, 'delete']);

Route::get('/cadastrarUsuarios/search', [UsuariosController::class, 'search']);

Route::delete('/desativarAllUsuarios', [UsuariosController::class, 'desativarAllUsuarios']);

Route::delete('/ativarAllUsuarios', [UsuariosController::class, 'ativarAllUsuarios']);

Route::get('cadastrarUsuarios/pdf', [UsuariosController::class, 'createPDF']);

Route::get('cadastrarUsuarios/excel', [UsuariosController::class, 'createExcel']);

/* Painel Médico */

Route::get('painelMedico', [PainelMedicoController::class, 'index']);
Route::get('/painelMedico/pegarUsuario/{usuario_id}', [PainelMedicoController::class, 'pegarUsuarios']);
Route::post('painelMedico/create', [PainelMedicoController::class, 'store']);
Route::get('painelMedico/{usuario_id}/show', [PainelMedicoController::class, 'show']);
Route::get('/painelMedico/search', [PainelMedicoController::class, 'search']);

/* Agendamento */

Route::get('agendamento', [AgendamentoController::class, 'index']);
Route::put('agendamento/{id}/update', [AgendamentoController::class, 'update']);
Route::put('agendamento/{id}/cancelamento', [AgendamentoController::class, 'cancelamentoAgendmento']);
Route::get('agendamento/{id}/show', [AgendamentoController::class, 'show']);


/* Cadastro de Usuario em Pagina Publica */


Route::get('cadastro', [RegistrarUsuarioController::class, 'index']);
Route::post('/cadastro/create', [RegistrarUsuarioController::class, 'store']);
Route::get('/cadastro/pegarPlanos/{convenio_id}', [RegistrarUsuarioController::class, 'pegarPlanos']);

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/relatorios', function () {
    return view('relatorios');
});



