<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroPlanosRequest;
use Illuminate\Http\Request;
use App\Models\ModelPlano;
use App\Models\ModelConvenios;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    private $objPlano;
    private $objConvenio;

    public function __construct()

    {
        $this->objPlano = new ModelPlano();
        $this->objConvenio = new ModelConvenios();
    }

    public function index()
    {

        $plano = $this->objPlano->orderBy('descricao', 'asc')->paginate(5);
        $convenio = $this->objConvenio->all();

        return view('cadastroPlanos', compact('plano', 'convenio'));
    }

    public function search(Request $request)
    {

        $search = $request->get('search');
        $convenio = $this->objConvenio->paginate(5);

        $plano = ModelPlano::where('descricao', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroPlanos', compact('plano', 'search', 'convenio'));
    }

    public function create(CadastroPlanosRequest $request)
    {

        $plano = new ModelPlano();
        $plano->convenio_id = $request->input('convenio');
        $plano->descricao = $request->input('descricao');
        $plano->status = $request->input('situacao');
        $plano->data_cadastro = date('YmdHis');
        $plano->data_atualizacao = date('YmdHis');
        $plano->save();
        return redirect('cadastroPlanos');
    }

    public function show($id)
    {
        $plano = $this->objPlano->find($id);

        return view('cadastroPlanos', compact('plano'));
    }

    public function update(Request $request, $id)
    {

        $plano =  ModelPlano::find($id);
        $plano->convenio_id = $request->input('convenio');
        $plano->descricao = $request->input('descricao');
        $plano->status = $request->input('status');
        $plano->data_atualizacao = date('YmdHis');         
        $plano->save();
    
         return redirect('cadastroPlanos'); 

    }

    public function delete(Request $request, $id)
    {

        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update planos set status=?, data_cadastro=? where plano_id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroPlanos');
    }

    public function desativarAllPlanos(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);
        
        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE planos SET status = "0" WHERE plano_id IN (' . implode(",", $ids) . ')');

        //  return redirect('cadastroConvenios');

        if ($dbs) {
            $red = redirect('cadastroPlanos')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroPlanos');
           // $red = redirect('cadastroPlanos')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }

    public function ativarAllPlanos(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE planos SET status = "1" WHERE plano_id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroPlanos')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroPlanos');
        }
        return $red;
    }
}
