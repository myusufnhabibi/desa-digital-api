<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'quantity' => 'required|integer|min:1'
        ];
    }

    public function attributes(): array
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Kepala Keluarga',
            'quantity' => 'Jumlah',
            'total_price' => 'Total Harga',
            'payment_status' => 'Status Pembayaran',
        ];
    }
}
