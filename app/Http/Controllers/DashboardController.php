<?php

namespace App\Http\Controllers;

use App\Models\ModelConvenios;
use App\Models\ModelExames;
use App\Models\ModelResultadoExames;
use App\Models\ModelUsuarios;
use App\Models\UserCustomModel;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $objUsuarios;
    private $objExame;
    private $objConvenio;
    private $objResulExame;

    public function __construct()

    {
        $this->objUsuarios = new ModelUsuarios();
        $this->objExame = new ModelExames();
        $this->objConvenio = new ModelConvenios();
        $this->objResulExame = new ModelResultadoExames();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        //Usuarios
        $usuariosAtivos = $this->objUsuarios::where('status', 1)->count();
        $usuariosInativos = $this->objUsuarios::where('status', 0)->count();
        $totalUsuarios = $this->objUsuarios->count();

        //Exames

        $ExamesAtivos = $this->objExame::where('status', 1)->count();
        $ExamesInativos = $this->objExame::where('status', 0)->count();

        //Convenios

        $ConveniosAtivo = $this->objConvenio::where('status', 1)->count();
        $ConveniosInativos = $this->objConvenio::where('status', 0)->count();

        //Status de Exames

        $aguardandoColeta = $this->objResulExame->where('etapa', 'Aguardando Coleta')->count();
        $aguardandoResultado = $this->objResulExame->where('etapa', 'Aguardando Resultado')->count();
        $exameFinalizado = $this->objResulExame->where('etapa', 'Finalizado')->count();
        $exameCancelado = $this->objResulExame->where('etapa', 'Cancelado')->count();

        //Quantidade de Exames - Mensal

        $qtdMes1 = $this->objResulExame::whereMonth('data_cadastro', '01')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes2 = $this->objResulExame::whereMonth('data_cadastro', '02')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes3 = $this->objResulExame::whereMonth('data_cadastro', '03')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes4 = $this->objResulExame::whereMonth('data_cadastro', '04')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes5 = $this->objResulExame::whereMonth('data_cadastro', '05')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes6 = $this->objResulExame::whereMonth('data_cadastro', '06')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes7 = $this->objResulExame::whereMonth('data_cadastro', '07')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes8 = $this->objResulExame::whereMonth('data_cadastro', '08')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes9 = $this->objResulExame::whereMonth('data_cadastro', '09')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes10 = $this->objResulExame::whereMonth('data_cadastro', '10')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes11 = $this->objResulExame::whereMonth('data_cadastro', '11')->whereYear('data_cadastro', now()->year)->count();
        $qtdMes12 = $this->objResulExame::whereMonth('data_cadastro', '12')->whereYear('data_cadastro', now()->year)->count();


        $teste =  $this->objResulExame::whereYear('data_cadastro', Carbon::now()->year)
            ->whereMonth('data_cadastro', Carbon::now()->month)
            ->count();

        //Quantidade de Coletas - Mensal

        $qtdColetaMes1 = $this->objResulExame::whereMonth('data_cadastro', '01')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes2 = $this->objResulExame::whereMonth('data_cadastro', '02')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes3 = $this->objResulExame::whereMonth('data_cadastro', '03')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes4 = $this->objResulExame::whereMonth('data_cadastro', '04')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes5 = $this->objResulExame::whereMonth('data_cadastro', '05')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes6 = $this->objResulExame::whereMonth('data_cadastro', '06')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes7 = $this->objResulExame::whereMonth('data_cadastro', '07')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes8 = $this->objResulExame::whereMonth('data_cadastro', '08')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes9 = $this->objResulExame::whereMonth('data_cadastro', '09')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes10 = $this->objResulExame::whereMonth('data_cadastro', '10')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes11 = $this->objResulExame::whereMonth('data_cadastro', '11')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();
        $qtdColetaMes12 = $this->objResulExame::whereMonth('data_cadastro', '12')->whereYear('data_cadastro', now()->year)->where('etapa', 'Aguardando Resultado')->count();


        return view('dashboard', compact('usuariosAtivos', 'usuariosInativos', 'ExamesAtivos', 'ExamesInativos', 'ConveniosAtivo', 'ConveniosInativos', 'aguardandoColeta', 'aguardandoResultado', 'exameFinalizado', 'exameCancelado', 'qtdMes1', 'qtdMes2', 'qtdMes3', 'qtdMes4', 'qtdMes5', 'qtdMes6', 'qtdMes7', 'qtdMes8', 'qtdMes9', 'qtdMes10', 'qtdMes11', 'qtdMes12', 'teste', 'qtdColetaMes1', 'qtdColetaMes2', 'qtdColetaMes3', 'qtdColetaMes4', 'qtdColetaMes5', 'qtdColetaMes6', 'qtdColetaMes7','qtdColetaMes8', 'qtdColetaMes9','qtdColetaMes10', 'qtdColetaMes11', 'qtdColetaMes12'));
    }
}
