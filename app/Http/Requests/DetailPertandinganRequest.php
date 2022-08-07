<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DetailPertandinganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'waktu' => ['required', 'date_format:H:i:s'],
            'pemain_id' => ['required', 'numeric'],
            'pertandingan_id' => ['required', 'numeric'],
        ];
    }
}
