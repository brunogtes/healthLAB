<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExameXPlanoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'convenio' => 'required',
            'plano' => 'required',
            'exame' => 'required',        
            'status' => 'required',
        ];
    }

    public function messages()
    {
        // mensagens de erro personalizadas!
        return [

            //Convênio
            'convenio.required' => 'O campo Convênio é obrigatório',

            //Plano
            'plano.required' => 'O campo Plano é obrigatório',

            //Exame
            'exame.required' => 'O campo Exame é obrigatório',           

            //Situação
            'status.required' => 'O campo Situação é obrigatório',


        ];
    }
}
