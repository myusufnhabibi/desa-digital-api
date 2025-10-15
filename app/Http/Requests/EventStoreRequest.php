<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            "thumbnail" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "name" => "required|string|max:255",
            "description" => "nullable|string",
            "price" => "nullable|numeric|min:1000",
            "date" => "required|date",
            "time" => "required|string",
            "is_active" => "required|boolean",
        ];
    }

    public function attributes(): array
    {
        return [
           "thumbnail" => "thumbnail",
           "name" => "nama",
           "description" => "deskripsi",
           "price" => "harga",
           "date" => "tanggal",
           "time" => "waktu",
           "is_active" => "status aktif",
        ];
    }
}
