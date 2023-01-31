<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class AnnounceRequest extends FormRequest
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
        return [
            'title' => 'required|max:255',
            'contents' => 'required',
            'announce_category_id' => 'required',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'contents' => '本文',
            'announce_category_id' => 'カテゴリー',
            'start_date' => '掲載開始日',
            'end_date' => '掲載終了日',
        ];
    }
}
