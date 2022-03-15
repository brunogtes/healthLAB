<?php

namespace App\Http\Controllers;


use App\Models\ModelExames;
use App\Models\ModelItensExames;
use App\Models\ModelResultadoExames;
use App\Models\ModelResultadoItensExame;
use App\Models\ModelUsuarios;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;


class ExamePacienteController extends Controller
{
    private $objResulExame;
    private $objUsuarios;
    private $objExame;
    private $objItensExame;
    private $objResultadoItensExame;

    public function __construct()

    {
        $this->objResulExame = new ModelResultadoExames();
        $this->objUsuarios = new ModelUsuarios();
        $this->objExame = new ModelExames();
        $this->objItensExame = new ModelItensExames();
        $this->objResultadoItensExame = new ModelResultadoItensExame();
        $this->middleware('auth');    
        
    }

    public function index()
    {
        
        $exameFinalizado = $this->objResulExame->paginate(5);
        $listaUsuarios = $this->objUsuarios->all();
        $listaExames = $this->objExame->all();
        $itensExames = $this->objItensExame->all();
        $itensResultadoExame = $this->objResultadoItensExame->all();

        return view('exames', compact('listaExames', 'listaUsuarios', 'itensExames', 'itensResultadoExame', 'exameFinalizado'));
    }

    public function createExame($id)
    {
        //$exame = ModelResultadoExames::find($id);
        $exame = ModelResultadoExames::where('resultado_exame_id', $id)->get();
        $listaUsuarios = $this->objUsuarios->all();
        $listaExames = $this->objExame->all();
        $itensExames = $this->objItensExame->all();
        $itensResultadoExame = $this->objResultadoItensExame->all();

        $pdf = PDF::loadView('gerarExame_pdf', compact('exame', 'listaUsuarios', 'listaExames', 'itensExames','itensResultadoExame'));

        return $pdf->setPaper('a4')->stream('exame.pdf');
    }
}
