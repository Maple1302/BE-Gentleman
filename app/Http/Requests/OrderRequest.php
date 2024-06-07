<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id', // Ki?m tra user_id c� t?n t?i trong b?ng users kh�ng
            'total_amount' => 'required|numeric|min:0', // S? ti?n ph?i l� s? v� kh�ng nh? h�n 0
            'status' => 'required|string|in:pending,completed,canceled', // Tr?ng th�i l� b?t bu?c v� ph?i l� m?t trong c�c gi� tr?: pending, completed, canceled
            'order_date' => 'required|date_format:Y-m-d', // Ng�y ph?i ��ng �?nh d?ng YYYY-MM-DD
            'voucher_id' => 'nullable|integer|exists:vouchers,id', // Voucher kh�ng b?t bu?c, ph?i l� s? nguy�n v� t?n t?i trong b?ng vouchers
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID l� b?t bu?c.',
            'user_id.integer' => 'User ID ph?i l� s? nguy�n.',
            'user_id.exists' => 'User ID kh�ng t?n t?i.',
            'total_amount.required' => 'T?ng s? ti?n l� b?t bu?c.',
            'total_amount.numeric' => 'T?ng s? ti?n ph?i l� s?.',
            'total_amount.min' => 'T?ng s? ti?n kh�ng ��?c nh? h�n 0.',
            'status.required' => 'Tr?ng th�i ��n h�ng l� b?t bu?c.',
            'status.string' => 'Tr?ng th�i ��n h�ng ph?i l� chu?i k? t?.',
            'status.in' => 'Tr?ng th�i ��n h�ng kh�ng h?p l?.',
            'order_date.required' => 'Ng�y �?t h�ng l� b?t bu?c.',
            'order_date.date_format' => 'Ng�y �?t h�ng kh�ng ��ng �?nh d?ng YYYY-MM-DD.',
            'voucher_id.integer' => 'Voucher ID ph?i l� s? nguy�n.',
            'voucher_id.exists' => 'Voucher ID kh�ng t?n t?i.',
        ];
    }
}
