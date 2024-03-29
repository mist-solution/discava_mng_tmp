<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Lang;
use App\Models\User;

class EndUserUpdateRequest extends FormRequest
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
        $userId = $this->input('id');
        $rules = [
            'name' => 'required|max:16',
            'email' => 'required|email:rfc,filter|unique:users,email,' . $userId,
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
        $message = [];

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
