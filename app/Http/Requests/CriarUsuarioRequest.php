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
            'cpf.required' => 'O campo CPF é obrigatório',
            'cpf.unique' => 'CPF já cadastrado',

            //E-Mail
            'email.required' => 'O campo E-mail é obrigatório',
            'email.email' => 'O campo E-mail tem que ser um email',
            'email.unique' => 'E-mail já cadastrado',

            //Nome
            'nome.required' => 'O campo Nome é obrigatório',
            // 'nome.min' => 'O campo tem que ter mais do que 6 caracteres ',

            //Sobrenome
            'sobrenome.required' => 'O campo Sobrenome é obrigatório',

            //Data de Nascimento
            'data_nascimento.required' => 'O campo Data Nascimento é obrigatório',

            //Telefone 1
            'telefone1.required' => 'O campo Telefone 1 é obrigatório',

            //Endereço
            'endereco.required' => 'O campo Endereço é obrigatório',

            //Bairro
            'bairro.required' => 'O campo Bairro é obrigatório',

            //Número
            'numero.required' => 'O campo Número é obrigatório',

            //Cidade
            'cidade.required' => 'O campo Cidade é obrigatório',

            //Estado
            'uf.required' => 'O campo Estado é obrigatório',

            //CEP
            'cep.required' => 'O campo CEP é obrigatório',

            //Senha
            'senha.required' => 'O campo Senha é obrigatório',
            'senha.min' => 'A senha tem que no mínimo 8 caracteres ',

            //Confirmar Senha
            'confirmarSenha.required' => 'O campo Confirmar Senha é obrigatório',
            'confirmarSenha.same' => 'O campo Senha e Confirmar Senha devem ser iguais',

            //Status
            'status.required' => 'O campo Status é obrigatório',

            //Perfil
            'perfil.required' => 'O campo Perfil é obrigatório',

            //Função
            'funcao.required' => 'O campo Função é obrigatório',

            //CRM
            'crm.required' => 'O campo CRM é obrigatório',

            //Convênio
            'convenio.required' => 'O campo Convênio é obrigatório',

            //Plano
            'plano.required' => 'O campo Plano é obrigatório',




        ];
    }
}
