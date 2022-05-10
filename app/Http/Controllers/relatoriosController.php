<?php

namespace App\Http\Controllers;

use App\Models\ModelConvenios;
use App\Models\ModelExames;
use App\Models\ModelPlano;
use App\Models\ModelResultadoExames;
use App\Models\ModelUsuarios;
use Illuminate\Http\Request;
use PDF;

class relatoriosController extends Controller
{
    //Cadastros

    public function createConvenioPDF()
    {
        $convenio = ModelConvenios::all();

        $pdf = PDF::loadView('conveniosPdf', compact('convenio'));

        return $pdf->setPaper('a4')->stream('convenios.pdf');
    }

    public function createPlanosPDF()
    {
        $plano = ModelPlano::all();

        $pdf = PDF::loadView('planosPdf', compact('plano'));

        return $pdf->setPaper('a4')->stream('planos.pdf');
    }

    public function createExamesPDF()
    {
        $exame = ModelExames::all();

        $pdf = PDF::loadView('examesPdf', compact('exame'));

        return $pdf->setPaper('a4')->stream('exames.pdf');
    }

    //Exames por Status

    public function createExameColetaPDF()
    {
        $coleta = ModelResultadoExames::where('etapa', 'Aguardando Coleta')->get();
        $listaUsuarios = ModelUsuarios::all();
        $listaExames = ModelExames::all();

        $pdf = PDF::loadView('aguardandoColetaPdf', compact('coleta', 'listaUsuarios', 'listaExames'));

        return $pdf->setPaper('a4')->stream('coleta.pdf');
    }

    public function createExameResultadoPDF()
    {
        $resultado = ModelResultadoExames::where('etapa', 'Aguardando Resultado')->get();
        $listaUsuarios = ModelUsuarios::all();
        $listaExames = ModelExames::all();

        $pdf = PDF::loadView('aguardandoResultadoPdf', compact('resultado', 'listaUsuarios', 'listaExames'));

        return $pdf->setPaper('a4')->stream('resultado.pdf');
    }

    public function createFinalizadosPDF()
    {
        $finalizado = ModelResultadoExames::where('etapa', 'Finalizado')->get();
        $listaUsuarios = ModelUsuarios::all();
        $listaExames = ModelExames::all();

        $pdf = PDF::loadView('finalizadoPdf', compact('finalizado', 'listaUsuarios', 'listaExames'));

        return $pdf->setPaper('a4')->stream('finalizados.pdf');
    }

    public function createCanceladosPDF()
    {
        $cancelado = ModelResultadoExames::where('etapa', 'Cancelado')->get();
        $listaUsuarios = ModelUsuarios::all();
        $listaExames = ModelExames::all();

        $pdf = PDF::loadView('canceladosPdf', compact('cancelado', 'listaUsuarios', 'listaExames'));

        return $pdf->setPaper('a4')->stream('cancelados.pdf');
    }

    public function createCustomizadoPDF(Request $request)
    {
        $dataInicial = $request->get('data_inicial');
        $dataFinal = $request->get('data_final');

        $exameCustomizado = ModelResultadoExames::where('data_atualizacao', '>=', $dataInicial)->where('data_atualizacao', '<=', $dataFinal)->get();
        $listaUsuarios = ModelUsuarios::all();
        $listaExames = ModelExames::all();

        $pdf = PDF::loadView('customizadoPdf', compact('exameCustomizado', 'listaUsuarios', 'listaExames'));

        return $pdf->setPaper('a4')->stream('customizado.pdf');
    }


}
