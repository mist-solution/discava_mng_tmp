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
            'email' => 'required|email|unique:users,email,' . $userId,
        ];

        $shopList = $this->input('shopList');
        if ($shopList[0]['model'] == 'none' && $shopList[1]['model'] == 'none') {
            $rules["shopList.0.model"] = 'required|not_in:none';
            $rules["shopList.1.model"] = 'required|not_in:none';
        }

        return $rules;
    }

    public function attributes()
    {
        $attributes = [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
        ];

        foreach ($this->input('shopList') as $index => $detail) {
            if ($detail['model'] == 'none') {
                $attributes["shopList.$index.model"] = $detail["shop_name"];
            }
        }

        return $attributes;
    }

    public function messages()
    {
        $attributeArray = [];
        foreach ($this->input('shopList') as $index => $detail) {
            if ($detail['model'] == 'none') {
                if (!in_array($detail["shop_name"], $attributeArray)) {
                    array_push($attributeArray, $detail["shop_name"]);
                }
            }
        }
        $attribute = implode('または', $attributeArray);

        return [
            'shopList.0.model.not_in' => $attribute . 'いずれかの権限は「該当なし」以外を選択してください。',
            'shopList.1.model.not_in' => '',
        ];
    }
}
