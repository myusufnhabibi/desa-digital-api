<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'quantity' => 'nullable|integer|min:1',
            'payment_status' => 'nullable'
        ];
    }

    public function attributes(): array
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Kepala Keluarga',
            'quantity' => 'Jumlah',
            'payment_status' => 'Status Pembayaran'
        ];
    }
}
