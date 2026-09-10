<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePerguntaRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return true;
    }

  
    public function rules(): array
    {
        return [
            'texto'     => ['required', 'string', 'min:10', 'max:255'],
            'evento_id' => ['required', 'exists:eventos,id'],
        ];
    }

  
    public function messages(): array
    {
        return [
            'texto.required'     => 'O campo texto é obrigatório.',
            'texto.min'          => 'A pergunta precisa ter pelo menos 10 caracteres.',
            'texto.max'          => 'A pergunta pode ter no máximo 255 caracteres.',
            'evento_id.required' => 'O evento é obrigatório.',
            'evento_id.exists'   => 'O evento informado não existe.',
        ];
    }

  
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Dados inválidos.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
