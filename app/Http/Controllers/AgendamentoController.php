<?php

namespace App\Http\Controllers;

use App\Models\ModelExames;
use Illuminate\Http\Request;
use App\Models\ModelResultadoExames;
use App\Models\ModelUsuarios;
use Illuminate\Support\Facades\DB;

class AgendamentoController extends Controller
{
    private $objPedidoMedico;
    private $objUsuarios;
    private $objExame;

    public function __construct()

    {
        $this->objPedidoMedico = new ModelResultadoExames();
        $this->objUsuarios = new ModelUsuarios();
        $this->objExame = new ModelExames();
        $this->middleware('auth');
    }

    public function index()
    {
        $listaPedidoMedicos = $this->objPedidoMedico->where("etapa", "Aguardando Agendamento")->orWhere("etapa", "Aguardando Coleta")->paginate(5);
        $listaUsuarios = $this->objUsuarios->all();
        $listaExames = $this->objExame->all();

        return view('agendamento', compact('listaUsuarios', 'listaExames', 'listaPedidoMedicos'));
    }


    public function update(Request $request, $id)
    {

        $mensagens = [

            //Data Agendamento
            'dataAgendamentoColeta.required' => 'O campo Data Coleta é obrigatório',

             //Hora Coleta
             'horaAgendamentoColeta.required' => 'O campo Hora Coleta é obrigatório',

        ];

        $request->validate([
            'dataAgendamentoColeta' => 'required',
            'horaAgendamentoColeta' => 'required',

        ], $mensagens);


        $agendamentoMedico = ModelResultadoExames::find($id);
        $agendamentoMedico->data_coleta_exame = $request->input('dataAgendamentoColeta');
        $agendamentoMedico->hora_coleta_exame = $request->input('horaAgendamentoColeta');
        $agendamentoMedico->atendente = $request->input('nomeFuncionario');
        $agendamentoMedico->data_atualizacao = date('YmdHis');
        $agendamentoMedico->etapa = "Aguardando Coleta";
        $agendamentoMedico->save();

        return redirect('agendamento');
    }

    public function show($id)
    {
        $agendamentoMedico = $this->objPedidoMedico->find($id);

        return view('agendamento', compact('agendamentoMedico'));
    }

    public function cancelamentoAgendmento(Request $request, $id)
    {

        $mensagens = [
            //Paciente
            'motivoCancelamento.required' => 'O campo Motivo do Cancelamento é obrigatório',

        ];

        $request->validate([
            'motivoCancelamento' => 'required',

        ], $mensagens);

        $cancelamentoAgendamento = ModelResultadoExames::find($id);
        $cancelamentoAgendamento->motivo_cancelamento = $request->input('motivoCancelamento');
        $cancelamentoAgendamento->data_atualizacao = date('YmdHis');
        $cancelamentoAgendamento->etapa = "Cancelado";
        $cancelamentoAgendamento->save();

        return redirect('agendamento');
    }
}
