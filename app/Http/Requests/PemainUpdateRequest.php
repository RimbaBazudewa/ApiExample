<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PemainUpdateRequest extends FormRequest
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
            "tinggi_badan" => ['required', 'numeric'],
            "berat_badan" => ['required', 'numeric'],
            "posisi" => ['required', 'in:penyerang,gelandang, bertahan, penjaga gawang'],
            "no_punggung" => ['required', "numeric", Rule::unique('pemains')->where(function ($q) {
                return $q->where('no_punggung', $this->no_punggung)->where('tim_id', $this->tim_id);
            })->ignore($this->route('pemain'))],

            "tim_id" => 'required',

        ];
    }
}
