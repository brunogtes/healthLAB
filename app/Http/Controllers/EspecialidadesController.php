<?php

namespace App\Http\Controllers;

use App\Models\ModelEspecialidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadesController extends Controller
{

    private $objEspecialidades;

    public function __construct()


    {
        $this->objEspecialidades = new ModelEspecialidades();
    }

    public function index()
    {

        $especialidade = $this->objEspecialidades->paginate(5);

        return view('cadastroEspecialidades', compact('especialidade'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $especialidade = ModelEspecialidades::where('descricao', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroEspecialidades', compact('especialidade', 'search'));
    }

    public function create(Request $request)
    {
        $mensagens = [
            //Especialidade
            'especialidade.required' => 'O campo Especialidade é obrigatório',

            //Status
            'status.required' => 'O campo Status é obrigatório',
        ];

        $request->validate([
            'especialidade' => 'required',
            'status' => 'required',

        ], $mensagens);

        $especialidade = new ModelEspecialidades();
        $especialidade->descricao = $request->input('especialidade');
        $especialidade->status = $request->input('status');
        $especialidade->data_cadastro = date('YmdHis');
        $especialidade->data_atualizacao = date('YmdHis');
        $especialidade->save();

        return redirect('cadastroEspecialidades');
    }

    public function update(Request $request, $id)
    {
        $especialidade =  ModelEspecialidades::find($id);
        $especialidade->descricao = $request->input('especialidade');
        $especialidade->status = $request->input('status');
        $especialidade->data_atualizacao = date('YmdHis');
        $especialidade->save();

        return redirect('cadastroEspecialidades');
    }

    public function show($id)
    {
        $especialidade = $this->objEspecialidades->find($id);

        return view('cadastroEspecialidades', compact('especialidade'));
    }

    public function delete(Request $request, $id)
    {
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update especialidades_medicas set status=?, data_cadastro=? where id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroEspecialidades');
    }

    public function desativarAllEspecialidades(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE especialidades_medicas SET status = "0" WHERE id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastroEspecialidades')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroEspecialidades')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }

    public function ativarAllEspecialidades(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE especialidades_medicas SET status = "1" WHERE id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroEspecialidades')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroEspecialidades')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }
}
