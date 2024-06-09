<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'attribute_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'bill_id' => 'required|integer|exists:bills,id',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'T�n s?n ph?m l� b?t bu?c.',
            'product_name.string' => 'T�n s?n ph?m ph?i l� chu?i k? t?.',
            'product_name.max' => 'T�n s?n ph?m kh�ng ��?c v�?t qu� 255 k? t?.',
            'attribute_name.required' => 'T�n thu?c t�nh l� b?t bu?c.',
            'attribute_name.string' => 'T�n thu?c t�nh ph?i l� chu?i k? t?.',
            'attribute_name.max' => 'T�n thu?c t�nh kh�ng ��?c v�?t qu� 255 k? t?.',
            'price.required' => 'Gi� l� b?t bu?c.',
            'price.numeric' => 'Gi� ph?i l� s?.',
            'price.min' => 'Gi� kh�ng ��?c nh? h�n 0.',
            'quantity.required' => 'S? l�?ng l� b?t bu?c.',
            'quantity.integer' => 'S? l�?ng ph?i l� s? nguy�n.',
            'quantity.min' => 'S? l�?ng kh�ng ��?c nh? h�n 1.',
            'bill_id.required' => 'Bill ID l� b?t bu?c.',
            'bill_id.integer' => 'Bill ID ph?i l� s? nguy�n.',
            'bill_id.exists' => 'Bill ID kh�ng t?n t?i.',
        ];
    }
}
