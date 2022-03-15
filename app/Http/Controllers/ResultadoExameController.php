<?php

namespace App\Http\Controllers;

use App\Models\ModelExames;
use App\Models\ModelItensExames;
use App\Models\ModelResultadoExames;
use App\Models\ModelResultadoItensExame;
use App\Models\ModelUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class ResultadoExameController extends Controller
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

        $resulExame = $this->objResulExame->where('etapa', 'Aguardando Coleta')->paginate(5);
        $aguardandoResultado = $this->objResulExame->where('etapa', 'Aguardando Resultado')->paginate(5);
        $exameFinalizado = $this->objResulExame->where('etapa', 'Finalizado')->paginate(5);
        $exameCancelado = $this->objResulExame->where('etapa', 'Cancelado')->paginate(5);
        $listaUsuarios = $this->objUsuarios->all();
        $listaExames = $this->objExame->all();
        $itensExames = $this->objItensExame->all();
        $itensResultadoExame = $this->objResultadoItensExame->all();

        return view('cadastroResulExames', compact('listaExames', 'resulExame', 'listaUsuarios', 'aguardandoResultado', 'itensExames', 'itensResultadoExame', 'exameFinalizado', 'exameCancelado'));
    }


    public function search(Request $request)
    {

        $search = $request->get('search');

        $resulExame = ModelResultadoExames::where('paciente', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->orWhere('medico', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroResulExames', compact('resulExame', 'search'));
    }

    public function confirmarColeta(Request $request, $id)
    {
        $mensagens = [

            //Data Coleta
            'dataAgendamentoColeta.required' => 'O campo Data Coleta é obrigatório',

            //Hora Coleta
            'horaAgendamentoColeta.required' => 'O campo Hora Coleta é obrigatório',

        ];

        $request->validate([
            'dataAgendamentoColeta' => 'required',
            'horaAgendamentoColeta' => 'required',

        ], $mensagens);


        $agendamentoColeta = ModelResultadoExames::find($id);
        $agendamentoColeta->data_coleta_exame = $request->input('dataAgendamentoColeta');
        $agendamentoColeta->hora_coleta_exame = $request->input('horaAgendamentoColeta');
        $agendamentoColeta->bioquimico_coleta = $request->input('bioquimicoColeta');
        $agendamentoColeta->data_atualizacao = date('YmdHis');
        $agendamentoColeta->etapa = "Aguardando Resultado";
        $agendamentoColeta->save();

        return redirect('cadastroResulExames');
    }

    public function inserirResultado(Request $request, $id)
    {

        $resultadoExame = ModelResultadoExames::find($id);
        $exame_id =  $resultadoExame->exame_id;

        $itens = ModelItensExames::where('exame_id', 'LIKE', '%' . $exame_id . '%')->count();

        for ($i = 1; $i <= $itens; $i++) {
            $itensResultado = ModelResultadoItensExame::where('id_pedido_medico', $id)->where('id_exame', $exame_id)->where('id_item_exame', $request->input('id_' . $i))->first();
            $itensResultado2 = ModelResultadoItensExame::find($itensResultado->id);
            $itensResultado2->valor =  $request->input('resultado_' . $i);
            $itensResultado2->observacoes =  $request->input('observacoes_' . $i);
            $itensResultado2->data_atualizacao = date('YmdHis');
            $itensResultado2->save();
        }

        $concluirExame = ModelResultadoExames::find($id);
        $concluirExame->data_resultado_exame = $request->input('dataResultadoExame');
        $concluirExame->hora_resultado_exame = $request->input('horaResultado');
        $concluirExame->bioquimico_resultado = $request->input('bioquimicoResultado');
        $concluirExame->data_atualizacao = date('YmdHis');
        $concluirExame->etapa = "Finalizado";
        $concluirExame->save();

        return redirect('cadastroResulExames');
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
