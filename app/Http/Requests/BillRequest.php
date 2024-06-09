<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    public function authorize()
    {
        return false;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'recipient_phone' => 'required|string|max:15|regex:/^[0-9]{10,15}$/',
            'recipient_address' => 'required|string|max:255',
            'voucher' => 'nullable|string|max:50',
            'total_amount' => 'required|numeric|min:0',
            'bill_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID l� b?t bu?c.',
            'user_id.integer' => 'User ID ph?i l� s? nguy�n.',
            'user_id.exists' => 'User ID kh�ng t?n t?i.',
            'recipient_phone.required' => 'S? �i?n tho?i ng�?i nh?n l� b?t bu?c.',
            'recipient_phone.string' => 'S? �i?n tho?i ng�?i nh?n ph?i l� chu?i k? t?.',
            'recipient_phone.max' => 'S? �i?n tho?i ng�?i nh?n kh�ng ��?c v�?t qu� 15 k? t?.',
            'recipient_phone.regex' => 'S? �i?n tho?i ng�?i nh?n kh�ng h?p l?.',
            'recipient_address.required' => '�?a ch? ng�?i nh?n l� b?t bu?c.',
            'recipient_address.string' => '�?a ch? ng�?i nh?n ph?i l� chu?i k? t?.',
            'recipient_address.max' => '�?a ch? ng�?i nh?n kh�ng ��?c v�?t qu� 255 k? t?.',
            'voucher.string' => 'Voucher ph?i l� chu?i k? t?.',
            'voucher.max' => 'Voucher kh�ng ��?c v�?t qu� 50 k? t?.',
            'total_amount.required' => 'T?ng s? ti?n l� b?t bu?c.',
            'total_amount.numeric' => 'T?ng s? ti?n ph?i l� s?.',
            'total_amount.min' => 'T?ng s? ti?n kh�ng ��?c nh? h�n 0.',
            'bill_date.required' => 'Ng�y h�a ��n l� b?t bu?c.',
            'bill_date.date_format' => 'Ng�y h�a ��n kh�ng ��ng �?nh d?ng YYYY-MM-DD.',
        ];
    }
}
