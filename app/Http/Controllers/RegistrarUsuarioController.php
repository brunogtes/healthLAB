<?php

namespace App\Http\Controllers;

use App\Models\ModelConvenios;
use App\Models\ModelPlano;
use App\Models\UserCustomModel;
use Illuminate\Http\Request;

class RegistrarUsuarioController extends Controller
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
        $listaConvenios = $this->objConvenios->where("status", "1")->get();
        $listaPlanos = $this->objPlanos->all();

        return view('createUser', compact('listaConvenios', 'listaPlanos'));
    }

    public function store(Request $request)
    {

        $mensagens = [
            //CPF
            'cpf.required' => 'CPF é obrigatório',
            'cpf.unique' => 'CPF já cadastrado',

            //E-Mail
            'email.required' => 'E-mail é obrigatório',
            'email.email' => 'E-mail tem que ser um email',
            'email.unique' => 'E-mail já cadastrado',

            //Nome
            'nome.required' => 'Nome é obrigatório',
            // 'nome.min' => 'O campo tem que ter mais do que 6 caracteres ',

            //Sobrenome
            'sobrenome.required' => 'Sobrenome é obrigatório',

            //Data de Nascimento
            'data_nascimento.required' => ' Data Nascimento é obrigatório',

            //Telefone 1
            'telefone1.required' => 'Telefone 1 é obrigatório',

            //Endereço
            'endereco.required' => 'Endereço é obrigatório',

            //Bairro
            'bairro.required' => 'Bairro é obrigatório',

            //Número
            'numero.required' => 'Número é obrigatório',

            //Cidade
            'cidade.required' => 'Cidade é obrigatório',

            //Estado
            'uf.required' => 'Estado é obrigatório',

            //CEP
            'cep.required' => 'CEP é obrigatório',

            //Senha
            'senha.required' => 'Senha é obrigatório',
            'senha.min' => 'A senha tem que no mínimo 8 caracteres ',

            //Confirmar Senha
            'confirmarSenha.required' => 'Confirmar Senha é obrigatório',
            'confirmarSenha.same' => 'Senha e Confirmar Senha devem ser iguais',

            //Convênio
            'convenio.required' => 'Convênio é obrigatório',

            //Plano
            'plano.required' => 'Plano é obrigatório',


        ];

        $request->validate([
            'cpf' => 'required|unique:usuarios',
            'email' => 'required|unique:usuarios',
            'nome' => 'required',
            'sobrenome' => 'required',
            'data_nascimento' => 'required',
            'telefone1' => 'required',
            'cep' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'numero' => 'required|numeric',
            'cidade' => 'required',
            'uf' => 'required',            
            'senha' => 'required|min:8',
            'confirmarSenha' => 'required|same:senha',
            'convenio' => 'required',
            'plano' => 'required',
        ], $mensagens);



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
        $usuario->perfil = "P";
        $usuario->convenio_id = $request->get('convenio');
        $usuario->plano_id = $request->get('plano');
        $usuario->status = "1";
        $usuario->data_cadastro = date('YmdHis');
        $usuario->data_atualizacao = date('YmdHis');
        $usuario->givePermissionTo('paciente');
        $usuario->save();

        return redirect('login')->with('msg', 'Usuário cadastrado com sucesso!');;
    }

    public function pegarPlanos($convenio_id)
    {
        return ModelPlano::where('convenio_id', 'LIKE', '%' . $convenio_id . '%')->get();
    }
}
