<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    // このフォームリクエストを利用が許可されているかを示すアクション。(trueで許可)
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    // バリデーション
    public function rules()
    {
        return [
            // タイトルは必須で20文字以内
            'title' => 'required',
            // bodyは必須
            'author' => 'required',
            'publication' => 'required',
            'price' => 'required',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10240',
        ];
    }

    // バリデーションメッセージ。（新規投稿で表示される）
    public function messages()
    {
        return [
            'title.required' => 'タイトルは必須です。',
            'author.required'  => '著者は必須です。',
            'publication.required'  => '著者は必須です。',
            'price.required'  => '金額は必須です。',
            'image.mimes'  => '画像があればjpeg,jpg,png,gifを選択してください',
        ];
    }
}
