<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
     public function rules(): array
    {
        return [
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255|in:staple,cash,subsidized_fuel,health',
            'amount' => 'required|numeric|min:0',
            'provider' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_available' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Nama',
            'category' => 'Kategori',
            'amount' => 'Jumlah Bantuan',
            'provider' => 'Penyedia',
            'description' => 'Desktripsi',
            'is_available' => 'Ketersediaan',
        ];
    }
}
