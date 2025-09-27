<?php

namespace App\Repositories;

use App\Interfaces\FamilyMemberInterface;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\DB;

class FamilyMemberRepository implements FamilyMemberInterface
{
    public function getAll(?string $search, ?int $limit, bool $excecute)
    {
        $query = FamilyMember::where(function ($q) use ($search) {
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

            $familyMember = new FamilyMember();
            $familyMember->head_of_family_id = $data['head_of_family_id'];
            $familyMember->user_id = $user->id;
            $familyMember->profile_picture = $data['profile_picture']->store('assets/family_members', 'public');
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->ocupation = $data['ocupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->save();

            DB::commit();
            return $familyMember;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

    public function show(string $id)
    {
        return FamilyMember::where('id', $id)->with('headOfFamily')->first();
    }

    public function update(string $id, array $data) {
        DB::beginTransaction();
        try {
            $familyMember = FamilyMember::findOrFail($id);

            if (isset($data['profile_picture'])) {
                $familyMember->profile_picture = $data['profile_picture']->store('assets/family_member', 'public');
            }
            $familyMember->identity_number = $data['identity_number'];
            $familyMember->gender = $data['gender'];
            $familyMember->date_of_birth = $data['date_of_birth'];
            $familyMember->phone_number = $data['phone_number'];
            $familyMember->ocupation = $data['ocupation'];
            $familyMember->marital_status = $data['marital_status'];
            $familyMember->relation = $data['relation'];
            $familyMember->save();

            $userRepository = new UserRepository();
            $userRepository->update($familyMember->user_id, [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'] ?? null,
            ]);

            DB::commit();
            return $familyMember;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    public function delete(string $id)
    {
        DB::beginTransaction();
        try {
            $familyMember = FamilyMember::find($id);
            $familyMember->delete();
             DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

    }

}
