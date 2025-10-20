<?php

namespace App\Repositories;

use App\Interfaces\DevelopmentApplicantInterface;
use App\Models\DevelopmentApplicant;
use Illuminate\Support\Facades\DB;

class DevelopmentApplicantRepository implements DevelopmentApplicantInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        // Implementation for fetching all development applicants
        $query = DevelopmentApplicant::where(function ($q) use ($search) {
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
            $applicant = new DevelopmentApplicant();
            $applicant->development_id = $data['development_id'];
            $applicant->user_id = $data['user_id'];
            $applicant->status = $data['status'];
            $applicant->save();
            DB::commit();
            return $applicant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        return DevelopmentApplicant::where('id', $id)->first();
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $applicant = DevelopmentApplicant::where('id', $id)->first();

            $applicant->development_id = $data['development_id'] ?? $applicant->development_id;
            $applicant->user_id = $data['user_id'] ?? $applicant->user_id;
            $applicant->status = $data['status'] ?? $applicant->status;
            $applicant->save();
            DB::commit();
            return $applicant;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $applicant = $this->getById($id);
            if ($applicant) {
                $applicant->delete();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
