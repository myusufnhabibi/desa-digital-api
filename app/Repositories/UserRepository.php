<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository implements \App\Interfaces\UserRepositoryInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = User::where(function ($q) use ($search) {
            if ($search) {
                $q->search($search);
            }
        });

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
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function getById(string $id)
    {
        $user = User::where('id', $id)->first();
        return $user;
    }

    public function update(string $id, array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            $user->name = $data['name'];
            if (isset($data['password'])) {
                $user->password = Hash::make($data['password']);
            }
            $user->save();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);
            $user->delete();
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
