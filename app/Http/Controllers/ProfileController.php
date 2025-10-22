<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\ProfileStoreRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\ProfileResource;
use Illuminate\Http\Request;
use App\Interfaces\ProfileInterface;
use App\Models\Profile;

class ProfileController extends Controller
{
    private ProfileInterface $profileRepository;

    public function __construct(ProfileInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function index() {
        try {
            $profiles = $this->profileRepository->get();

            if (!$profiles) {
                return ResponseHelper::jsonResponse(false, 'Data profile tidak ditemukan', null, 404);
            }

            // return ResponseHelper::jsonResponse(true, 'Data profiles berhasil diambil', ProfileResource::collection($profiles) , 200);
            return ResponseHelper::jsonResponse(true, 'Data profile berhasil diambil', new ProfileResource($profiles) , 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }

    public function store(ProfileStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $profile = $this->profileRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Profile berhasil dibuat', new ProfileResource($profile), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        $data = $request->validated();

        try {
            // $profiles = $this->profileRepository->get();

            // if (!$profiles) {
            //     return ResponseHelper::jsonResponse(false, 'Data profile tidak ditemukan', null, 404);
            // }

            $profile = $this->profileRepository->update($data);

            return ResponseHelper::jsonResponse(true, 'Profile berhasil diperbarui', new ProfileResource($profile), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }
}
