<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExameXPlanoRequest;
use App\Models\ModelConvenios;
use App\Models\ModelExames;
use App\Models\ModelExamesXPlanos;
use App\Models\ModelPlano;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamesXPlanosController extends Controller
{
    private $objExameXPlanos;
    private $objConvenios;
    private $objPlanos;
    private $objExames;

    public function __construct()

    {
        $this->objExameXPlanos = new ModelExamesXPlanos();
        $this->objConvenios = new ModelConvenios();
        $this->objPlanos = new ModelPlano();
        $this->objExames = new ModelExames();
    }

    public function index()
    {
        $arracaoExamePlano = $this->objExameXPlanos->paginate(5);
        $listaConvenios = $this->objConvenios->all();
        $listaPlanos = $this->objPlanos->all();
        $listaExames = $this->objExames->all();

        return view('cadastroExamesXPlanos', compact('arracaoExamePlano', 'listaConvenios', 'listaPlanos', 'listaExames'));
    }

    public function search(Request $request)
    {
        $search = $request->get('search');

        $arracaoExamePlano = ModelExamesXPlanos::where('convenio_id', 'LIKE', '%' . $search . '%')
            ->orWhere('exame_id', 'LIKE', '%' . $search . '%')
            ->orWhere('plano_id', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaConvenios = ModelConvenios::where('id', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaPlanos = ModelPlano::where('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaExames = ModelExames::where('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroExamesXPlanos', compact('arracaoExamePlano', 'listaConvenios', 'listaPlanos', 'listaExames', 'search'));
    }

    public function create(ExameXPlanoRequest $request)
    {
        $arracaoExamePlano = new ModelExamesXPlanos();
        $arracaoExamePlano->convenio_id = $request->input('convenio');
        $arracaoExamePlano->plano_id = $request->input('plano');
        $arracaoExamePlano->exame_id = $request->input('exame');              
        $arracaoExamePlano->status = $request->input('status');
        $arracaoExamePlano->data_cadastro = date('YmdHis');
        $arracaoExamePlano->data_atualizacao = date('YmdHis');
        $arracaoExamePlano->save();

        return redirect('cadastroExamesXPlanos');
    }

    public function update(Request $request, $id)
    {
        $arracaoExamePlano = ModelExamesXPlanos::find($id);
        $arracaoExamePlano->convenio_id = $request->input('convenio');
        $arracaoExamePlano->plano_id = $request->input('plano');
        $arracaoExamePlano->exame_id = $request->input('exame');              
        $arracaoExamePlano->status = $request->input('status');        
        $arracaoExamePlano->data_atualizacao = date('YmdHis');
        $arracaoExamePlano->save();

        return redirect('cadastroExamesXPlanos');
    }

    public function show($id)
    {
        $ExamePlano = $this->objExameXPlanos->find($id);

        return view('cadastroExamesXPlanos', compact('ExamePlano'));
    }

    public function delete(Request $request, $id)
    {
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update examexplano set status=?, data_cadastro=? where id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroExamesXPlanos');
    }

    public function desativarAllExameXPlano(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);


        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE examexplano SET status = "0" WHERE id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastroExamesXPlanos')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroExamesXPlanos');
        }
        return $red;
    }

    public function ativarAllExameXPlano(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE examexplano SET status = "1" WHERE id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroExamesXPlanos')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroExamesXPlanos');
        }
        return $red;
    }
}
