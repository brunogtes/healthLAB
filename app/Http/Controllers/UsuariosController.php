<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarUsuarioRequest;
use App\Models\ModelConvenios;
use App\Models\ModelFuncionarios;
use App\Models\ModelMedicos;
use App\Models\ModelPlano;
use App\Models\ModelUsuarios;
use App\Models\UserCustomModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class UsuariosController extends Controller
{
    private $objUsuarios;
    private $objConvenios;
    private $objPlanos;

    public function __construct()

    {
        $this->objUsuarios = new UserCustomModel();
        $this->objConvenios = new ModelConvenios();
        $this->objPlanos = new ModelPlano();
    }

    public function index(Request $request)
    {
        //$listaUsuarios = $this->objUsuarios->paginate(5);
        $listaUsuarios = UserCustomModel::orderBy('nome', 'asc')->paginate(5);
        $listaConvenios = $this->objConvenios->all();
        $listaPlanos = $this->objPlanos->all();
        $usuariosAtivos = $this->objUsuarios::where('status', 1)->count();
        $usuariosInativos = $this->objUsuarios::where('status', 0)->count();
        $totalUsuarios = $this->objUsuarios->count();

        return view('cadastrarUsuarios', compact('listaUsuarios', 'listaConvenios', 'listaPlanos', 'usuariosAtivos', 'usuariosInativos', 'totalUsuarios'));
    }



    public function pegarCidades($convenio_id)

    {
        // $data = ModelPlano::where('convenio_id', $convenio_id)->get();
        //return response()->json($data, 200);
        //return  json_encode($data, true);'' 


        return ModelPlano::where('convenio_id', 'LIKE', '%' . $convenio_id . '%')->get();
    }
    public function search(Request $request)
    {
        $search = $request->get('search');

        $listaUsuarios  = ModelUsuarios::where('nome', 'LIKE', '%' . $search . '%')
            ->orWhere('sobrenome', 'LIKE', '%' . $search . '%')
            ->orWhere('cpf', 'LIKE', '%' . $search . '%')
            ->orWhere('status', 'LIKE', '%' . $search . '%')
            ->paginate(5);

        $listaConvenios = $this->objConvenios->all();
        $listaPlanos = $this->objPlanos->all();
        $usuariosAtivos = $this->objUsuarios::where('status', 1)->count();
        $usuariosInativos = $this->objUsuarios::where('status', 0)->count();
        $totalUsuarios = $this->objUsuarios->count();

        return view('cadastrarUsuarios', compact('listaUsuarios', 'usuariosAtivos', 'usuariosInativos', 'totalUsuarios', 'listaConvenios', 'listaPlanos', 'search'));
    }

    public function create()
    {
        return view('cadastrarUsuarios');
    }

    public function createPDF()
    {

        $user = ModelUsuarios::all();

        $pdf = PDF::loadView('pdf', compact('user'));

        return $pdf->setPaper('a4')->stream('usuarios.pdf');
    }

    public function createExcel(Request $request)
    {
        $fileName = 'usuarios.csv';
        $users = UserCustomModel::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Nome', 'E-mail');

        $callback = function () use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $usuarios) {
                $row['Nome']  = $usuarios->nome;
                $row['E-mail']    = $usuarios->email;

                fputcsv($file, array($row['Nome'], $row['E-mail']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function store(CriarUsuarioRequest $request)
    {

        $data = $request->all();
        $usuario = new UserCustomModel();
        $usuario->cpf = $request->get('cpf');
        $usuario->email = $request->get('email');
        $usuario->nome = $request->get('nome');
        $usuario->sobrenome = $request->get('sobrenome');
        $usuario->data_nascimento = $request->get('data_nascimento');
        $usuario->telefone1 = $request->get('telefone1');
        $usuario->telefone2 = $request->get('telefone2');
        $usuario->CEP = $request->get('cep');
        $usuario->endereco = $request->get('endereco');
        $usuario->numero = $request->get('numero');
        $usuario->bairro = $request->get('bairro');
        $usuario->cidade = $request->get('cidade');
        $usuario->UF = $request->get('uf');
        //$usuario->senha = $request->get('senha');
        $usuario->password = app('hash')->make($data['senha']);
        $usuario->perfil = $request->get('perfil');
        $usuario->convenio_id = $request->get('convenio');
        $usuario->plano_id = $request->get('plano');
        $usuario->status = $request->get('status');
        $usuario->data_cadastro = date('YmdHis');
        $usuario->data_atualizacao = date('YmdHis');
        $usuario->save();

        $usuario_id = $usuario->id;
        $verificarCadastro = $request->get('perfil');

        if ($verificarCadastro == "P") { //Paciente
            $usuario->givePermissionTo('paciente');
        }

        if ($verificarCadastro == "M") { //Medico

            $medico = new ModelMedicos();
            $medico->CRM = $request->get('crm');
            $medico->usuario_id = $usuario_id;
            $medico->status = $request->get('status');
            $medico->data_cadastro = date('YmdHis');
            $medico->data_atualizacao = date('YmdHis');
            $usuario->givePermissionTo('medico');
            $medico->save();
        }

        if ($verificarCadastro == "F") { //Funcionario

            $funcionario = new ModelFuncionarios();
            $funcionario->funcao = $request->get('funcao');
            $funcionario->usuario_id = $usuario_id;
            $funcionario->status = $request->get('status');
            $funcionario->data_cadastro = date('YmdHis');
            $funcionario->data_atualizacao = date('YmdHis');
            $usuario->givePermissionTo('funcionario');
            $funcionario->save();
        }

        if ($verificarCadastro == "A") { //Administrador
            $usuario->givePermissionTo('admin');
        }


        return redirect('cadastrarUsuarios');
    }



    public function update(CriarUsuarioRequest $request, $id)
    {
        $data = $request->all();
        $usuario =  ModelUsuarios::find($id);
        $usuario->cpf = $request->get('cpf');
        $usuario->email = $request->get('email');
        $usuario->nome = $request->get('nome');
        $usuario->sobrenome = $request->get('sobrenome');
        $usuario->data_nascimento = $request->get('data_nascimento');
        $usuario->telefone1 = $request->get('telefone1');
        $usuario->telefone2 = $request->get('telefone2');
        $usuario->CEP = $request->get('cep');
        $usuario->endereco = $request->get('endereco');
        $usuario->numero = $request->get('numero');
        $usuario->bairro = $request->get('bairro');
        $usuario->cidade = $request->get('cidade');
        $usuario->UF = $request->get('uf');
        //$usuario->senha = $request->get('senha');
        $usuario->senha = app('hash')->make($data['senha']);
        $usuario->perfil = $request->get('perfil');
        $usuario->convenio_id = $request->get('convenio');
        $usuario->plano_id = $request->get('plano');
        $usuario->status = $request->get('status');
        $usuario->data_cadastro = date('YmdHis');
        $usuario->data_atualizacao = date('YmdHis');
        $usuario->save();
        $usuario_id = $usuario->id;

        $verificarCadastro = $request->get('perfil');

        if ($verificarCadastro == "M") {

            $medico = new ModelMedicos();
            $medico->CRM = $request->get('crm');
            $medico->usuario_id = $usuario_id;
            $medico->status = $request->get('status');
            $medico->data_cadastro = date('YmdHis');
            $medico->data_atualizacao = date('YmdHis');
            $medico->save();
        }

        if ($verificarCadastro == "F") {

            $funcionario = new ModelFuncionarios();
            $funcionario->funcao = $request->get('funcao');
            $funcionario->usuario_id = $usuario_id;
            $funcionario->status = $request->get('status');
            $funcionario->data_cadastro = date('YmdHis');
            $funcionario->data_atualizacao = date('YmdHis');
            $funcionario->save();
        }


        return redirect('cadastrarUsuarios');
    }

    public function show(ModelUsuarios $usuarios)
    {

        return view('cadastrarUsuarios', compact('usuarios'));
    }

    public function delete(Request $request, $id)
    {
        $situacao = "0";
        $data_cadastro = date('YmdHis');

        $dbs = DB::update('update usuarios set status=?, data_cadastro=? where usuario_id=?', [$situacao, $data_cadastro, $id]);

        return redirect('cadastrarUsuarios');
    }

    public function desativarAllUsuarios(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);

        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE usuarios SET status = "0" WHERE usuario_id IN (' . implode(",", $ids) . ')');


        if ($dbs) {
            $red = redirect('cadastrarUsuarios')->with('msg', 'Desativado com Sucesso!');
        } else {
            $red = redirect('cadastrarUsuarios')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }

    public function ativarAllUsuarios(Request $request)
    {

        $mensagens = [
            //IDS
            'ids.required' => 'É necessário selecionar um ou mais itens',           
        ];

        $request->validate([
            'ids' => 'required',

        ], $mensagens);
        
        $ids = $request->get('ids');

        $dbs = DB::update('UPDATE usuarios SET status = "1" WHERE usuario_id IN (' . implode(",", $ids) . ')');

        if ($dbs) {
            $red = redirect('cadastrarUsuarios')->with('msg', 'Ativado com Sucesso!');
        } else {
            $red = redirect('cadastrarUsuarios')->withErrors(['msg', 'Erro']);
        }
        return $red;
    }
}
