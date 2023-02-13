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
            'email' => 'required|email:rfc,filter|unique:users,email',
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

        $shopList = $this->input('shopList');
        $allModel = 0;

        if (count($shopList) >= 2) {
            foreach ($shopList as $index => $detail) {
                if ($detail['model'] == 'none') {
                    $allModel += 1;
                }
            }
            if (count($shopList) == $allModel) {
                foreach ($shopList as $index => $detail) {
                    if ($detail['model'] == 'none') {
                        $rules["shopList.$index.model"] = 'required|not_in:none';
                    }
                }
            } else if (count($shopList) < $allModel) {
                foreach ($shopList as $index => $detail) {
                    $rules["shopList.$index.model"] = 'required';
                }
            }
        } else if (count($shopList) == 1) {
            if ($shopList[0]['model'] == 'none') {
                $rules["shopList.0.model"] = 'required|not_in:none';
            }
        } else {
            return;
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

        $shopList = $this->input('shopList');
        foreach ($shopList as $index => $detail) {
            if ($detail['model'] == 'none') {
                $attributes["shopList.$index.model"] = $detail["shop_name"];
            }
        }

        return $attributes;
    }

    public function messages()
    {

        $message =
            [
                'password.between'        => '',
            ];

        $attributeArray = [];
        $attribute = null;
        $shopList = $this->input('shopList');

        if (count($shopList) >= 2) {
            foreach ($shopList as $index => $detail) {
                if ($detail['model'] == 'none') {
                    if (!in_array($detail["shop_name"], $attributeArray)) {
                        array_push($attributeArray, $detail["shop_name"]);
                    }
                }

                // get shop_name
                $attribute = implode('、', $attributeArray);
            }
            for ($i = 1; $i < count($shopList); $i++) {
                $message =
                    [
                        'shopList.0.model.not_in' => $attribute . 'いずれかの権限は「該当なし」以外を選択してください。',
                        'shopList.*.model.not_in' =>  '',
                    ];
            };
            return $message;
        } else if (count($shopList) == 1) {
            $attribute = $shopList[0]["shop_name"];
            return [
                'shopList.0.model.not_in' => $attribute . 'の権限は「該当なし」以外を選択してください。',
            ];
        } else {
            return $message;
        }
    }
}
