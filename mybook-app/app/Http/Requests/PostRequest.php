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
            // 購入年月日は必須
            'date' => 'required',
            // タイトルは必須
            'title' => 'required',
            // 著者は必須
            'author' => 'required',
            // 出版社は必須
            'publication' => 'required',
            // 金額は必須
            'price' => 'required',
            // ジャンルは必須
            'category_id' => 'required',
            // 画像は必須かつjpeg,jpg,png,gif,サイズがmax超えればエラーを出す
            'image' => 'file|required|mimes:jpeg,jpg,png,gif|max:10240',
        ];
    }

    // バリデーションメッセージ。（新規投稿・更新画面で表示される）
    public function messages()
    {
        return [
            'date.required' => '購入年月日は必須です。',
            'title.required' => 'タイトルは必須です。',
            'author.required'  => '著者は必須です。',
            'publication.required'  => '著者は必須です。',
            'price.required'  => '金額は必須です。',
            'category_id.required' => 'ジャンルは必須です。',
            'image.required' => '画像は必須です。',
            'image.mimes'  => '画像はjpeg,jpg,png,gifを選択してください。',
        ];
    }
}
