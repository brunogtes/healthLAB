<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastroExamesRequestes extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descricao' => 'required',
            'class_sexo' => 'required',
            'status' => 'required',
        ];
    }


    public function messages()
    {
        // mensagens de erro personalizadas!
        return [


            //Descrição
            'descricao.required' => 'O campo Descrição é obrigatório',

            //Clssificação por Sexo
            'class_sexo.required' => 'O campo Classificação por Sexo é obrigatório',


            //Situação
            'status.required' => 'O campo Situação é obrigatório',


        ];
    }
}
