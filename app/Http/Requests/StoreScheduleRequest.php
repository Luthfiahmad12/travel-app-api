<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'travel_name' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'quota' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'travel_name.required' => 'Nama travel wajib diisi.',
            'travel_name.string' => 'Nama travel harus berupa teks.',
            'travel_name.max' => 'Nama travel maksimal 255 karakter.',

            'departure_time.required' => 'Tanggal dan waktu keberangkatan wajib diisi.',
            'departure_time.date' => 'Format tanggal keberangkatan tidak valid.',

            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota minimal 1.',

            'price.required' => 'Harga tiket wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga minimal Rp 0.',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data'    => $validator->errors()
        ], 422));
    }
}
