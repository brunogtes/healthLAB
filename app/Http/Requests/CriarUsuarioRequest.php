<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarUsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->get('perfil') === null) {
            return [
                'cpf' => 'required|unique:usuarios',
                'email' => 'required|unique:usuarios',
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
                'senha' => 'required|min:8',
                'confirmarSenha' => 'required|same:senha',
                'status' => 'required',
                'perfil' => 'required',
            ];
        } else if ($this->get('perfil') === 'P') {
            return [
                'cpf' => 'required|unique:usuarios',
                'email' => 'required|unique:usuarios',
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
                'senha' => 'required|min:8',
                'confirmarSenha' => 'required|same:senha',
                'status' => 'required',
                'convenio' => 'required',
                'plano' => 'required',
            ];
        } else if ($this->get('perfil') === 'M') {
            return [
                'cpf' => 'required|unique:usuarios',
                'email' => 'required|unique:usuarios',
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
                'senha' => 'required|min:8',
                'confirmarSenha' => 'required|same:senha',
                'status' => 'required',
                'perfil' => 'required',
                'crm' => 'required',
            ];
        } else if ($this->get('perfil') === 'F') {

            return [
                'cpf' => 'required|unique:usuarios',
                'email' => 'required|unique:usuarios',
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
                'senha' => 'required|min:8',
                'confirmarSenha' => 'required|same:senha',
                'status' => 'required',
                'perfil' => 'required',
                'funcao' => 'required',
            ];
        } else if ($this->get('perfil') === 'A') {

            return [
                'cpf' => 'required|unique:usuarios',
                'email' => 'required|unique:usuarios',
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
                'senha' => 'required|min:8',
                'confirmarSenha' => 'required|same:senha',
                'status' => 'required',
                'perfil' => 'required',
            ];
        }
    }


    public function messages()
    {
        // mensagens de erro personalizadas!
        return [

            //CPF
            'cpf.required' => 'O campo CPF ?? obrigat??rio',
            'cpf.unique' => 'CPF j?? cadastrado',

            //E-Mail
            'email.required' => 'O campo E-mail ?? obrigat??rio',
            'email.email' => 'O campo E-mail tem que ser um email',
            'email.unique' => 'E-mail j?? cadastrado',

            //Nome
            'nome.required' => 'O campo Nome ?? obrigat??rio',
            // 'nome.min' => 'O campo tem que ter mais do que 6 caracteres ',

            //Sobrenome
            'sobrenome.required' => 'O campo Sobrenome ?? obrigat??rio',

            //Data de Nascimento
            'data_nascimento.required' => 'O campo Data Nascimento ?? obrigat??rio',

            //Telefone 1
            'telefone1.required' => 'O campo Telefone 1 ?? obrigat??rio',

            //Endere??o
            'endereco.required' => 'O campo Endere??o ?? obrigat??rio',

            //Bairro
            'bairro.required' => 'O campo Bairro ?? obrigat??rio',

            //N??mero
            'numero.required' => 'O campo N??mero ?? obrigat??rio',

            //Cidade
            'cidade.required' => 'O campo Cidade ?? obrigat??rio',

            //Estado
            'uf.required' => 'O campo Estado ?? obrigat??rio',

            //CEP
            'cep.required' => 'O campo CEP ?? obrigat??rio',

            //Senha
            'senha.required' => 'O campo Senha ?? obrigat??rio',
            'senha.min' => 'A senha tem que no m??nimo 8 caracteres ',

            //Confirmar Senha
            'confirmarSenha.required' => 'O campo Confirmar Senha ?? obrigat??rio',
            'confirmarSenha.same' => 'O campo Senha e Confirmar Senha devem ser iguais',

            //Status
            'status.required' => 'O campo Status ?? obrigat??rio',

            //Perfil
            'perfil.required' => 'O campo Perfil ?? obrigat??rio',

            //Fun????o
            'funcao.required' => 'O campo Fun????o ?? obrigat??rio',

            //CRM
            'crm.required' => 'O campo CRM ?? obrigat??rio',

            //Conv??nio
            'convenio.required' => 'O campo Conv??nio ?? obrigat??rio',

            //Plano
            'plano.required' => 'O campo Plano ?? obrigat??rio',




        ];
    }
}
