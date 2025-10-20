<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\DevelopmentApplicantStoreRequest;
use App\Http\Requests\DevelopmentApplicantUpdateRequest;
use App\Http\Resources\DevelopmentApplicantResource;
use App\Http\Resources\PaginateResource;
use App\Interfaces\DevelopmentApplicantInterface;
use App\Models\Development;
use Illuminate\Http\Request;

class DevelopmentApplicantController extends Controller
{
    private DevelopmentApplicantInterface $developmentApplicantRepository;

    public function __construct(DevelopmentApplicantInterface $developmentApplicantRepository)
    {
        $this->developmentApplicantRepository = $developmentApplicantRepository;
    }

    public function index(Request $request)
    {
        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAll($request->search, $request->limit, true);

            return ResponseHelper::jsonResponse(true, 'Data development applicants berhasil diambil', DevelopmentApplicantResource::collection($developmentApplicants) , 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }

    public function getAllPaginated(Request $request)
    {
        $request = $request->validate([
            'search' => 'nullable|string|max:255',
            'row_per_page' => 'required|integer|min:1',
        ]);

        try {
            $developmentApplicants = $this->developmentApplicantRepository->getAllPaginated($request['search'] ?? null, $request['row_per_page']);

            return ResponseHelper::jsonResponse(true, 'Data development applicants berhasil diambil', PaginateResource::make($developmentApplicants, DevelopmentApplicantResource::class) , 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }

    public function store(DevelopmentApplicantStoreRequest $request)
    {
        $data = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->create($data);

            return ResponseHelper::jsonResponse(true, 'Development applicant berhasil dibuat', new DevelopmentApplicantResource($developmentApplicant), 201);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }
    public function show($id)
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);

            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data development applicant tidak ditemukan', null, 404);
            }

            return ResponseHelper::jsonResponse(true, 'Data development applicant berhasil diambil', new DevelopmentApplicantResource($developmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);
        }
    }

    public function update(DevelopmentApplicantUpdateRequest $request, $id) {
        $data = $request->validated();

        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data development applicant tidak ditemukan', null, 404);
            }

            $updatedDevelopmentApplicant = $this->developmentApplicantRepository->update($id, $data);
            return ResponseHelper::jsonResponse(true, 'Development applicant berhasil diperbarui', new DevelopmentApplicantResource($updatedDevelopmentApplicant), 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }

    public function destroy($id)
    {
        try {
            $developmentApplicant = $this->developmentApplicantRepository->getById($id);
            if (!$developmentApplicant) {
                return ResponseHelper::jsonResponse(false, 'Data development applicant tidak ditemukan', null, 404);
            }

            $this->developmentApplicantRepository->delete($id);
            return ResponseHelper::jsonResponse(true, 'Development applicant berhasil dihapus', null, 200);
        } catch (\Exception $e) {
            return ResponseHelper::jsonResponse(false, 'Terjadi kesalahan: ' . $e->getMessage(), null, 500);

        }
    }
}
