<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItensExameRequest;
use App\Models\ModelExames;
use App\Models\ModelItensExames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItensExameController extends Controller
{
    private $objItensExames;

    public function __construct()

    {
        $this->objItensExames = new ModelItensExames();
        $this->objExames = new ModelExames();
    }


    public function index()
    {

        $itens = $this->objItensExames->paginate(5);
        $exame = $this->objExames->all();


        return view('cadastroItensExame', compact('itens', 'exame'));
    }

    public function search(Request $request)
    {

        $search = $request->get('search');

        $itens = ModelItensExames::where('descricao', 'LIKE', '%' . $search . '%')
            ->orWhere('descricao_reduzida', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $exame = ModelExames::where('descricao', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroItensExame', compact('itens', 'exame', 'search'));
    }

    public function create(ItensExameRequest $request)
    {
        $itens = new ModelItensExames();
        $itens->exame_id = $request->input('exame');
        $itens->descricao = $request->input('descricao');
        $itens->descricao_reduzida = $request->input('descricaoReduzida');
        $itens->valor_referencia = $request->input('valorReferencia');
        $itens->valor_minimo = $request->input('valorMinimo');
        $itens->valor_maximo = $request->input('valorMaximo');
        $itens->status = $request->input('status');
        $itens->data_cadastro = date('YmdHis');
        $itens->data_atualizacao = date('YmdHis');
        $itens->save();

        return redirect('cadastroItensExame');
    }

    public function update(Request $request, $id)
    {
        $itens = ModelItensExames::find($id);
        $itens->exame_id = $request->input('exame');
        $itens->descricao = $request->input('descricao');
        $itens->descricao_reduzida = $request->input('descricaoReduzida');
        $itens->valor_referencia = $request->input('valorReferencia');
        $itens->valor_minimo = $request->input('valorMinimo');
        $itens->valor_maximo = $request->input('valorMaximo');
        $itens->status = $request->input('status');
        $itens->data_atualizacao = date('YmdHis');
        $itens->save();

        return redirect('cadastroItensExame');
    }

    public function show($id)
    {
        $itens = $this->objItensExames->find($id);

        return view('cadastroItensExame', compact('itens'));
    }

    public function delete(Request $request, $id)
    {
       
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update itens_exames set status=?, data_cadastro=? where item_exame_id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroItensExame');
    }

    public function desativarAllItensExames(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE itens_exames SET status = "0" WHERE item_exame_id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastroItensExame')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroItensExame');
        }
        return $red;
    }

    public function ativarAllItensExames(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);


        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE itens_exames SET status = "1" WHERE item_exame_id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroItensExame')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroItensExame');
        }
        return $red;
    }
}
