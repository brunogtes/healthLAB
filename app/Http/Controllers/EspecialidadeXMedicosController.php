<?php

namespace App\Http\Controllers;

use App\Models\ModelEspecialidades;
use App\Models\ModelEspecialidadesXMedicos;
use App\Models\ModelMedicos;
use App\Models\ModelUsuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EspecialidadeXMedicosController extends Controller
{
    private $objEspecialidadesXMedicos;
    private $objMedicos;
    private $objEspecialidades;
    private $objUsuarios;

    public function __construct()


    {
        $this->objEspecialidadesXMedicos = new ModelEspecialidadesXMedicos();
        $this->objMedicos = new ModelMedicos();
        $this->objEspecialidades = new ModelEspecialidades();
        $this->objUsuarios = new ModelUsuarios();
    }

    public function index()
    {

        $arracaoEspMedico = $this->objEspecialidadesXMedicos->paginate(5);
        $listaMedicos = $this->objMedicos->all();
        $especialidade = $this->objEspecialidades->where("status", "1")->get();;
        $listaUsuarios = $this->objUsuarios->where("perfil", "M")->get();

        return view('cadastroEspecialidadesXMedicos', compact('arracaoEspMedico', 'listaMedicos', 'especialidade', 'listaUsuarios'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $arracaoEspMedico = ModelEspecialidadesXMedicos::where('especialidade_id', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaMedicos = ModelMedicos::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $especialidade = ModelEspecialidades::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroEspecialidadesXMedicos', compact('arracaoEspMedico', 'listaMedicos', 'especialidade', 'search'));
    }

    public function create(Request $request)
    {
        $mensagens = [
            //Médico
            'medico.required' => 'O campo Médico é obrigatório',

            //Especialidade
            'especialidade.required' => 'O campo Especialidade é obrigatório',

             //Status
             'status.required' => 'O campo Status é obrigatório',
        ];

        $request->validate([
            'medico' => 'required',
            'especialidade' => 'required',
            'status' => 'required',

        ], $mensagens);

        $arracaoEspMedico = new ModelEspecialidadesXMedicos();
        $arracaoEspMedico->medico_id = $request->input('medico');
        $arracaoEspMedico->especialidade_id = $request->input('especialidade');
        $arracaoEspMedico->status = $request->input('status');
        $arracaoEspMedico->data_cadastro = date('YmdHis');
        $arracaoEspMedico->data_atualizacao = date('YmdHis');
        $arracaoEspMedico->save();

        return redirect('cadastroEspecialidadesXMedicos');
     
    }

    public function update(Request $request, $id)
    {
        $arracaoEspMedico = ModelEspecialidadesXMedicos::find($id);
        $arracaoEspMedico->medico_id = $request->input('medico');
        $arracaoEspMedico->especialidade_id = $request->input('especialidade');
        $arracaoEspMedico->status = $request->input('status');
        $arracaoEspMedico->data_cadastro = date('YmdHis');
        $arracaoEspMedico->data_atualizacao = date('YmdHis');
        $arracaoEspMedico->save();

        return redirect('cadastroEspecialidadesXMedicos');
    }

    public function show($id)
    {
        $arracaoEspMedico = $this->objEspecialidadesXMedicos->find($id);

        return view('cadastroEspecialidades', compact('arracaoEspMedico'));
    }

    public function delete(Request $request, $id)
    {
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update especialidadexmedico set status=?, data_cadastro=? where id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroEspecialidadesXMedicos');
    }

    public function desativarAllEspecialidadesMedicos(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);


        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE especialidadexmedico SET status = "0" WHERE id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastroEspecialidadesXMedicos')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroEspecialidadesXMedicos')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }

    public function ativarAllEspecialidadesMedicos(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE especialidadexmedico SET status = "1" WHERE id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroEspecialidadesXMedicos')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroEspecialidades')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }
}
