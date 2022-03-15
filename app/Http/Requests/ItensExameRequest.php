<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItensExameRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'exame' => 'required',
            'descricao' => 'required',
            'descricaoReduzida' => 'required',
            'valorReferencia' => 'required',
            'valorMinimo' => 'required',
            'valorMaximo' => 'required',
            'status' => 'required',
        ];
    }


    public function messages()
    {
        // mensagens de erro personalizadas!
        return [

            //Exame
            'exame.required' => 'O campo Exame é obrigatório',

            //Descrição
            'descricao.required' => 'O campo Descrição é obrigatório',

            //Descrição Reduzida
            'descricaoReduzida.required' => 'O campo Descrição Reduzida é obrigatório',

            //Valor de Referencia
            'valorReferencia.required' => 'O campo Valor de Referência é obrigatório',

            //Valor Mínimo
            'valorMinimo.required' => 'O campo Valor Mínimo é obrigatório',

            //Valor Máximo
            'valorMaximo.required' => 'O campo Valor Máximo é obrigatório',

            //Situação
            'status.required' => 'O campo Situação é obrigatório',


        ];
    }
}
