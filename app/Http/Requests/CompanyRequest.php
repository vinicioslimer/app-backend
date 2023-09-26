<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'cnpj' => [
                'required',
                'string',
                'digits:14',
                Rule::unique('companies', 'cnpj')->ignore($this->route('company')),
                function ($attribute, $value, $fail) {
                    if (!$this->isValidCnpj($value)) {
                        $fail('O CNPJ não é válido.');
                    }
                },
            ],
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser uma string.',
            'name.max' => 'O campo nome não pode ter mais de 255 caracteres.',
            'cnpj.required' => 'O campo CNPJ é obrigatório.',
            'photo.image' => 'A foto deve ser uma imagem válida.',
            'photo.mimes' => 'A foto deve ser do tipo jpeg, png, jpg ou gif.',
            'photo.max' => 'A foto não pode ser maior que 2MB.',
        ];
    }

    //valida o CNPJ
    private function isValidCnpj($cnpj)
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifique se todos os dígitos são iguais (CNPJs inválidos)
        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $digit1 = 0;
        $digit2 = 0;

        for ($i = 0, $j = 5; $i < 12; $i++) {
            $digit1 += $cnpj[$i] * $j;
            $digit2 += $cnpj[$i] * ($j + 1);
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $remainder1 = $digit1 % 11;
        $remainder2 = $digit2 % 11;

        $digit1 = ($remainder1 < 2) ? 0 : 11 - $remainder1;
        $digit2 = ($remainder2 < 2) ? 0 : 11 - $remainder2;

        return ($cnpj[12] == $digit1 && $cnpj[13] == $digit2);
    }

}
