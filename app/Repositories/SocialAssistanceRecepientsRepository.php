<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceRecepientsInterface;
use App\Models\SocialAssistance;
use App\Models\SocialAssistanceRecepient;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRecepientsRepository implements SocialAssistanceRecepientsInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = SocialAssistanceRecepient::where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        });

        $query->orderBy('created_at', 'DESC');

        if ($limit) {
            $query->take($limit);
        }

        if ($excecute) {
            return $query->get();
        }

        return $query;
    }

    public function getAllPaginated(?string $search, ?int $rowPerPage)
    {
        $query = $this->getAll($search, $rowPerPage, false);

        return $query->paginate($rowPerPage);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $assistanceRecepient = new SocialAssistanceRecepient();
            $assistanceRecepient->social_assistance_id = $data['social_assistance_id'];
            $assistanceRecepient->head_of_family_id = $data['head_of_family_id'];
            $assistanceRecepient->amount = $data['amount'];
            $assistanceRecepient->reason = $data['reason'];
            $assistanceRecepient->bank = $data['bank'];
            $assistanceRecepient->account_number = $data['account_number'];

            if (isset($data['proof'])) {
                $assistanceRecepient->proof = $data['proof'];
            }

            if (isset($data['status'])) {
                $assistanceRecepient->status = $data['status'];
            }
            $assistanceRecepient->save();

            DB::commit();
            return $assistanceRecepient;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function show(string $id)
    {
        return SocialAssistanceRecepient::where('id', $id)->with('headOfFamily')->first();
    }

    public function update(string $id, array $data) {
        DB::beginTransaction();
        try {
            $assistanceRecepient = SocialAssistanceRecepient::find($id);

            $assistanceRecepient = new SocialAssistanceRecepient();
            $assistanceRecepient->social_assistance_id = $data['social_assistance_id'];
            $assistanceRecepient->head_of_family_id = $data['head_of_family_id'];
            $assistanceRecepient->amount = $data['amount'];
            $assistanceRecepient->reason = $data['reason'];
            $assistanceRecepient->bank = $data['bank'];
            $assistanceRecepient->account_number = $data['account_number'];

            if (isset($data['proof'])) {
                $assistanceRecepient->proof = $data['proof'];
            }

            if (isset($data['status'])) {
                $assistanceRecepient->status = $data['status'];
            }
            $assistanceRecepient->save();

            DB::commit();
            return $assistanceRecepient;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $assistanceRecepient = SocialAssistanceRecepient::find($id);
            $assistanceRecepient->delete();
             DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

}
