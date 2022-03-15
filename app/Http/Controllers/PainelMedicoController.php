<?php

namespace App\Http\Controllers;

use App\Models\ModelExames;
use App\Models\ModelItensExames;
use Illuminate\Http\Request;
use App\Models\ModelResultadoExames;
use App\Models\ModelResultadoItensExame;
use App\Models\ModelUsuarios;
use Illuminate\Support\Facades\DB;

class PainelMedicoController extends Controller
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
        $listaPedidoMedicos = $this->objPedidoMedico->paginate(5);
        $listaUsuarios = $this->objUsuarios->where("perfil", "P")->get();
        $listaExames = $this->objExame->where("status", "1")->get();

        return view('painelMedico', compact('listaUsuarios', 'listaExames', 'listaPedidoMedicos'));
    }

    public function pegarUsuarios($usuario_id)

    {
        return ModelUsuarios::where('id', 'LIKE', '%' . $usuario_id . '%')->get();
    }

    public function search(Request $request)
    {

        $search = $request->get('search');

        $listaPedidoMedicos = ModelResultadoExames::where('paciente_id', 'LIKE', '%' . $search . '%')
            ->orWhere('etapa', 'LIKE', '%' . $search . '%')
            ->orWhere('exame_id', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaUsuarios = $this->objUsuarios->all();
        $listaExames = $this->objExame->all();

        return view('painelMedico', compact('listaPedidoMedicos', 'listaUsuarios', 'listaExames', 'search'));
    }

    public function store(Request $request)
    {

        $mensagens = [
            //Paciente
            'lista_paciente.required' => 'O campo Paciente é obrigatório',

            //Exame
            'exame.required' => 'O campo Exame é obrigatório',

        ];

        $request->validate([
            'lista_paciente' => 'required',
            'exame' => 'required',

        ], $mensagens);

        $pedidoMedico = new ModelResultadoExames();
        $pedidoMedico->paciente_id = $request->input('lista_paciente');
        $pedidoMedico->convenio_id = $request->input('convenio');
        $pedidoMedico->plano_id = $request->input('plano');
        $pedidoMedico->exame_id = $request->input('exame');
        $pedidoMedico->medico = $request->input('medico');
        $pedidoMedico->data_pedido_exame = date('d-m-y');
        $pedidoMedico->hora_pedido_exame = date("H:i:s");
        $pedidoMedico->data_cadastro = date('YmdHis');
        $pedidoMedico->data_atualizacao = date('YmdHis');
        $pedidoMedico->status = $request->input('situacao');
        $pedidoMedico->etapa = "Aguardando Agendamento";
        $pedidoMedico->save();

        $pedidoMedico_id = $pedidoMedico->resultado_exame_id;
        $itens = ModelItensExames::where('exame_id', 'LIKE', '%' . $pedidoMedico->exame_id . '%')->get();

        foreach ($itens as $item) {

            $itensExame = new ModelResultadoItensExame();
            $itensExame->id_pedido_medico = $pedidoMedico_id;
            $itensExame->id_exame = $pedidoMedico->exame_id;
            $itensExame->id_item_exame =  $item->item_exame_id;
            $itensExame->descricao_item =  $item->descricao;
            $itensExame->data_cadastro = date('YmdHis');
            $itensExame->data_atualizacao = date('YmdHis');
            $itensExame->save();
        }



        return redirect('painelMedico');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
