<?php

namespace App\Repositories;

use App\Interfaces\DevelopmentInterface;
use App\Models\Development as ModelsDevelopment;
use Illuminate\Support\Facades\DB;

class DevelopmentRepository implements DevelopmentInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = ModelsDevelopment::where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        });

        if ($limit) {
            $query->take($limit);
        }
        $query->orderBy('created_at', 'DESC');
        if ($excecute) {
            return $query->get();
        }

        // When not executing, return the query builder so callers can paginate or further modify it
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

            $development = new ModelsDevelopment();
            $development->thumbnail = $data['thumbnail']->store('assets/development', 'public');
            $development->name = $data['name'];
            $development->description = $data['description'];
            $development->person_in_charge = $data['person_in_charge'];
            $development->start_date = $data['start_date'];
            $development->end_date = $data['end_date'];
            $development->amount = $data['amount'];
            $development->status = $data['status'];
            $development->save();
            DB::commit();
            return $development;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        return ModelsDevelopment::where('id', $id)->first();
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $development = $this->getById($id);
            if (isset($data['thumbnail'])) {
                $development->thumbnail = $data['thumbnail']->store('assets/development', 'public');
            }
            $development->name = $data['name'];
            $development->description = $data['description'];
            $development->person_in_charge = $data['person_in_charge'];
            $development->start_date = $data['start_date'];
            $development->end_date = $data['end_date'];
            $development->amount = $data['amount'];
            $development->status = $data['status'];
            $development->save();
            DB::commit();
            return $development;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $development = $this->getById($id);
            $development->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }


}
