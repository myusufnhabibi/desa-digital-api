<?php

namespace App\Repositories;

use App\Models\HeadOfFamily;
use Illuminate\Support\Facades\DB;

class HeadOfFamilyRepository implements \App\Interfaces\HeadOfFamilyInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = HeadOfFamily::where(function ($q) use ($search) {
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
            $userRepository = new UserRepository();
            $user = $userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            $headOfFamily = new HeadOfFamily();
            $headOfFamily->user_id = $user->id;
            $headOfFamily->profile_picture = $data['profile_picture']->store('assets/profile_pictures', 'public');
            $headOfFamily->identity_number = $data['identity_number'];
            $headOfFamily->gender = $data['gender'];
            $headOfFamily->date_of_birth = $data['date_of_birth'];
            $headOfFamily->phone_number = $data['phone_number'];
            $headOfFamily->ocupation = $data['ocupation'];
            $headOfFamily->marital_status = $data['marital_status'];

            $headOfFamily->save();
            DB::commit();
            return $headOfFamily;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
