<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CadastroPlanosRequest extends FormRequest
{
    public function rules()
    {
        switch ($this->method()) {
            case 'PUT':
                return [
                    'convenio' => 'required',
                    'descricao' => 'required',
                    'situacao' => 'required',
                ];



            case 'POST':

                return [
                    'convenio' => 'required',
                    'descricao' => 'required',
                    'situacao' => 'required',
                ];
        }
    }


    public function messages()
    {
        // mensagens de erro personalizadas!
        return [

            //Convênio
            'convenio.required' => 'O campo Convênio é obrigatório',

            //Descrição
            'descricao.required' => 'O campo Descrição é obrigatório',

            //Situação
            'situacao.required' => 'O campo Situação é obrigatório',


        ];
    }
}
