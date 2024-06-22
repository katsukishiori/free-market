<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'price' => ['required', 'string'],
            'description' => ['required', 'min:20'],
            'img_url' => ['required'],
            'category' => ['required'],
            'condition' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.string' => '値段を文字列で入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.min' => '商品の説明を20文字以上で入力してください',
            'img_url.required' => '画像を選択してください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
        ];
    }
}
