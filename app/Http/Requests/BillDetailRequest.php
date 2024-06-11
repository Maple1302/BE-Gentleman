<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BillDetailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'data' => 'required|array',
            'data.*.product_name' => 'required|string|max:255',
            'data.*.attribute_name' => 'required|string|max:255',
            'data.*.price' => 'required|numeric|min:0',
            'data.*.quantity' => 'required|integer|min:1',
            'data.*.bill_id' => 'required|integer|exists:bills,id',
            'data.*.voucher' => 'nullable|string|max:50'
        ];
    }

    public function messages()
    {
        return [
            'data.required' => 'D? li?u l� b?t bu?c.',
            'data.array' => 'D? li?u ph?i l� m?t m?ng.',
            'data.*.product_name.required' => 'T�n s?n ph?m l� b?t bu?c.',
            'data.*.product_name.string' => 'T�n s?n ph?m ph?i l� chu?i k? t?.',
            'data.*.product_name.max' => 'T�n s?n ph?m kh�ng ��?c v�?t qu� 255 k? t?.',
            'data.*.attribute_name.required' => 'T�n thu?c t�nh l� b?t bu?c.',
            'data.*.attribute_name.string' => 'T�n thu?c t�nh ph?i l� chu?i k? t?.',
            'data.*.attribute_name.max' => 'T�n thu?c t�nh kh�ng ��?c v�?t qu� 255 k? t?.',
            'data.*.price.required' => 'Gi� l� b?t bu?c.',
            'data.*.price.numeric' => 'Gi� ph?i l� s?.',
            'data.*.price.min' => 'Gi� kh�ng ��?c nh? h�n 0.',
            'data.*.quantity.required' => 'S? l�?ng l� b?t bu?c.',
            'data.*.quantity.integer' => 'S? l�?ng ph?i l� s? nguy�n.',
            'data.*.quantity.min' => 'S? l�?ng kh�ng ��?c nh? h�n 1.',
            'data.*.bill_id.required' => 'ID h�a ��n l� b?t bu?c.',
            'data.*.bill_id.integer' => 'ID h�a ��n ph?i l� s? nguy�n.',
            'data.*.bill_id.exists' => 'ID h�a ��n kh�ng t?n t?i.',
            'data.*.voucher.string' => 'M? gi?m gi� ph?i l� chu?i k? t?.',
            'data.*.voucher.max' => 'M? gi?m gi� kh�ng ��?c v�?t qu� 50 k? t?.',
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
