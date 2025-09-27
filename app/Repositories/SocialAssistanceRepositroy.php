<?php

namespace App\Repositories;

use App\Interfaces\SocialAssistanceInterface;
use App\Models\SocialAssistance;
use Illuminate\Support\Facades\DB;

class SocialAssistanceRepositroy implements SocialAssistanceInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = SocialAssistance::where(function ($q) use ($search) {
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
            $socialAssistance = new SocialAssistance();
            $socialAssistance->thumbnail = $data['thumbnail']->store('assets/thumbnail', 'public');
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];
            $socialAssistance->save();

            DB::commit();
            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function show(string $id)
    {
        return SocialAssistance::where('id', $id)->first();
    }

    public function update(string $id, array $data) {
        DB::beginTransaction();
        try {
            $socialAssistance = SocialAssistance::findOrFail($id);

            if (isset($data['thumbnail'])) {
                $socialAssistance->thumbnail = $data['thumbnail']->store('assets/thumbnail', 'public');
            }
            $socialAssistance->name = $data['name'];
            $socialAssistance->category = $data['category'];
            $socialAssistance->amount = $data['amount'];
            $socialAssistance->provider = $data['provider'];
            $socialAssistance->description = $data['description'];
            $socialAssistance->is_available = $data['is_available'];
            $socialAssistance->save();

            DB::commit();
            return $socialAssistance;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $familyMember = SocialAssistance::find($id);
            $familyMember->delete();
             DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

}
