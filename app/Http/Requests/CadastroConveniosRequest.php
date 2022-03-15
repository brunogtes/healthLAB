<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastroConveniosRequest extends FormRequest
{

    public function rules()
    {
        return [
            'razao_social' => 'required',
            'nome_fantasia' => 'required', 
            'cnpj' => 'required',       
            'situacao' => 'required',            
        ];
    }


    public function messages()
    {
        // mensagens de erro personalizadas!
        return [

            //Razão Social
            'razao_social.required' => 'O campo Razão Social é obrigatório',

             //Nome Fantasia
             'nome_fantasia.required' => 'O campo Nome Fantasia é obrigatório',

             //CNPJ
             'cnpj.required' => 'O campo CNPJ é obrigatório',

             //Situação
             'situacao.required' => 'O campo Situação é obrigatório',    


        ];
    }
}
