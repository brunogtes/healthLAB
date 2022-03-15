<?php

namespace App\Http\Controllers;

use App\Http\Requests\CriarUsuarioRequest;
use Illuminate\Http\Request;
use App\Models\ModelConvenios;
use App\Models\ModelPlano;
use App\Models\ModelUsuarios;
use App\Models\UserCustomModel;
use Hash;

class PerfilController extends Controller
{

    private $objUsuarios;
    private $objConvenios;
    private $objPlanos;


    public function __construct()
    {
        $this->middleware('auth');

        $this->objUsuarios = new ModelUsuarios();
        $this->objConvenios = new ModelConvenios();
        $this->objPlanos = new ModelPlano();
    }


    public function index()
    {
        $listaUsuarios = $this->objUsuarios->all();
        $listaConvenios = $this->objConvenios->all();
        $listaPlanos = $this->objPlanos->all();

        return view('perfil', compact('listaConvenios', 'listaPlanos', 'listaUsuarios'));
    }

    public function update(Request $request, $id)
    {

        $mensagens = [
            //E-Mail
            'email.required' => 'O campo E-mail é obrigatório',
            'email.email' => 'O campo E-mail tem que ser um email',

            //Nome
            'nome.required' => 'O campo Nome é obrigatório',

            //Sobrenome
            'sobrenome.required' => 'O campo Sobrenome é obrigatório',

            //Data de Nascimento
            'data_nascimento.required' => 'O campo Data Nascimento é obrigatório',

            //Telefone 1
            'telefone1.required' => 'O campo Telefone 1 é obrigatório',

            //CEP
            'cep.required' => 'O campo CEP é obrigatório',

            //Convênio
            'convenio.required' => 'O campo Convênio é obrigatório',

            //Plano
            'plano.required' => 'O campo Plano é obrigatório',



        ];

        $request->validate([
            'email' => 'required',
            'nome' => 'required',
            'sobrenome' => 'required',
            'data_nascimento' => 'required',
            'telefone1' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'numero' => 'required|numeric',
            'cidade' => 'required',
            'uf' => 'required',
            'cep' => 'required',
            'convenio' => 'required',
            'plano' => 'required',
        ], $mensagens);

        $usuario =  UserCustomModel::find($id);
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
        $usuario->convenio_id = $request->get('convenio');
        $usuario->plano_id = $request->get('plano');
        $usuario->data_atualizacao = date('YmdHis');
        $usuario->save();

        return redirect('perfil');
    }

    public function upload_imagem(Request $request, $id)
    {

        $usuario =  UserCustomModel::find($id);
        $usuario->data_atualizacao = date('YmdHis');


        // Define o valor default para a variável que contém o nome da imagem 
        $nameFile = null;

        // Verifica se informou o arquivo e se é válido
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));

            // Recupera a extensão do arquivo
            $extension = $request->image->extension();

            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";

            $usuario->image = $nameFile;

            // Faz o upload:
            $upload = $request->image->storeAs('public', $nameFile);

            $usuario->save();


            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
        }

        return redirect('perfil');
    }

    public function alterarSenha(Request $request, $id)
    {

        $mensagens = [
            'senha.required' => 'O campo Senha é obrigatório',
            'senha.min' => 'A senha tem que no mínimo 8 caracteres ',
            'confirmarSenha.required' => 'O campo Confirmar Senha é obrigatório',
            'confirmarSenha.same' => 'O campo Senha e Confirmar Senha devem ser iguais',
        ];

        $request->validate([
            'senha' => 'required|min:8',
            'confirmarSenha' => 'required|same:senha'
        ], $mensagens);




        $data = $request->all();
        $usuario =  UserCustomModel::find($id);
        $usuario->password =  bcrypt($data['senha']);
        $usuario->data_atualizacao = date('YmdHis');
        $usuario->save();

        return redirect('perfil');
    }
}
