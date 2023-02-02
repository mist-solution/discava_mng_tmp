<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class AnnounceTempRequest extends FormRequest
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
            'title' => 'required|max:255',
            'contents' => 'required',
        ];
        if ($this->filled('announce_category_id')) {
            $rules['announce_category_id'] = 'required';
        }
        if ($this->filled('start_date')) {
            $rules['start_date'] = 'required';
        }
        if ($this->filled('end_date')) {
            $rules['end_date'] = 'date||after:start_date';
        }
        return $rules;
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
