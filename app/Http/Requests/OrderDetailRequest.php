<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderDetailRequest extends FormRequest
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
            'variant_id' => 'required|integer|exists:variants,id', // Ki?m tra variant_id c� t?n t?i trong b?ng variants kh�ng
            'order_id' => 'required|integer|exists:orders,id', // Ki?m tra order_id c� t?n t?i trong b?ng orders kh�ng
            'status' => 'required|string|in:pending,shipped,delivered,canceled', // Tr?ng th�i l� b?t bu?c v� ph?i l� m?t trong c�c gi� tr?: pending, shipped, delivered, canceled
            'quantity' => 'required|integer|min:1', // S? l�?ng l� b?t bu?c, ph?i l� s? nguy�n v� kh�ng nh? h�n 1
        ];
    }

    public function messages()
    {
        return [
            'variant_id.required' => 'Variant ID l� b?t bu?c.',
            'variant_id.integer' => 'Variant ID ph?i l� s? nguy�n.',
            'variant_id.exists' => 'Variant ID kh�ng t?n t?i.',
            'order_id.required' => 'Order ID l� b?t bu?c.',
            'order_id.integer' => 'Order ID ph?i l� s? nguy�n.',
            'order_id.exists' => 'Order ID kh�ng t?n t?i.',
            'status.required' => 'Tr?ng th�i ��n h�ng l� b?t bu?c.',
            'status.string' => 'Tr?ng th�i ��n h�ng ph?i l� chu?i k? t?.',
            'status.in' => 'Tr?ng th�i ��n h�ng kh�ng h?p l?.',
            'quantity.required' => 'S? l�?ng l� b?t bu?c.',
            'quantity.integer' => 'S? l�?ng ph?i l� s? nguy�n.',
            'quantity.min' => 'S? l�?ng kh�ng ��?c nh? h�n 1.',
        ];
    }
}
