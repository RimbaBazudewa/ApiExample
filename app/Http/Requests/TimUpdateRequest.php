<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\File;

class TimUpdateRequest extends FormRequest
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
            "nama"  => 'required',
            "logo" => ['sometimes', 'nullable', File::image()->max(5 * 1024)],
            "tahun" => ['required', 'string', 'min:4'],
            "alamat" => 'required',
            "kota" => 'required',
        ];
    }
}
