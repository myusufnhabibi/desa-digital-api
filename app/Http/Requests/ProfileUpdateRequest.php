<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
     public function rules(): array
    {
        return [
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'headman' => 'required|string|max:255',
            'people' => 'required|integer|min:0',
            'agricultural_area' => 'required|numeric|min:0',
            'total_area' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function attributes() {
        return [
            'thumbnail' => 'Sampul',
            'name' => 'Nama Desa',
            'about' => 'Tentang Desa',
            'headman' => 'Kepala Desa',
            'people' => 'Jumlah Penduduk',
            'agricultural_area' => 'Luas Lahan Pertanian',
            'total_area' => 'Luas Wilayah'
        ];
    }
}
