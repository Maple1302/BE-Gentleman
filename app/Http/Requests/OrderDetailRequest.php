<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
            'voucher_id' => 'nullable|integer|exists:vouchers,id'
        ];
    }

    public function messages()
    {
        return [
            'variant_id.required' => 'Variant ID la bat buoc.',
            'variant_id.integer' => 'Variant ID phai la so nguyen.',
            'variant_id.exists' => 'Variant ID khong ton tai.',
            'order_id.required' => 'Order ID la bat buoc.',
            'order_id.integer' => 'Order ID phai la so nguyen.',
            'order_id.exists' => 'Order ID khong ton tai.',
            'status.required' => 'Trang thai don hang la bat buoc.',
            'status.string' => 'Trang thai don hang phai la chuoi ky tu.',
            'status.in' => 'Trang thai don hang khong hop le.',
            'quantity.required' => 'So luong la bat buoc.',
            'quantity.integer' => 'So luong phai la so nguyen.',
            'quantity.min' => 'So luong khong duoc nho hon 1.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'error' => $errors,
                'status_code' => 402,
            ],
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ));
    }
}
