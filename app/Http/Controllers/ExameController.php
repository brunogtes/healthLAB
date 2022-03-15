<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroExamesRequestes;
use App\Models\ModelExames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExameController extends Controller
{
    private $objConvenio;

    public function __construct()

    {
        $this->objExame = new ModelExames();
    }

    public function index()
    {

        $exame = $this->objExame->paginate(5);

        return view('cadastroExames', compact('exame'));
    }

    public function search(Request $request)
    {

        $search = $request->get('search');

        $exame = ModelExames::where('descricao', 'LIKE', '%' . $search . '%')
            ->orWhere('class_sexo', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroExames', compact('exame', 'search'));
    }

    public function create(CadastroExamesRequestes $request)
    {
        $exame = new ModelExames();
        $exame->descricao = $request->input('descricao');
        $exame->class_sexo = $request->input('class_sexo');
        $exame->status = $request->input('status');
        $exame->data_cadastro = date('YmdHis');
        $exame->data_atualizacao = date('YmdHis');
        $exame->save();

        return redirect('cadastroExames');
    }

    public function show($id)
    {
        $exame = $this->objExame->find($id);

        return view('cadastroExames', compact('exame'));
    }

    public function update(Request $request, $id)
    {
        $exame = ModelExames::find($id);
        $exame->descricao = $request->input('descricao');   
        $exame->class_sexo = $request->input('class_sexo');       
        $exame->status = $request->input('status');
        $exame->data_cadastro = date('YmdHis');
        $exame->save();

        return redirect('cadastroExames');
    }

    public function delete(Request $request, $id)
    {
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update tipo_exame set status=?, data_cadastro=? where id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroExames');
    }

    public function desativarAllExames(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);
        

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE tipo_exame SET status = "0" WHERE id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastroExames')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroExames');
        }
        return $red;
    }

    public function ativarAllExames(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);
        
        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE tipo_exame SET status = "1" WHERE id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroExames')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroExames');
        }
        return $red;
    }
}
