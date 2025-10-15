<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceRecepientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'social_assistance_id' => new SocialAssistanceResource($this->socialAssistance),
            'head_of_family_id' => new HeadOfFamilyResource($this->headOfFamily),
            'amount' => $this->amount,
            'reason' => $this->reason,
            'bank' => $this->bank,
            'account_number' => $this->account_number,
            'proof' => $this->proof,
            'status' => $this->status,
        ];
    }
}
