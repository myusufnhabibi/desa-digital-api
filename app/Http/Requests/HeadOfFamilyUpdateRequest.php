<?php

namespace App\Http\Requests;

use App\Models\HeadOfFamily;
use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . HeadOfFamily::find($this->route('head_of_family'))->user_id,
            'password' => 'nullable|string|min:8',
            "profile_picture" => "nullable|image|mimes:jpeg,png,jpg|max:2048",
            "identity_number" => "required|string|max:20|unique:head_of_families",
            "gender"=> "required|in:male,female",
            "date_of_birth" => "required|date",
            "phone_number" => "required|string|max:15",
            "ocupation" => "required|string|max:100",
            "marital_status" => "required|in:single,married"
        ];
    }

    public function attributes(): array
    {
        return [
            "profile_picture" => "Foto Profil",
            "identity_number" => "Nomor Identitas",
            "gender" => "Jenis Kelamin",
            "date_of_birth" => "Tanggal Lahir",
            "phone_number" => "Nomor Telepon",
            "ocupation" => "Pekerjaan",
            "marital_status" => "Status Perkawinan"
        ];
    }

}
