<?php

namespace App\Http\Requests\OrderImport;

use Illuminate\Foundation\Http\FormRequest;

class OrderImportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_data' => 'required',
            'order_import_setting_id' => 'required|exists:order_import_settings,order_import_setting_id',
        ];
    }

    public function messages()
    {
        return [
            'required' => ":attributeは必須です。",
            'exists' => ":attributeが存在しません。",
        ];
    }

    public function attributes()
    {
        return [
            'order_data' => '受注データ',
            'order_import_setting_id' => '受注インポート設定',
        ];
    }
}
