<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevelopmentStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'person_in_charge' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:on_progress,completed',
        ];
    }

    public function attributes(): array
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Nama',
            'description' => 'Deskripsi',
            'person_in_charge' => 'Penanggung Jawab',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'amount' => 'Jumlah',
            'status' => 'Status',
        ];
    }
}
