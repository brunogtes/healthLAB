<?php

namespace App\Http\Controllers;

use App\Http\Requests\CadastroConveniosRequest;
use Illuminate\Http\Request;
use App\Models\ModelConvenios;
use Illuminate\Support\Facades\DB;

class ConvenioController extends Controller
{
    private $objConvenio;

    public function __construct()

    {
        $this->objConvenio = new ModelConvenios();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //$convenio = $this->objConvenio->all();

        $convenio = $this->objConvenio->orderBy('nome_fantasia', 'asc')->paginate(5);

        return view('cadastroConvenios', compact('convenio'));
    }

    public function search(Request $request)
    {

        $search = $request->get('search');

        $convenio = ModelConvenios::where('nome_fantasia', 'LIKE', '%' . $search . '%')
            ->orWhere('cnpj', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        return view('cadastroConvenios', compact('convenio', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CadastroConveniosRequest $request)
    {

        $convenio = new ModelConvenios;
        $convenio->razao_social = $request->input('razao_social');
        $convenio->nome_fantasia = $request->input('nome_fantasia');
        $convenio->cnpj = $request->input('cnpj');
        $convenio->status = $request->input('situacao');
        $convenio->data_cadastro = date('YmdHis');
        $convenio->data_atualizacao = date('YmdHis');
        $convenio->save();
        return redirect('cadastroConvenios');
    }


    public function store(Request $request)
    {
    }

    public function show($convenio_id)
    {
        $convenio = $this->objConvenio->find($convenio_id);

        return view('cadastroConvenios', compact('convenio'));
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $convenio = ModelConvenios::find($id);
        $convenio->razao_social = $request->input('razao_social');
        $convenio->nome_fantasia = $request->input('nome_fantasia');
        $convenio->cnpj = $request->input('cnpj');
        $convenio->status = $request->input('situacao');
        $convenio->data_cadastro = date('YmdHis');
        $convenio->save();
        return redirect('cadastroConvenios');
    }

    public function delete(Request $request, $id)
    {

        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update convenios set status=?, data_cadastro=? where id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastroConvenios');
    }


    public function desativarAll(Request $request)
    {
        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE convenios SET status = "0" WHERE id IN (' . implode(",", $ids) . ')');

        //  return redirect('cadastroConvenios');

        if ($dbs) {
            $red = redirect('cadastroConvenios')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastroConvenios');
        }
        return $red;
    }

    public function ativarAll(Request $request)
    {
        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);
        
        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE convenios SET status = "1" WHERE id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastroConvenios')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastroConvenios');
        }
        return $red;
    }

    public function destroy($id)
    {
        //
    }
}
