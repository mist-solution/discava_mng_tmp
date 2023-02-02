<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Lang;

class EndUserRegistRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|max:16',
            'email' => 'required|email',
            'password'  => array_merge(
                [
                    'required',
                    'between:12,72',
                    'confirmed:password_confirmation',
                ],
                array_map(
                    function ($requirement) {
                        return function ($attribute, $value, $fail) use ($requirement) {
                            if (!(bool) preg_match('/' . $requirement . '/', $value)) {
                                $fail(Lang::get('passwords.password_requirements.' . $requirement));
                            }
                        };
                    },
                    config('password.requirements', [
                        '[0-9]',
                        '[a-z,A-Z]',
                        '[-_%$#]',
                    ])
                )
            ),
            'password_confirmation' => 'required',
        ];

        foreach ($this->input('shopList') as $index => $detail) {
            if ($detail['model'] == 'none') {
                $rules["shopList.$index.model"] = 'required|not_in:none';
            }
        }
        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード確認',
        ];

        foreach ($this->input('shopList') as $index => $detail) {
            if ($detail['model'] == 'none') {
                $attributes["shopList.$index.model"] = $detail["shop_name"];
            }
        }

        return $attributes;
    }
}
